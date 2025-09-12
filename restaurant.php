<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- Links -->
    <?php require('includes/links.php'); ?>
    <!-- Title -->
    <title><?php echo $settings_r['site_title'] ?> - RESTAURANT</title>
    <style>
        @media (max-width: 768px) {
            h5 span {
                font-size: 0.9rem;
            }
        }

        /* Justification du texte */
        .justified-text {
            text-align: justify;
        }

        /* Ajuster la largeur du Swiper pour qu'il soit similaire à la largeur du container */
        .swiper-container {
            max-width: 1140px; /* Largeur maximale similaire à la div container */
            margin: 0 auto; /* Centrer le Swiper horizontalement */
        }

        /* Assurer que les images du Swiper ne prennent pas toute la largeur */
        .swiper-slide img {
            width: 100%; /* Remplir la largeur de l'élément swiper-slide */
            object-fit: cover; /* Garder une bonne proportion sans déformer l'image */
        }
    </style>
</head>

<body class="bg-light">

    <!-- Header -->
    <?php require("includes/header.php"); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">RESTAURANT</h2>
        <div class="h-line bg-dark"></div>
    </div>

    <!-- Carousel -->
    <div class="container-fluid px-lg-4 mt-4">
        <!-- Swiper -->
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="images/restaurant/IMG_0012.jpg" class="rounded d-block" />
                </div>
                <div class="swiper-slide">
                    <img src="images/restaurant/IMG_0013.jpg" class="rounded d-block" />
                </div>
                <div class="swiper-slide">
                    <img src="images/restaurant/IMG_0014.jpg" class="rounded d-block" />
                </div>
                <div class="swiper-slide">
                    <img src="images/restaurant/IMG_0015.jpg" class="rounded d-block" />
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5 text-center">
        <p class="justified-text">
            Notre Bar-Restaurant donne la possibilité
            aux hôtes de se restaurer sur place avec
            des spécialités de mets locaux, africains
            et européens.<br>
            Il est équipé d'un poste
            téléviseur avec divertissement Canal +.
            Un service traiteur est mis à votre disposition pour veiller à votre satisfaction.
        </p>
        <p class="justified-text">
            Vous découvrirez les saveurs authentiques de notre région à travers une sélection de plats préparés avec des ingrédients frais et locaux.
            Notre menu met à l'honneur la richesse culinaire africaine, avec des mets savoureux qui éveilleront vos papilles.
        </p>
    </div>

    <!-- Footer -->
    <?php require("includes/footer.php"); ?>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            }
        });
    </script>

</body>

</html>
