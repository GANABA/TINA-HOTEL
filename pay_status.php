<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links -->
    <?php require('includes/links.php'); ?>
    <!-- Title -->
    <title><?php echo $settings_r['site_title'] ?> - STATUT DE RESERVATION</title>
</head>

<body class="bg-light">

    <!-- Header -->
    <?php require("includes/header.php"); ?>

    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-3 px-4">
                <h2 class="fw-bold">STATUT DE RESERVATION</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">ACCUEIL</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">NOS CHAMBRES</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRMATION</a>
                </div>
            </div>

            <?php
            $frm_data = filteration($_GET);

            if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
                redirect('index.php');
            }

            $booking_q = "SELECT bo.*, bd.* FROM `booking_order` bo
                INNER JOIN `booking_details` bd ON bo.booking_id=bd.booking_id
                WHERE bo.order_id=? AND bo.user_id=? AND bo.booking_status=?";

            $booking_res = select($booking_q, [$frm_data['order'], $_SESSION['uId'], 'booked'], 'sis');

            if (mysqli_num_rows($booking_res) == 0) {
                redirect('index.php');
            }

            $booking_fetch = mysqli_fetch_assoc($booking_res);

            if ($booking_fetch['trans_status'] == "TXN_SUCCESS") {
                echo <<<data
                    <div class="col-12 px-4">
                        <p class="fw-bold alert alert-success">
                            <i class="bi  bi-check-circle-fill"></i>
                            Réservation éffectuée avec succès !
                            <br><br>
                            <a href='bookings.php'>Voir les réservations</a>
                        </p>
                    </div>
                data;
            }

            ?>

        </div>
    </div>

    <!-- Footer -->
    <?php require("includes/footer.php"); ?>

</body>

</html>