<?php

require('../includes/db_config.php');
require('../includes/essentials.php');
//fonction de connexion de l'admin, definie dans admin/includes/essentials.php
adminLogin();

if (isset($_POST['get_bookings'])) {

    $frm_data = filteration($_POST);

    $limit = 10;
    $page = $frm_data['page'];
    $start = ($page-1) * $limit;

    // page 1: 0,10, page2: 10,10, page 3: 20,10

    // cette requete selection toutes infos sur les reservation mais permet de fait le tri/(systeme de recherche suivant l'ID de l'orde de reservation ou le nom dutilisateur ou son numero de telephone)

    $query = "SELECT bo.*,bd.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
    OR (bo.booking_status = 'cancelled'))
    AND (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
    ORDER BY bo.booking_id DESC";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

    $limit_query = $query ." LIMIT $start,$limit";

    $limit_res = select($limit_query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"],'sss');

    $total_rows = mysqli_num_rows($res);

    if($total_rows==0){
        $output = json_encode(["table_data" => "<b>Aucune donnee trouvée!</b>", "pagination" => '']);
        echo $output;
        exit;
    }

    $i = $start+1;
    $table_data = "";

    while ($data = mysqli_fetch_assoc($limit_res)) {

        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

        if($data['booking_status']=='booked'){
            $status_bg = 'bg-success';
            $badge_span = "réservé";
        }else if($data['booking_status']=='cancelled'){
            $status_bg = 'bg-danger';
            $badge_span = "annulé";
        }

        $table_data .= "
            <tr>
                <td>$i</td>
                <td>
                    <span class='badge bg-primary'>
                        Order ID: $data[order_id]
                    </span>
                    <br>
                    <b>Nom: </b> $data[user_name]
                    <br>
                    <b>Téléphone: </b> $data[phonenum]
                </td>
                <td>
                    <b>Chambre: </b> $data[room_name]
                    <br>
                    <b>Prix: </b> $data[price] FCFA
                </td>
                <td>
                    <b>Montant total: </b> $data[trans_amount] FCFA
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

    if($total_rows > $limit){

        $total_pages = ceil($total_rows/$limit);

        if($page!=1){
            $pagination .="<li class='page-item'>
                <button onclick='change_page(1)' class='page-link shadow-none'>Début</button>
            </li>";
        }

        $disabled = ($page==1) ? "disabled" : "";
        $prev = $page-1;
        $pagination .="<li class='page-item $disabled'>
            <button onclick='change_page($prev)' class='page-link shadow-none'>Précédant</button>
        </li>";

        $disabled = ($page==$total_pages) ? "disabled" : "";
        $next = $page+1;
        $pagination .="<li class='page-item $disabled'>
            <button onclick='change_page($next)' class='page-link shadow-none'>Suivant</button>
        </li>";

        if($page!=$total_pages){
            $pagination .="<li class='page-item'>
                <button onclick='change_page($total_pages)' class='page-link shadow-none'>Fin</button>
            </li>";
        }
    }

    $output = json_encode(["table_data" => $table_data, "pagination" => $pagination]);
    echo $output;
    //echo $table_data;
}


