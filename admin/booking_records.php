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
<title>Admin Panel - Archives des Reservation</title>
<?php require('includes/links.php') ?>
</head>

<body class="bg-light">

    <?php require('includes/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">ARCHIVE DES RESERVATIONS</h3>
                <!-- Clients -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <!-- Champ de recherche - filtrage par nom users -->
                        <div class="text-end mb-4">
                            <input type="text" id="search_input" oninput="get_bookings(this.value)" class="form-control shadow-none w-25 ms-auto" placeholder="Saissisez le nom pour rechercher...">
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


    <?php require('includes/scripts.php') ?>

    <script src="scripts/booking_records.js"></script>

</body>

</html>