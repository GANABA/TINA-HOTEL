<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links -->
    <?php require('includes/links.php'); ?>
    <!-- Title -->
    <title><?php echo $settings_r['site_title'] ?> - CONFIRMATION RESERVATION</title>
</head>

<body class="bg-light">

    <!-- Header -->
    <?php require("includes/header.php"); ?>

    <?php

    /**
     * check room id from url is present or not
     * shutdown mode is active or not
     * user is logged in or not
     */
    if (!isset($_GET['id']) || $settings_r['shutdown'] == true) {
        redirect('rooms.php');
    } else if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('rooms.php');
    }

    // filter and get room and user data
    $data = filteration($_GET);

    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

    if (mysqli_num_rows($room_res) == 0) {
        redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);

    $_SESSION['room'] = [
        "id" => $room_data['id'],
        "name" => $room_data['name'],
        "price" => $room_data['price'],
        "payment" => null,
        "available" => false,
    ];

    $user_res = select("SELECT * FROM `user` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], "i");
    $user_data = mysqli_fetch_assoc($user_res);


    ?>


    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-4 px-4">
                <h2 class="fw-bold">CONFIRMATION RESERVATION</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">ACCUEIL</a>
                    <span class="text-secondary"> > </span>
                    <a href="rooms.php" class="text-secondary text-decoration-none">NOS CHAMBRES</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">CONFIRMATION</a>
                </div>
            </div>

            <div class="col-lg-7 col-md-12 px-4 mb-3">

                <?php

                //get thumbnail of room
                $room_thum = ROOMS_IMG_PATH . "thumbnail.jpg";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images`
                        WHERE `room_id`='$room_data[id]'
                        AND `thumb`='1'");

                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_array($thumb_q);
                    $room_thum = ROOMS_IMG_PATH . $thumb_res['image'];
                }

                $price = "";
                if($room_data['type'] == "Salle"){
                    $price = "FCFA par jour";
                }else{
                    $price = "FCFA par nuit";
                }

                echo <<<data
                    <div class="card p-3 shadow-sm rounded">
                        <img src="$room_thum" class="img-fluid rounded mb-3">
                        <h5>$room_data[name]</h5>
                        <h6>$room_data[price] $price</h6>
                    </div>
                data;
                ?>

            </div>

            <div class="col-lg-5 col-md-12 px-4">
                <div class="card mb-4 border-0 shadow-sm rounded-3">
                    <div class="card-body">
                        <form action="pay_now.php" method="POST" id="booking_form">
                            <h6 class="mb-3">DETAILS DE LA RESERVATION</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom</label>
                                    <input type="text" name="name" value="<?php echo $user_data['name'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Téléphone</label>
                                    <input type="number" name="phonenum" value="<?php echo $user_data['phonenum'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nationalité</label>
                                    <input type="text" name="nationality" value="<?php echo $user_data['nationality'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profession</label>
                                    <input type="text" name="profession" value="<?php echo $user_data['profession'] ?>" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Provenance</label>
                                    <input type="text" name="address" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Motif de réservation</label>
                                    <select class="form-select shadow-none" id="motif" name="motif" required>
                                    <option value="" selected disabled>Motif</option>
                                        <option value="Repos">Repos</option>
                                        <option value="Mission">Mission</option>
                                        <option value="Tourisme">Tourisme</option>
                                        <option value="Visite">Visite</option>
                                        <option value="Atelier">Atelier</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Entrée</label>
                                    <input type="date" onchange="check_availability()" name="checkin" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Sortie</label>
                                    <input type="date" onchange="check_availability()" name="checkout" class="form-control shadow-none" required>
                                </div>
                                <div class="col-12">
                                    <div class="spinner-border text-info mb-3 d-none" id="info_loader" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>

                                    <h6 class="mb-3 text-danger" id="pay_info">Veuillez renseigner la date d'entrée et de sortie!</h6>

                                    <button name="pay_now" class="btn w-100 text-white custum-bg shadow-none mb-1" disabled>Confirmer la réservation</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Footer -->
    <?php require("includes/footer.php"); ?>

    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        function check_availability() {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;

            booking_form.elements['pay_now'].setAttribute('disabled', true);

            if (checkin_val != '' && checkout_val != '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();

                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/confirm_booking.php", true);

                xhr.onload = function() {
                    let data = JSON.parse(this.responseText);

                    if (data.status == 'check_in_out_equal') {
                        pay_info.innerText = "S'il s'agit d'une réservation d'une journée ou nuit, veuillez choisir comme date de sortie la date suivante à celle d'entrée!";
                    } else if (data.status == 'check_out_earlier') {
                        pay_info.innerText = "La date de sortie est antérieur à celle d'entrée!";
                    } else if (data.status == 'check_in_earlier') {
                        pay_info.innerText = "La date d'entrée est antérieur à la date d'aujourd'hui!";
                    } else if (data.status == 'unavailable') {
                        pay_info.innerText = "La chambre ou salle n'est pas disponible pour cette date!";
                    } else {
                        pay_info.innerHTML = "Nombre de jours : " + data.days + "<br>Total à payer : " + data.payment + " CFA" + "<br><br>Paiement à l'arrivée.";
                        pay_info.classList.replace('text-danger', 'text-dark');
                        booking_form.elements['pay_now'].removeAttribute('disabled');
                    }
                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                }
                xhr.send(data);
            }

        }
    </script>

</body>

</html>