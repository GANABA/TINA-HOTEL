<!-- Principal Nav Bar -->
<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="index.php"><?php echo $settings_r['site_title'] ?></a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link me-2" href="index.php">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="rooms.php">Nos chambres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="facilities.php">Nos équipements</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2" href="contact.php">Nous contacter</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">A propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="restaurant.php">Restaurant</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
                    $path = USERS_IMG_PATH;
                    echo <<<data
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-dark shadow-none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    <img src="$path$_SESSION[uProfile]" style="width: 25px; height: 25px;" class="me-1 rounded-circle">
                                    $_SESSION[uName]
                                </button>
                                <ul class="dropdown-menu dropdown-menu-lg-end">
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="bookings.php">Réservations</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Déconnexion</a></li>
                                </ul>
                            </div>
                        data;
                } else {
                    echo <<<data
                            <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Connexion
                            </button>
                            <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Inscription
                            </button>
                        data;
                }
                ?>
            </div>
        </div>
    </div>
</nav>

<!-- Login modal -->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="login-form">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> Connexion client
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Email / Téléphone</label>
                        <input type="text" name="email_mob" class="form-control shadow-none" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="pass" class="form-control shadow-none" required>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <button type="submit" class="btn btn-dark shadow-none">CONNEXION</button>
                        <button type="button" class="btn text-secondary text-decoration-none shadow-none p-0" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#forgotModal">
                            Mot de passe oublié?
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Register modal -->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="register-form">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 d-flex align-items-center">
                        <i class="bi bi-person-lines-fill fs-3 me-2"></i> Inscription client
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span class="badge text-bg-light mb-3 d-block text-center text-wrap lh-base">
                        Vos informations personnelles que vous renseignez sont gardées confidentielles et nous aide à gérer les réservations.
                        Veuillez prendre connaissance de notre <a class="text-decoration-none" href="privacy-policy.php">politique de confidentialité</a> avant inscription.<br>
                        Vous recevrez un e-mail après votre inscription pour activer votre compte et vous connecter.
                    </span>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nom complet</label>
                                <input type="text" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Numéro de Téléphone</label>
                                <input type="number" name="phonenum" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Photo profile (facultatif)</label>
                                <input type="file" name="profile" accept=".jpeg, .jpg, .png, .webp" class="form-control shadow-none">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nationalité</label>
                                <input type="text" name="nationality" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Profession</label>
                                <input type="text" name="profession" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mot de passe</label>
                                <input type="password" name="pass" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirmer le mot de passe</label>
                                <input type="password" name="cpass" class="form-control shadow-none" required>
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-1">
                        <button type="submit" class="btn btn-dark shadow-none">CREER UN COMPTE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Forgot password modal -->
<div class="modal fade" id="forgotModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="forgot-form">
                <div class="modal-header">
                    <h5 class="modal-title fs-5 d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i> Mot de passe oublié
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="mb-4">
                        <span class="badge text-bg-light mb-3 d-block text-center text-wrap lh-base">
                            Note : Vous recevrez un e-mail pour réinitialiser votre mot de passe
                        </span>
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control shadow-none" required>
                    </div>
                    <div class="mb-2 text-end">
                        <button type="button" class="btn shadow-none p-0 me-2" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loginModal">
                            ANNULER
                        </button>
                        <button type="submit" class="btn btn-dark shadow-none">ENVOYER</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>