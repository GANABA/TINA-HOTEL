<?php

require('../admin/includes/db_config.php');
require('../admin/includes/essentials.php');

//require '../vendor/autoload.php';

date_default_timezone_set("Africa/Porto-Novo");

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
        session_start();
        //$_SESSION['room'];

        // run query to check room is available or not
        $tb_query = "SELECT COUNT(*) AS `total_bookings` FROM `booking_order`
                WHERE booking_status=? AND room_id=?
                AND check_out > ? AND check_in < ?";

        $values = ['booked',$_SESSION['room']['id'],$frm_data['check_in'],$frm_data['check_out']];

        $tb_fetch = mysqli_fetch_assoc(select($tb_query, $values, 'siss'));

        // Vérification des réservations hors ligne (booking_offline)
        $offline_query = "SELECT COUNT(*) AS `total_offline_bookings` FROM `booking_offline`
         WHERE room_id=? AND check_out > ? AND check_in < ?";
        $offline_values = [$_SESSION['room']['id'], $frm_data['check_in'], $frm_data['check_out']];
        $offline_fetch = mysqli_fetch_assoc(select($offline_query, $offline_values, 'iss'));

        $rq_result = select("SELECT `quantity` FROM `rooms` WHERE `id`=?",[$_SESSION['room']['id']],'i');
        $rq_fetch = mysqli_fetch_assoc($rq_result);

        // Total des réservations en ligne et hors ligne
        $total_bookings = $tb_fetch['total_bookings'] + $offline_fetch['total_offline_bookings'];

        if(($rq_fetch['quantity'] - $total_bookings) <= 0){
            $status = 'unavailable';
            $result = json_encode(['status' => $status]);
            echo $result;
            exit;
        }

        // calcul du nombre de jours pour la reservation
        $count_days = date_diff($checkin_date, $checkout_date)->days;
        // calcul du montant total à payer
        $payment = $_SESSION['room']['price'] * $count_days;

        $_SESSION['room']['payment'] = $payment;
        $_SESSION['room']['available'] = true;

        $result = json_encode(["status" => 'available', "days" => $count_days, "payment" => $payment]);
        echo $result;
    }
}
