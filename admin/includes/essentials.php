<?php

// Frontend purpose data
define('SITE_URL', 'http://127.0.0.1/HotelBooking/');
define('ABOUT_IMG_PATH', SITE_URL . 'images/about/');
define('CAROUSEL_IMG_PATH', SITE_URL . 'images/carousel/');
define('FACILITIES_IMG_PATH', SITE_URL . 'images/facilities/');
define('ROOMS_IMG_PATH', SITE_URL . 'images/rooms/');
define('USERS_IMG_PATH', SITE_URL . 'images/users/');

// Backend upload process needs this data
define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/HotelBooking/images/');
define('ABOUT_FOLDER', 'about/');
define('CAROUSEL_FOLDER', 'carousel/');
define('FACILITIES_FOLDER', 'facilities/');
define('ROOMS_FOLDER', 'rooms/');
define('USERS_FOLDER', 'users/');

//fedapay callback
//define('CALLBACK_URL', 'http://127.0.0.1/HotelBooking/pay_response.php');
//define('CALLBACK_URL', 'https://tina-hotel.yes.bj/pay_response.php');

// Send mail with PHPMailler

// Possible "booking status" values in db = pending, booked, paiement failed, cancelled

// To configure this payment method check : 'project folder/...'

function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
        //header("Location: index.php");
        echo "<script>
            window.location.href='index.php';
        </script>";
        exit;
    }
}

function redirect($url)
{
    echo "<script>
        window.location.href='$url';
    </script>";
    exit;
}

function alert($type, $msg)
{
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

    echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3" >$msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
}

function uploadImage($image, $folder)
{
    $valid_name = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_name)) {
        return 'inv_img'; // invalide image mime or format
    } else if (($image['size'] / (1024 * 1024)) > 2) {
        return 'inv_size'; // invalide size greater than 2mb
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(1111, 9999) . ".$ext";

        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}

function deleteImage($image, $folder)
{
    if (unlink(UPLOAD_IMAGE_PATH . $folder . $image)) {
        return true;
    } else {
        return false;
    }
}

function uploadSVGImage($image, $folder)
{
    $valid_name = ['image/svg+xml'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_name)) {
        return 'inv_img'; // invalide image mime or format
    } else if (($image['size'] / (1024 * 1024)) > 1) {
        return 'inv_size'; // invalide size greater than 1mb
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(1111, 9999) . ".$ext";

        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}

function uploadUserImage($image){
    $valid_name = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_name)) {
        return 'inv_img'; // invalide image mime or format
    }else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);

        $rname = 'IMG_' . random_int(1111, 9999) . ".jpeg";

        $img_path = UPLOAD_IMAGE_PATH . USERS_FOLDER . $rname;

        if($ext == 'png' || $ext == 'PNG'){
            $img = imagecreatefrompng($image['tmp_name']);
        }else if($ext == 'webp' || $ext == 'WEBP'){
            $img = imagecreatefromwebp($image['tmp_name']);
        }else{
            $img = imagecreatefromjpeg($image['tmp_name']);
        }

        if(imagejpeg($img, $img_path, 75)){
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}

//fonction de copy d'image de profil de l'utilisateur par defaut
function copyDefaultProfileImage() {
    $defaultImage = UPLOAD_IMAGE_PATH . USERS_FOLDER . "default.jpg"; // Chemin de l'image par défaut
    $newImageName = uniqid('user_') . ".jpg"; // Génère un nom unique
    $newImagePath = UPLOAD_IMAGE_PATH . USERS_FOLDER . $newImageName; // Nouveau chemin

    // Copier l'image par défaut vers le nouvel emplacement
    if (copy($defaultImage, $newImagePath)) {
        return $newImageName; // Retourne le nom de l'image copiée
    } else {
        return 'default.jpg'; // En cas d'échec, utilise l'image par défaut
    }
}