<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Découvrez Tina Hôtel à Boukombé, un lieu de séjour idéal pour explorer les tatas et les merveilles de l’Atacora. Profitez d’un hébergement confortable et d’un accueil chaleureux.">
    <meta name="keywords" content="hôtel Boukombé, hébergement Atacora, tourisme Bénin, hôtel de luxe Boukombé">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Links -->
    <?php require('includes/links.php'); ?>
    <!-- Title -->
    <title><?php echo $settings_r['site_title'] ?> - A PROPOS</title>
    <style>
        .promoter-img {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .i-color {
            color: var(--teal);
        }

        /* Justification du texte */
        .justified-text {
            text-align: justify;
        }
    </style>
</head>

<body class="bg-light">

    <!-- Header -->
    <?php require("includes/header.php"); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">À PROPOS DE TINA HÔTEL</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6 col-md-5 mb-4 order-lg-1 order-md-1 order-2">
                <h3 class="mb-3">Un havre de paix au cœur de l’Atacora</h3>
                <p class="justified-text">
                    Niché dans la magnifique région de Boukombé, au nord-ouest du Bénin, <strong>Tina Hôtel</strong> est bien plus qu’un simple lieu de séjour. C’est une invitation à l’évasion, à la découverte et à la sérénité.
                    <br><br>
                    Que vous soyez voyageur en quête d'authenticité, amateur de nature ou professionnel en déplacement, notre établissement vous offre une expérience inoubliable. Confort, hospitalité et immersion culturelle sont les maîtres-mots de notre engagement.
                    <br><br>
                    Nos chambres, pensées pour votre bien-être, allient élégance et touches locales, offrant une vue imprenable sur les paysages envoûtants de l’Atacora. En séjournant chez nous, vous serez idéalement placé pour explorer la célèbre cité des <strong>Tatas</strong>, un joyau architectural et culturel béninois.
                    <br><br>
                    Plus qu’un simple hôtel, Tina Hôtel est une expérience qui vous connecte à l’essence même de la région.
                </p>
            </div>
            <div class="col-lg-5 col-md-5 mb-4 order-lg-2 order-md-2 order-1 text-center">
                <img src="images/about/stanislas_ndouma.png" class="w-100 promoter-img" alt="Stanislas N’DOUMA - Promoteur">
                <h5 class="mt-2">Stanislas N’DOUMA</h5>
                <p class="text-muted">Fondateur et visionnaire</p>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="fw-bold h-font text-center">NOS ENGAGEMENTS</h3>
        <p class="text-center mt-3">
            Chez Tina Hôtel, nous avons à cœur de vous offrir bien plus qu'un simple hébergement.
            Notre mission repose sur trois piliers fondamentaux.
        </p>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow p-4">
                    <i class="fa-solid fa-hotel fa-3x i-color"></i>
                    <h5 class="mt-3">Hospitalité & Confort</h5>
                    <p class="text-muted">Un accueil chaleureux et des services adaptés pour rendre votre séjour agréable et reposant.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card text-center shadow p-4">
                    <i class="fa-solid fa-map fa-3x i-color"></i>
                    <h5 class="mt-3">Authenticité & Culture</h5>
                    <p class="text-muted">Une immersion dans les traditions locales à travers l’architecture, la gastronomie et les expériences proposées.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow p-4">
                    <i class="fa-solid fa-leaf fa-3x i-color"></i>
                    <h5 class="mt-3">Nature & Évasion</h5>
                    <p class="text-muted">Un cadre paisible entouré des paysages exceptionnels de l’Atacora pour une évasion totale.</p>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-5 fw-bold h-font text-center" id="team-title" style="display: none;">EQUIPE DE GESTION</h3>

    <div class="container px-4" id="team-section" style="display: none;">
        <!-- Swiper -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper mb-5">
                <?php
                $about_r = selectAll('team_details');
                $path = ABOUT_IMG_PATH;

                // Vérifier si la requête retourne des résultats
                if (mysqli_num_rows($about_r) > 0) {
                    // Afficher la section et le titre
                    echo '<script>document.getElementById("team-title").style.display = "block";</script>';
                    echo '<script>document.getElementById("team-section").style.display = "block";</script>';

                    // Afficher les membres de l'équipe
                    while ($row = mysqli_fetch_assoc($about_r)) {
                        echo <<<data
                        <div class="swiper-slide bg-white text-center overflow-hidden rounded">
                            <img src="$path$row[picture]" class="w-100">
                            <h5 class="mt-2">$row[name]</h5>
                        </div>
                    data;
                    }
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>


    <!-- Footer -->
    <?php require("includes/footer.php"); ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 40,
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                640: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 3
                },
            }
        });
    </script>
</body>

</html>