<?php

require('admin/includes/db_config.php');
require('admin/includes/essentials.php');

date_default_timezone_set("Africa/Porto-Novo");

session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
    redirect('index.php');
}


if (isset($_POST['pay_now'])) {

    // filtrage des données
    $frm_data = filteration($_POST);

    $ORDER_ID = 'ORD_' . $_SESSION['uId'] . random_int(11111, 9999999);
    $CUST_ID = $_SESSION['uId'];
    $TXN_AMOUNT = $_SESSION['room']['payment'];

    // Insert payment data into database

    $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`, `order_id`, `booking_status`, `trans_amount`, `trans_status`) VALUES (?,?,?,?,?,?,?,?)";

    insert($query1, [$CUST_ID, $_SESSION['room']['id'], $frm_data['checkin'], $frm_data['checkout'], $ORDER_ID, 'booked', $TXN_AMOUNT, 'TXN_SUCCESS'], 'isssssis');

    $booking_id = mysqli_insert_id($con);

    $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`, `nationality`, `profession`, `motif`) VALUES (?,?,?,?,?,?,?,?,?,?)";

    insert($query2, [$booking_id, $_SESSION['room']['name'], $_SESSION['room']['price'], $TXN_AMOUNT, $frm_data['name'], $frm_data['phonenum'], $frm_data['address'], $frm_data['nationality'], $frm_data['profession'], $frm_data['motif']], 'isssssssss');

    redirect('pay_status.php?order='.$ORDER_ID);
}

?>
