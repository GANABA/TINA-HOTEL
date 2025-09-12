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
<title>Admin Panel - Gestion des Chambre</title>
<?php require('includes/links.php') ?>
</head>

<body class="bg-light">

    <?php require('includes/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">GESTION DES CHAMBRES</h3>
                <!-- Rooms -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-room">
                                <i class="bi bi-plus-square"></i> Ajouter
                            </button>
                        </div>

                        <div class="table-responsive-lg" style="height: 450px; overflow-y: scroll;">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="table-dark text-light">
                                        <th scope="col">#</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Surface</th>
                                        <th scope="col">Invités</th>
                                        <th scope="col">Prix</th>
                                        <th scope="col">Nombre de chambre</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="room-data">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Add rooms Modal -->
    <div class="modal fade" id="add-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="add_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Ajouter Chambre</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nom</label>
                                <input type="text" name="name" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select shadow-none" id="type" name="type" required>
                                    <option value="Chambre" selected>Chambre</option>
                                    <option value="Salle">Salle conférence</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Surface</label>
                                <input type="number" min="1" name="area" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Prix</label>
                                <input type="number" min="1" name="price" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantité|Nombre de chambre</label>
                                <input type="number" min="1" name="quantity" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adultes (Max.)</label>
                                <input type="number" min="1" name="adult" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Enfants (Max.)</label>
                                <input type="number" min="1" name="children" required class="form-control shadow-none">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Caractéristiques</label>
                                <div class="row">
                                    <?Php
                                    $res = selectAll('features');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                                <div class='col-md-3 mb-1'>
                                                    <label>
                                                        <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Equipements</label>
                                <div class="row">
                                    <?Php
                                    $res = selectAll('facilities');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                                <div class='col-md-3 mb-1'>
                                                    <label>
                                                        <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                                                        $opt[name]
                                                    </label>
                                                </div>
                                            ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" class="form-control shadow-none" required rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">ANNULER</button>
                        <button type="submit" class="btn custum-bg text-white shadow-none">AJOUTER</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Edit rooms Modal -->
    <div class="modal fade" id="edit-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="edit_room_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Modifier Chambre</h1>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Nom</label>
                                <input type="text" name="name" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Type</label>
                                <select class="form-select shadow-none" id="type" name="type" required>
                                    <option value="Chambre" selected>Chambre</option>
                                    <option value="Salle">Salle conférence</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Surface</label>
                                <input type="number" min="1" name="area" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Prix</label>
                                <input type="number" min="1" name="price" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Quantité|Nombre de chambre</label>
                                <input type="number" min="1" name="quantity" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Adultes (Max.)</label>
                                <input type="number" min="1" name="adult" required class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Enfants (Max.)</label>
                                <input type="number" min="1" name="children" required class="form-control shadow-none">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Caractéristiques</label>
                                <div class="row">
                                    <?Php
                                    $res = selectAll('features');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                            <div class='col-md-3 mb-1'>
                                                <label>
                                                    <input type='checkbox' name='features' value='$opt[id]' class='form-check-input shadow-none'>
                                                    $opt[name]
                                                </label>
                                            </div>
                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Equipements</label>
                                <div class="row">
                                    <?Php
                                    $res = selectAll('facilities');
                                    while ($opt = mysqli_fetch_assoc($res)) {
                                        echo "
                                            <div class='col-md-3 mb-1'>
                                                <label>
                                                    <input type='checkbox' name='facilities' value='$opt[id]' class='form-check-input shadow-none'>
                                                    $opt[name]
                                                </label>
                                            </div>
                                        ";
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea name="desc" class="form-control shadow-none" required rows="4"></textarea>
                            </div>
                            <input type="hidden" name="room_id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">ANNULER</button>
                        <button type="submit" class="btn custum-bg text-white shadow-none">MODIFIER</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Manage Room images Modal -->
    <div class="modal fade" id="room-images" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Room Name</h1>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="image-alert"></div>
                    <div class="border-bottom border-3 pb-3 mb-3">
                        <form id="add_image_form">
                            <label class="form-label fw-bold">Ajouter Image</label>
                            <input type="file" name="image" required accept="[.png, .jpeg, .webp, .jpg]" class="form-control shadow-none mb-3">
                            <button class="btn custum-bg text-white shadow-none">AJOUTER</button>
                            <input type="hidden" name="room_id">
                        </form>
                    </div>

                    <div class="table-responsive-lg" style="height: 350px; overflow-y: scroll;">
                        <table class="table table-hover border text-center">
                            <thead>
                                <tr class="table-dark text-light sticky-top">
                                    <th scope="col" width="60%">Image</th>
                                    <th scope="col">Thumb</th>
                                    <th scope="col">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody id="room-image-data">

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php require('includes/scripts.php') ?>
    <script src="scripts/room.js"></script>
</body>

</html>