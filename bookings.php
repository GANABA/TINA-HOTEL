<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links -->
    <?php require('includes/links.php'); ?>
    <!-- Title -->
    <title><?php echo $settings_r['site_title'] ?> - RESERVATIONS</title>
</head>

<body class="bg-light">

    <!-- Header -->
    <?php
    require("includes/header.php");

    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('index.php');
    }
    ?>

    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-5 px-4">
                <h2 class="fw-bold">RESERVATIONS</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">ACCUEIL</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">RESERVATIONS</a>
                </div>
            </div>

            <?php

            $query = "SELECT bo.*,bd.*, r.type FROM `booking_order` bo
                    INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
                    INNER JOIN rooms r ON bd.room_name = r.name
                    WHERE ((bo.booking_status = 'booked')
                    OR (bo.booking_status = 'cancelled'))
                    AND (bo.user_id=?)
                    ORDER BY bo.booking_id DESC";

            $result = select($query, [$_SESSION['uId']], 'i');

            while ($data = mysqli_fetch_assoc($result)) {

                $date = date("d-m-Y", strtotime($data['datentime']));
                $checkin = date("d-m-Y", strtotime($data['check_in']));
                $checkout = date("d-m-Y", strtotime($data['check_out']));

                $status_bg = "";
                $btn = "";
                $badge_span = "";

                $price = "";
                if($data['type'] == "Salle"){
                    $price = "FCFA par jour";
                }else{
                    $price = "FCFA par nuit";
                }

                if ($data['booking_status'] == 'booked') {
                    $status_bg = "bg-success";
                    $badge_span = "réservé";

                    if ($data['arrival'] == 1) {
                        $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>
                                    Télécharger PDF
                                </a>
                            ";
                        if ($data['rate_review'] == 0) {
                            $btn .= "<button type='button' onclick='review_room($data[booking_id],$data[room_id])' class='btn btn-dark btn-sm shadow-none ms-2' data-bs-toggle='modal' data-bs-target='#reviewModal'>
                                    Note et Avis
                                </button>
                            ";
                        }
                    } else {
                        $btn = " <button onclick='cancel_booking($data[booking_id])' type='button' class='btn btn-danger btn-sm shadow-none'>
                                    Annuler la réservation
                                </button>
                            ";
                    }
                } else if ($data['booking_status'] == 'cancelled') {
                    $status_bg = "bg-danger";
                    $badge_span = "annulé";

                    $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none'>
                                Télécharger PDF
                            </a>
                        ";
                }

                echo <<<bookings
                    <div class='col-md-4 px-4 mb-4'>
                        <div class='bg-white p-3 rounded shadow-sm'>
                            <h5 class='fw-bold'>$data[room_name]</h5>
                            <p>$data[price] $price</p>
                            <p>
                                <b>Entrée: </b> $checkin <br>
                                <b>Sortie: </b> $checkout
                            </p>
                            <p>
                                <b>Montant: </b> $data[trans_amount] FCFA <br>
                                <b>Order ID: </b> $data[order_id] <br>
                                <b>Date: </b> $date
                            </p>
                            <p>
                                <span class='badge $status_bg'>$badge_span</span>
                            </p>
                            $btn
                        </div>
                    </div>
                bookings;
            }
            ?>

        </div>
    </div>

    <div class="modal fade" id="reviewModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="review-form">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5 d-flex align-items-center">
                            <i class="bi bi-chat-square-heart-fill fs-3 me-2"></i> Notes et Avis
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <select class="form-select shadow-none" name="rating">
                                <option value="5">Excellent</option>
                                <option value="4">Bien</option>
                                <option value="3">Ok</option>
                                <option value="2">Faible</option>
                                <option value="1">Mauvais</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Avis/Commentaire</label>
                            <textarea rows="3" name="review" class="form-control shadow-none" required></textarea>
                        </div>

                        <input type="hidden" name="booking_id">
                        <input type="hidden" name="room_id">

                        <div class="text-end">
                            <button type="submit" class="btn custum-bg text-white shadow-none">SOUMETTRE</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal confirmation annulation de reservation -->
    <div class="modal fade" id="confirmCancelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir annuler votre réservation ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non</button>
                    <button type="button" class="btn btn-danger" id="confirmCancelBtn">Oui</button>
                </div>
            </div>
        </div>
    </div>


    <?php
    if (isset($_GET['cancel_status'])) {
        alert("success", "Réservation annuler!");
    } else if (isset($_GET['review_status'])) {
        alert("success", "Merci pour votre note et commentaire!");
    }
    ?>
    <!-- Footer -->
    <?php require("includes/footer.php"); ?>

    <script>
        function cancel_booking(id) {
            let confirmBtn = document.getElementById('confirmCancelBtn');

            confirmBtn.onclick = function() {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "ajax/cancel_booking.php", true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function() {
                    if (this.responseText == 1) {
                        window.location.href = "bookings.php?cancel_status=true";
                    } else {
                        alert("Echec de l'annulation!");
                    }
                }

                xhr.send('cancel_booking&id=' + id);

                // Fermer la modal après la confirmation
                var modal = bootstrap.Modal.getInstance(document.getElementById('confirmCancelModal'));
                modal.hide();
            };

            // Afficher la modal
            var modal = new bootstrap.Modal(document.getElementById('confirmCancelModal'));
            modal.show();
        }


        let review_form = document.getElementById('review-form');

        function review_room(bid, rid) {
            review_form.elements['booking_id'].value = bid;
            review_form.elements['room_id'].value = rid;
        }

        review_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let data = new FormData();
            data.append('review_form', '');
            data.append('rating', review_form.elements['rating'].value);
            data.append('review', review_form.elements['review'].value);
            data.append('booking_id', review_form.elements['booking_id'].value);
            data.append('room_id', review_form.elements['room_id'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/review_room.php", true);

            xhr.onload = function() {
                if (this.responseText == 1) {
                    window.location.href = 'bookings.php?review_status=true';
                } else {
                    var myModal = document.getElementById('reviewModal');
                    var modal = bootstrap.Modal.getInstance(myModal);
                    modal.hide();

                    alert('error', "Echec de la soumission de note et commentaire!");
                }
            }

            xhr.send(data);
        });
    </script>

</body>

</html>