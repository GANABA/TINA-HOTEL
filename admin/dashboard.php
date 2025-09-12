<?php

require('includes/essentials.php');
require('includes/db_config.php');
//fonction de connection de l'admin definie dans admin/includes/essentials.php
adminLogin();


?>


<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Tableau de Bord</title>
<?php require('includes/links.php') ?>
</head>

<body class="bg-light">

    <?php
        require('includes/header.php');

        $is_shutdown = mysqli_fetch_assoc(mysqli_query($con,"SELECT `shutdown` FROM `settings`"));

        $current_bookings = mysqli_fetch_assoc(mysqli_query($con,"SELECT
            COUNT(CASE WHEN booking_status='booked' AND arrival=0 THEN 1 END) AS `new_bookings`
            FROM `booking_order`"));

        $unread_queries = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` 
            FROM `user_queries` WHERE `seen`=0"));

        $unread_reviews = mysqli_fetch_assoc(mysqli_query($con,"SELECT COUNT(sr_no) AS `count` 
            FROM `rating_review` WHERE `seen`=0"));
        
        $current_users = mysqli_fetch_assoc(mysqli_query($con,"SELECT
            COUNT(id) AS `total`,
            COUNT(CASE WHEN `status`=1 THEN 1 END) AS `active`,
            COUNT(CASE WHEN `status`=0 THEN 1 END) AS `inactive`,
            COUNT(CASE WHEN `is_verified`=0 THEN 1 END) AS `unverified`
            FROM `user`"));
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h3>TABLEAU DE BORD</h3>
                    <?php
                        if($is_shutdown['shutdown']){
                            echo<<<data
                               <h6 class="badge bg-danger py-2 px-3 rounded">Le mode maintenance est actif !</h6>
                            data;
                        }
                    ?>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3 mb-4">
                        <a href="new_bookings.php" class="text-decoration-none">
                            <div class="card text-center text-success p-3">
                                <h6>Nouvelles Réservations</h6>
                                <h1 class="mt-2 mb-0"><?php echo $current_bookings['new_bookings'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="user_queries.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Requêtes clients</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_queries['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 mb-4">
                        <a href="rate_review.php" class="text-decoration-none">
                            <div class="card text-center text-info p-3">
                                <h6>Notes et Avis</h6>
                                <h1 class="mt-2 mb-0"><?php echo $unread_reviews['count'] ?></h1>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5>Analyse des réservations</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="booking_analytics(this.value)">
                        <option value="1">30 derniers jours</option>
                        <option value="2">90 derniers jours</option>
                        <option value="3">1 an en arrière</option>
                        <option value="4">Tout</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Total des réservations</h6>
                            <h1 class="mt-2 mb-0" id="total_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="total_amt">0 CFA</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Réservations actives</h6>
                            <h1 class="mt-2 mb-0" id="active_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="active_amt">0 CFA</h4>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Réservations annulés</h6>
                            <h1 class="mt-2 mb-0" id="cancelled_bookings">0</h1>
                            <h4 class="mt-2 mb-0" id="cancelled_amt">0 CFA</h4>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5>Analyse des clients, requêtes, avis</h5>
                    <select class="form-select shadow-none bg-light w-auto" onchange="user_analytics(this.value)">
                        <option value="1">30 derniers jours</option>
                        <option value="2">90 derniers jours</option>
                        <option value="3">1 an en arrière</option>
                        <option value="4">Tout</option>
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Nouvelles inscriptions</h6>
                            <h1 class="mt-2 mb-0" id="total_new_reg">0</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Requêtes</h6>
                            <h1 class="mt-2 mb-0" id="total_queries">0</h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-primary p-3">
                            <h6>Avis</h6>
                            <h1 class="mt-2 mb-0" id="total_reviews">0</h1>
                        </div>
                    </div>
                </div>

                <h5>Clients/Utilisateurs</h5>
                <div class="row mb-3">
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-info p-3">
                            <h6>Total</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['total'] ?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-success p-3">
                            <h6>Actifs</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['active'] ?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-warning p-3">
                            <h6>Inactifs</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['inactive'] ?></h1>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card text-center text-danger p-3">
                            <h6>Non vérifié</h6>
                            <h1 class="mt-2 mb-0"><?php echo $current_users['unverified'] ?></h1>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>




    <?php require('includes/scripts.php') ?>
    <script src="scripts/dashboard.js"></script>
</body>

</html>