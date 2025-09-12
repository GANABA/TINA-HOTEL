<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links -->
    <?php require('includes/links.php'); ?>
    <!-- Title -->
    <title><?php echo $settings_r['site_title'] ?> - PROFILE</title>
</head>

<body class="bg-light">

    <!-- Header -->
    <?php
    require("includes/header.php");

    if (!(isset($_SESSION['login']) && $_SESSION['login'] == true)) {
        redirect('index.php');
    }

    $u_exist = select("SELECT * FROM `user` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], "s");

    if (mysqli_num_rows($u_exist) == 0) {
        redirect('index.php');
    }

    $u_fetch = mysqli_fetch_assoc($u_exist);


    ?>

    <div class="container">
        <div class="row">

            <div class="col-12 my-5 mb-5 px-4">
                <h2 class="fw-bold">PROFILE</h2>
                <div style="font-size: 14px;">
                    <a href="index.php" class="text-secondary text-decoration-none">ACCUEIL</a>
                    <span class="text-secondary"> > </span>
                    <a href="#" class="text-secondary text-decoration-none">PROFILE</a>
                </div>
            </div>

            <!-- Information basic -->
            <div class="col-12 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="info-form">
                        <h5 class="mb-3 fw-bold">Informations Basiques</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" value="<?php echo $u_fetch['name'] ?>" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Numéro de Téléphone</label>
                                <input type="number" value="<?php echo $u_fetch['phonenum'] ?>" name="phonenum" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Profession</label>
                                <input type="text" value="<?php echo $u_fetch['profession'] ?>" name="profession" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label class="form-label">Nationalité</label>
                                <input type="text" value="<?php echo $u_fetch['nationality'] ?>" name="nationality" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custum-bg shadow-nome">Enrégistrer les modifications</button>
                    </form>
                </div>
            </div>

            <!-- Photo profile -->
            <div class="col-md-4 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="profile-form">
                        <h5 class="mb-3 fw-bold">Photo de profile</h5>
                        <img src="<?php echo USERS_IMG_PATH . $u_fetch['profile'] ?>" class="rounded-circle img-fluid">

                        <label class="form-label">Nouvelle Photo</label>
                        <input type="file" name="profile" accept=".jpeg, .jpg, .png, .webp" class="mb-4 form-control shadow-none" required>

                        <button type="submit" class="btn text-white custum-bg shadow-nome">Enrégistrer les modifications</button>
                    </form>
                </div>
            </div>

            <!-- Modifier mot de passe -->
            <div class="col-md-8 mb-5 px-4">
                <div class="bg-white p-3 p-md-4 rounded shadow-sm">
                    <form id="pass-form">
                        <h5 class="mb-3 fw-bold">Changer mot de passe</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="new_pass" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label">Confirmer mot de passe</label>
                                <input type="password" name="confirm_pass" class="form-control shadow-none" required>
                            </div>
                        </div>
                        <button type="submit" class="btn text-white custum-bg shadow-nome">Enrégistrer les modifications</button>
                    </form>
                </div>
            </div>


        </div>
    </div>


    <!-- Footer -->
    <?php require("includes/footer.php"); ?>

    <script>
        let info_form = document.getElementById("info-form");

        info_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let data = new FormData();
            data.append('info_form', '');
            data.append('name', info_form.elements['name'].value);
            data.append('phonenum', info_form.elements['phonenum'].value);
            data.append('profession', info_form.elements['profession'].value);
            data.append('nationality', info_form.elements['nationality'].value);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);

            xhr.onload = function() {
                if (this.responseText == 'phone_already') {
                    alert('error', "Le numero de téléphone est déjà utilisé");
                } else if (this.responseText == 0) {
                    alert('error', "Aucun changement éffectuer!");
                } else {
                    alert('success', 'Modification enrégistré!');
                }
            }

            xhr.send(data);
        });

        let profile_form = document.getElementById("profile-form");

        profile_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let data = new FormData();
            data.append('profile_form', '');
            data.append('profile', profile_form.elements['profile'].files[0]);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);

            xhr.onload = function() {
                if (this.responseText == 'inv_img') {
                    alert('error', "Seul les images JPEG, WEBP & PNG sont accepées!");
                } else if (this.responseText == 'upd_failed') {
                    alert('error', "Echec du chargement de l\'image!");
                } else if (this.responseText == 0) {
                    alert('error', "Echec de la mise à jour!");
                } else {
                    window.location.href = window.location.pathname;
                }
            }

            xhr.send(data);
        });

        let pass_form = document.getElementById("pass-form");

        pass_form.addEventListener('submit', function(e) {
            e.preventDefault();

            let new_pass = pass_form.elements['new_pass'].value;
            let confirm_pass = pass_form.elements['confirm_pass'].value;

            if(new_pass!=confirm_pass){
                alert('error','Les mots de passe ne correspondent pas!');
                return false;
            }

            let data = new FormData();
            data.append('pass_form', '');
            data.append('new_pass', new_pass);
            data.append('confirm_pass', confirm_pass);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/profile.php", true);

            xhr.onload = function() {
                if (this.responseText == 'mismatch') {
                    alert('error', "Les mots de passe ne correspondent pas!");
                } else if (this.responseText == 0) {
                    alert('error', "Echec de la mise à jour!");
                } else {
                    alert('success', "Modification effectué");
                    pass_form.reset();
                }
            }

            xhr.send(data);
        });


    </script>

</body>

</html>