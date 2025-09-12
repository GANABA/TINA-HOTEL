<?php

require('../includes/db_config.php');
require('../includes/essentials.php');
//fonction de connexion de l'admin, definie dans admin/includes/essentials.php
adminLogin();

if (isset($_POST['booking_analytics'])) {

    $frm_data = filteration($_POST);

    $condition = "";

    if($frm_data['period'] == 1){
        $condition= "WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
    }else if($frm_data['period'] == 2){
        $condition= "WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
    }else if($frm_data['period'] == 3){
        $condition= "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    $query = "
        SELECT 
            -- Total des réservations
            (COUNT(CASE WHEN booking_status!='pending' THEN 1 END) + 
            (SELECT COUNT(*) FROM booking_offline $condition)) AS total_bookings,

            -- Montant total des réservations
            (SUM(CASE WHEN booking_status!='pending' THEN trans_amount END) + 
            (SELECT SUM(trans_amount) FROM booking_offline $condition)) AS total_amt,

            -- Réservations actives (booking_status='booked' et arrival=1 + les réservations hors ligne où une chambre est assignée)
            (COUNT(CASE WHEN booking_status='booked' AND arrival=1 THEN 1 END) + 
            (SELECT COUNT(*) FROM booking_offline $condition)) AS active_bookings,

            -- Montant des réservations actives
            (SUM(CASE WHEN booking_status='booked' AND arrival=1 THEN trans_amount END) + 
            (SELECT SUM(trans_amount) FROM booking_offline $condition)) AS active_amt,

            -- Réservations annulées
            COUNT(CASE WHEN booking_status='cancelled' THEN 1 END) AS cancelled_bookings,

            -- Montant des réservations annulées
            SUM(CASE WHEN booking_status='cancelled' THEN trans_amount END) AS cancelled_amt
        FROM booking_order $condition";

    $result = mysqli_fetch_assoc(mysqli_query($con, $query));

    echo json_encode($result);
}

if (isset($_POST['user_analytics'])) {

    $frm_data = filteration($_POST);

    $condition = "";

    if($frm_data['period'] == 1){
        $condition= "WHERE datentime BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
    }else if($frm_data['period'] == 2){
        $condition= "WHERE datentime BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
    }else if($frm_data['period'] == 3){
        $condition= "WHERE datentime BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
    }

    $total_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
        FROM `user_queries` $condition"));

    $total_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count`
        FROM `rating_review` $condition"));

    $total_new_reg = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(id) AS `count`
        FROM `user` $condition"));

    $output = [
        'total_queries' => $total_queries['count'],
        'total_reviews' => $total_reviews['count'],
        'total_new_reg' => $total_new_reg['count']
    ];

    $output = json_encode($output);

    echo $output;

}


