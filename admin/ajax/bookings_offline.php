<?php

require('../includes/db_config.php');
require('../includes/essentials.php');
//fonction de connexion de l'admin, definie dans admin/includes/essentials.php
adminLogin();

//nouvelle reservation hors ligne
if (isset($_POST['book_room'])) {

    $data = filteration($_POST);

    $query = "INSERT INTO `booking_offline` (`name`, `nationality`, `profession`, `phonenum`, `address`, `motif`, `room_id`, `room_no`, `check_in`, `check_out`, `trans_amount`) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

    $values = [$data['client_name'], $data['nationalite'], $data['profession'], $data['phone'], $data['address'], $data['motif'], $data['room_id'], $data['room_number'], $data['arrival_date'], $data['departure_date'], $data['total_amount']];

    if (insert($query, $values, 'ssssssissss')) {
        echo 1;
    } else {
        echo 0;
    }
}

//check availability
if (isset($_POST['check_availability'])) {

    $frm_data = filteration($_POST);
    $status = "";
    $result = "";

    // check in and out validations

    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($frm_data['check_in']);
    $checkout_date = new DateTime($frm_data['check_out']);

    if ($checkin_date == $checkout_date) {
        $status = 'check_in_out_equal';
        $result = json_encode(['status' => $status]);
    } else if ($checkout_date < $checkin_date) {
        $status = 'check_out_earlier';
        $result = json_encode(['status' => $status]);
    } else if ($checkin_date < $today_date) {
        $status = 'check_in_earlier';
        $result = json_encode(['status' => $status]);
    }

    // check booking availability if status is blank else return the error

    if ($status != '') {
        echo $result;
        exit;
    } else {
        // Vérification des réservations en ligne (booking_order)
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
            WHERE booking_status=? AND room_id=?
            AND check_out > ? AND check_in < ?";
        $values = ['booked', $frm_data['room_id'], $frm_data['check_in'], $frm_data['check_out']];
        $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'siss'));

        // Vérification des réservations hors ligne (booking_offline)
        $offline_query = "SELECT COUNT(*) AS `total_offline_bookings` FROM `booking_offline`
            WHERE room_id=? AND check_out > ? AND check_in < ?";
        $offline_values = [$frm_data['room_id'], $frm_data['check_in'], $frm_data['check_out']];
        $offline_fetch = mysqli_fetch_assoc(select($offline_query, $offline_values, 'iss'));

        // Récupérer la quantité totale de chambres disponibles
        $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `id`=?", [$frm_data['room_id']], 'i');
        $rq_fetch = mysqli_fetch_assoc($rq_result);

        // Total des réservations en ligne et hors ligne
        $total_bookings = $tb_fetch['total_bookings'] + $offline_fetch['total_offline_bookings'];

        if (($rq_fetch['quantity'] - $total_bookings) <= 0) {
            $status = 'unavailable';
            $result = json_encode(['status' => $status]);
            echo $result;
            exit;
        }
    }
}

//get bookings
if (isset($_POST['get_bookings'])) {

    $frm_data = filteration($_POST);

    $limit = 10;
    $page = $frm_data['page'];
    $start = ($page - 1) * $limit;

    // page 1: 0,10, page2: 10,10, page 3: 20,10

    // cette requete selection toutes infos sur les reservation mais permet de fait le tri/(systeme de recherche suivant l'ID de l'orde de reservation ou le nom dutilisateur ou son numero de telephone)

    $query = "SELECT bo.*, bo.id AS booking_id, r.name AS room_name, r.price
        FROM booking_offline bo
        INNER JOIN rooms r ON bo.room_id = r.id
        WHERE (bo.name LIKE ? OR bo.phonenum LIKE ?)
        ORDER BY bo.id DESC";

    $res = select($query, ["%$frm_data[search]%", "%$frm_data[search]%"], 'ss');

    $limit_query = $query . " LIMIT $start,$limit";

    $limit_res = select($limit_query, ["%$frm_data[search]%", "%$frm_data[search]%"], 'ss');

    $total_rows = mysqli_num_rows($res);

    if ($total_rows == 0) {
        $output = json_encode(["table_data" => "<b>Aucune donnée trouvée!</b>", "pagination" => '']);
        echo $output;
        exit;
    }

    $i = $start + 1;
    $table_data = "";

    while ($data = mysqli_fetch_assoc($limit_res)) {

        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        $status_bg = 'bg-success';
        $badge_span = "réservé";

        $table_data .= "
            <tr>
                <td>$i</td>
                <td>
                    <b>Nom: </b> $data[name]
                    <br>
                    <b>Téléphone: </b> $data[phonenum]
                    <br>
                    <b>Nationalité: </b> $data[nationality]
                    <br>
                    <b>Profession: </b> $data[profession]
                    <br>
                    <b>Provenance: </b> $data[address]
                </td>
                <td>
                    <b>Chambre: </b> $data[room_name]
                    <br>
                    <b>Prix: </b> $data[price] FCFA
                </td>
                <td>
                    <b>Entrée: </b> $checkin
                    <br>
                    <b>Sortie: </b> $checkout
                    <br>
                    <b>Montant total: </b> $data[trans_amount] FCFA
                    <br>
                    <b>Motif: </b> $data[motif]
                    <br>
                    <b>Date: </b> $date
                </td>
                <td>
                    <span class='badge $status_bg'>$badge_span</span>
                </td>
                <td>
                    <button type='button' onclick='download($data[booking_id])' class='btn btn-outline-success btn-sm fw-bold shadow-none'>
                        <i class='bi bi-file-earmark-arrow-down-fill'></i>
                    </button>
                </td>
            </tr>
        ";

        $i++;
    }

    $pagination = "";

    if ($total_rows > $limit) {

        $total_pages = ceil($total_rows / $limit);

        if ($page != 1) {
            $pagination .= "<li class='page-item'>
                <button onclick='change_page(1)' class='page-link shadow-none'>Début</button>
            </li>";
        }

        $disabled = ($page == 1) ? "disabled" : "";
        $prev = $page - 1;
        $pagination .= "<li class='page-item $disabled'>
            <button onclick='change_page($prev)' class='page-link shadow-none'>Précédant</button>
        </li>";

        $disabled = ($page == $total_pages) ? "disabled" : "";
        $next = $page + 1;
        $pagination .= "<li class='page-item $disabled'>
            <button onclick='change_page($next)' class='page-link shadow-none'>Suivant</button>
        </li>";

        if ($page != $total_pages) {
            $pagination .= "<li class='page-item'>
                <button onclick='change_page($total_pages)' class='page-link shadow-none'>Fin</button>
            </li>";
        }
    }

    $output = json_encode(["table_data" => $table_data, "pagination" => $pagination]);
    echo $output;
    //echo $table_data;
}
