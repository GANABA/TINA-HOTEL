<?php

require('../admin/includes/db_config.php');
require('../admin/includes/essentials.php');

require '../vendor/autoload.php';

date_default_timezone_set("Africa/Porto-Novo");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Send Mail function - With PHPMailer
function send_mail($uemail, $token, $type)
{
    //gestion de lenvoie des mail de confirmation de compte a linscription et de restauration de mot de passe a la connexion
    if ($type == "email_confirmation") {
        $page = "email_confirm.php";
        $subject = "Vérification de votre compte";
        $content = "<p>Merci de vous être inscrit à <strong>TINA Hôtel</strong>. Pour finaliser votre inscription, veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous.
                        Vous pouvez consulter notre politique de confidentialité<a class='text-decoration-none' href='privacy-policy.php'> ici</a>.
                    </p>";
        $bouton = "Confirmer votre adresse email";
    } else {
        $page = "index.php";
        $subject = "Réinitialisation de compte";
        $content = "<p>Pour réinitialiser votre compte, veuillez cliquer sur le bouton ci-dessous :</p>";
        $bouton = "Réinitialiser votre compte";
    }

    // Nouvel objet PHPMailer
    $mail = new PHPMailer();

    try {
        // Configuration du serveur SMTP
        $mail->isSMTP();
        //$mail->SMTPDebug  = SMTP::DEBUG_SERVER;
        
        //Configuration Mailtrap
        $mail->SMTPSecure = 'ssl';
        $mail->Host       = 'sandbox.smtp.mailtrap.io'; // Remplacez par votre hôte SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = '5df194ae3dc90c'; // Remplacez par votre adresse email SMTP
        $mail->Password   = 'aafb6fcb4d82f5'; // Remplacez par votre mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 2525;
        //
        /* Configuration Gmail
        $mail->SMTPSecure = 'ssl';
                    $mail->Host       = 'smtp.gmail.com'; // Remplacez par votre hôte SMTP
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'ganabamelchisedech@gmail.com'; // Remplacez par votre adresse email SMTP
                    $mail->Password   = 'klpnmzgwnqlsexvf'; // Remplacez par votre mot de passe SMTP
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 25;*/

        // Expéditeur & Destinataire
        $mail->setFrom('tina@hotel.com', 'TINA HOTEL');
        $mail->addAddress($uemail);

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = $subject;

        $mail->setLanguage('fr', '/optional/path/to/language/directory/'); //pour charger la version francaise

        $mail->CharSet = 'UTF-8'; // Ajout pour corriger les accents

        $mail->Body = "
    <html>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>$subject</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
            }
            .container {
                max-width: 600px;
                margin: 20px auto;
                background: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            }
            .header {
                text-align: center;
                padding-bottom: 10px;
                border-bottom: 2px solid #F57C21;
            }
            .header h1 {
                color: #F57C21;
            }
            .content {
                padding: 20px;
                text-align: center;
                font-size: 16px;
                color: #333;
            }
            .btn {
                display: inline-block;
                background: #F57C21;
                color: #fff;
                text-decoration: none;
                padding: 12px 20px;
                border-radius: 5px;
                margin-top: 20px;
                font-weight: bold;
            }
            .footer {
                text-align: center;
                font-size: 14px;
                color: #777;
                margin-top: 20px;
                border-top: 1px solid #ddd;
                padding-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>TINA HOTEL</h1>
            </div>
            <div class='content'>
                <p>Bonjour,</p>
                $content
                <a href='" . SITE_URL . "$page?$type&email=$uemail&token=$token' class='btn'>$bouton</a>
                <p>Si vous n'êtes pas à l'origine de cette action, veuillez ignorer cet email.</p>
            </div>
            <div class='footer'>
                <p>Ceci est un message automatique envoyé par le système de <strong>TINA Hôtel</strong>. Ne pas répondre à cet email.</p>
                <p>&copy; " . date('Y') . " TINA Hôtel, Boukombé - Bénin</p>
            </div>
        </div>
    </body>
    </html>";


        $mail->send();
        return 1;
    } catch (Exception $e) {
        return 0;
    }
}

if (isset($_POST['register'])) {

    $data = filteration($_POST);

    // Match password and confirm password field
    if ($data['pass'] != $data['cpass']) {
        echo "pass_mismatch";
        exit;
    }
    // check user exist or not
    $u_exist = select("SELECT * FROM `user` WHERE `email`=? OR `phonenum`=? LIMIT 1", [$data['email'], $data['phonenum']], "ss");

    if (mysqli_num_rows($u_exist) != 0) {
        $u_exist_fetch = mysqli_fetch_assoc($u_exist);
        echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
        exit;
    }

    // upload user image to server
    // Vérifier si une image a été téléchargée
    if (!empty($_FILES['profile']['name'])) {
        $img = uploadUserImage($_FILES['profile']);

        if ($img == 'inv_img') {
            echo "inv_img";
            exit;
        } else if ($img == 'upd_failed') {
            echo "upd_failed";
            exit;
        }
    } else {
        $img = copyDefaultProfileImage();
    }

    //send confirmation link to users's email
    $token = bin2hex(random_bytes(16));

    if (!send_mail($data['email'], $token, "email_confirmation")) {
        echo 'mail_failed';
        exit;
    }

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    $query = "INSERT INTO `user` (`name`, `email`, `nationality`, `phonenum`, `profession`, `profile`, `password`, `token`) VALUES (?,?,?,?,?,?,?,?)";

    $values = [$data['name'], $data['email'], $data['nationality'], $data['phonenum'], $data['profession'], $img, $enc_pass, $token];

    if (insert($query, $values, 'ssssssss')) {
        echo 1;
    } else {
        echo 'ins_failed';
    }
}

if (isset($_POST['login'])) {

    $data = filteration($_POST);

    // check user exist or not
    $u_exist = select("SELECT * FROM `user` WHERE `email`=? OR `phonenum`=? LIMIT 1", [$data['email_mob'], $data['email_mob']], "ss");

    if (mysqli_num_rows($u_exist) == 0) {
        echo "inv_email_mob";
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            echo "not_verified";
        } else if ($u_fetch['status'] == 0) {
            echo "inactive";
        } else {
            if (!password_verify($data['pass'], $u_fetch['password'])) {
                echo "invalid_pass";
            } else {
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['uId'] = $u_fetch['id'];
                $_SESSION['uName'] = $u_fetch['name'];
                $_SESSION['uProfile'] = $u_fetch['profile'];
                $_SESSION['uPhone'] = $u_fetch['phonenum'];
                echo 1;
            }
        }
    }
}

if (isset($_POST['forgot_pass'])) {

    $data = filteration($_POST);

    // check user exist or not
    $u_exist = select("SELECT * FROM `user` WHERE `email`=? LIMIT 1", [$data['email']], "s");

    if (mysqli_num_rows($u_exist) == 0) {
        echo "inv_email";
    } else {
        $u_fetch = mysqli_fetch_assoc($u_exist);
        if ($u_fetch['is_verified'] == 0) {
            echo "not_verified";
        } else if ($u_fetch['status'] == 0) {
            echo "inactive";
        } else {
            // send reset link to email

            $token = bin2hex(random_bytes(16));

            if (!send_mail($data['email'], $token, "account_recovery")) {
                echo "mail_failed";
            } else {
                $date = date("Y-m-d");

                // update token in DB and date on which it expire
                $query = mysqli_query($con, "UPDATE `user` SET `token`='$token', `t_expire`='$date'
                        WHERE `id`='$u_fetch[id]'");

                if ($query) {
                    echo 1;
                } else {
                    echo 'upd_failed';
                }
            }
        }
    }
}

if (isset($_POST['recover_user'])) {

    $data = filteration($_POST);

    $enc_pass = password_hash($data['pass'], PASSWORD_BCRYPT);

    $query = "UPDATE `user` SET `password`=?, `token`=?, `t_expire`=?
                WHERE `email`=? AND `token`=?";

    $values = [$enc_pass, null, null, $data['email'], $data['token']];

    if (update($query, $values, "sssss")) {
        echo 1;
    } else {
        echo "failed";
    }
}
