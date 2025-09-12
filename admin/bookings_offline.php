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
<title>Admin Panel - Reservation Hors Ligne</title>
<?php require('includes/links.php') ?>
</head>

<body class="bg-light">

    <?php require('includes/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">RESERVATIONS HORS LIGNE</h3>
                <!-- Clients -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <!-- Recherche & Bouton d'ajout -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <!-- Champ de recherche aligné à gauche -->
                            <input type="text" id="search_input" oninput="get_bookings(this.value)"
                                class="form-control shadow-none w-25"
                                placeholder="Saisissez le nom pour rechercher...">

                            <!-- Bouton pour ouvrir le modal -->
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#addBookingModal">
                                <i class="bi bi-plus-square"></i> Nouvelle Réservation
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Détails Utilisateur</th>
                                        <th scope="col">Détails Chambre</th>
                                        <th scope="col">Détails Reservation</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">

                                </tbody>
                            </table>
                        </div>

                        <nav>
                            <ul class="pagination mt-3" id="table-pagination">

                            </ul>
                        </nav>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Add booking offline modal -->
    <div class="modal fade" id="addBookingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addBookingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="booking-form">
                    <div class="modal-header">
                        <h5 class="modal-title fs-5 d-flex align-items-center">
                            <i class="bi bi-calendar-check fs-3 me-2"></i> Nouvelle Réservation
                        </h5>
                        <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nom du client</label>
                                    <input type="text" id="client_name" name="client_name" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nationalité</label>
                                    <input type="text" id="nationalite" name="nationalite" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Profession</label>
                                    <input type="text" id="profession" name="profession" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Provenance</label>
                                    <input type="text" id="client_address" name="client_address" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Téléphone</label>
                                    <input type="tel" id="client_phone" name="client_phone" class="form-control shadow-none" required>
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
                                <div class="mb-3">
                                    <label class="form-label">Type de chambre</label>
                                    <select class="form-select shadow-none" id="room_type" name="room_type" required>
                                        <option value="" selected disabled>Sélectionner un type de chambre</option>
                                        <?php
                                            $room_q = mysqli_query($con, "SELECT `id`, `name` FROM `rooms` WHERE `status`='1' AND `removed`='0'");

                                            while ($room = mysqli_fetch_assoc($room_q)) {
                                                echo "<option value='{$room['id']}'>{$room['name']}</option>";
                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" id="room_id" name="room_id">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Numéro de chambre</label>
                                    <input type="text" id="room_number" name="room_number" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Montant total à payer</label>
                                    <input type="text" id="total_amount" name="total_amount" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date d'arrivée</label>
                                    <input type="date" onchange="check_availability()" id="arrival_date" name="arrival_date" class="form-control shadow-none" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date de départ</label>
                                    <input type="date" onchange="check_availability()" id="departure_date" name="departure_date" class="form-control shadow-none" required>
                                </div>
                                <h6 class="mb-3 text-danger" id="pay_info"></h6>
                            </div>
                        </div>
                        <div class="text-center my-3">
                            <button type="submit" class="btn btn-dark shadow-none">Enregistrer la réservation</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require('includes/scripts.php') ?>

    <script src="scripts/bookings_offline.js"></script>

</body>

</html>