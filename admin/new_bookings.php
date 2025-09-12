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
<title>Admin Panel - Nouvelles Reservation</title>
<?php require('includes/links.php') ?>
</head>

<body class="bg-light">

    <?php require('includes/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">GESTION DES RESERVATIONS</h3>
                <!-- Clients -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <!-- Champ de recherche - filtrage par nom users -->
                        <div class="text-end mb-4">
                            <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Saissisez le nom pour rechercher...">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover border" style="min-width: 1200px;">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Détails Utilisateur</th>
                                        <th scope="col">Détails Chambre</th>
                                        <th scope="col">Détails Reservation</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Assign Room Number Modal -->
    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="assign_room_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Assigner une Chambre</h1>
                    </div>
                    <div class="modal-body">
                        <span class="badge text-bg-light mb-3 d-block text-center text-wrap lh-base">
                            Note : Assigner un numero à une chambre uniquement quand le client est arrivé!
                        </span>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Numero de Chambre</label>
                            <input type="text" name="room_no" required class="form-control shadow-none">
                        </div>
                        <input type="hidden" name="booking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">ANNULER</button>
                        <button type="submit" class="btn custum-bg text-white shadow-none">ASSIGNER</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php require('includes/scripts.php') ?>

    <script src="scripts/new_bookings.js"></script>

</body>

</html>