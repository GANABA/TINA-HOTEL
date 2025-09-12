<?php

require('../includes/db_config.php');
require('../includes/essentials.php');
//fonction de connection de l'admin definie dans admin/includes/essentials.php
adminLogin();

if (isset($_POST['get_bookings'])) {

    $frm_data = filteration($_POST);

    // cette requete selection toutes infos sur les reservation mais permet de fait le tri/(systeme de recherche suivant l'ID de l'orde de reservation ou le nom dutilisateur ou son numero de telephone)

    $query = "SELECT bo.*,bd.* FROM `booking_order` bo
    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
    WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
    AND (bo.booking_status = ? AND bo.arrival = ?) ORDER BY bo.booking_id DESC";

    $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","booked",0],'sssss');

    $i = 1;
    $table_data = "";

    if(mysqli_num_rows($res)==0){
        echo "<b>Aucune donnée trouvée!</b>";
    }

    while ($data = mysqli_fetch_assoc($res)) {

        $date = date("d-m-Y", strtotime($data['datentime']));
        $checkin = date("d-m-Y", strtotime($data['check_in']));
        $checkout = date("d-m-Y", strtotime($data['check_out']));

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
                    <button type='button' onclick='assign_room($data[booking_id])' class='btn text-white btn-sm fw-bold custum-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
                        <i class='bi bi-check2-square'></i> Assigner une chambre
                    </button>
                    <br>
                    <button type='button' onclick='cancel_booking($data[booking_id])' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none'>
                        <i class='bi bi-trash'></i> Annuler la réservation
                    </button>
                </td>
            </tr>
        ";

        $i++;
    }

    echo $table_data;
}

if (isset($_POST['assign_room'])) {

    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd
        ON bo.booking_id = bd.booking_id
        SET bo.arrival = ?, bo.rate_review = ?, bd.room_no = ?
        WHERE bo.booking_id = ?";

    $values = [1,0,$frm_data['room_no'],$frm_data['booking_id']];
    
    $res = update($query, $values, 'iisi');

    echo ($res == 2) ? 1 : 0; // it will update 2 rows so it will return 2
}

if (isset($_POST['cancel_booking'])) {

    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` SET `booking_status` = ? WHERE `booking_id` = ?";

    $values = ['cancelled', $frm_data['booking_id']];

    $res = update($query, $values, 'si');

    echo $res;

}

