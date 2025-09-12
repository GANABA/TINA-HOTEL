<?php

require('../admin/includes/db_config.php');
require('../admin/includes/essentials.php');

require '../vendor/autoload.php';

date_default_timezone_set("Africa/Porto-Novo");

if (isset($_POST['info_form'])) {

    $frm_data = filteration($_POST);
    session_start();

    // check user exist or not
    $u_exist = select("SELECT * FROM `user` WHERE `phonenum`=? AND `id`!=? LIMIT 1", [$frm_data['phonenum'], $_SESSION['uId']], "ss");

    if (mysqli_num_rows($u_exist) != 0) {
        echo 'phone_already';
        exit;
    }

    $query = "UPDATE `user` SET `name`=?, `profession`=?, `phonenum`=?, `nationality`=? WHERE `id`=? LIMIT 1";

    $values = [$frm_data['name'], $frm_data['profession'], $frm_data['phonenum'], $frm_data['nationality'], $_SESSION['uId']];

    if (update($query, $values, 'sssss')) {
        $_SESSION['uName'] = $frm_data['name'];
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['profile_form'])) {

    $frm_data = filteration($_POST);

    session_start();

    // upload user image to server
    $img = uploadUserImage($_FILES['profile']);

    if ($img == 'inv_img') {
        echo "inv_img";
        exit;
    } else if ($img == 'upd_failed') {
        echo "upd_failed";
        exit;
    }

    // fetching old image and deleting it
    $u_exist = select("SELECT `profile` FROM `user` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], "s");
    $u_fetch = mysqli_fetch_assoc($u_exist);

    deleteImage($u_fetch['profile'], USERS_FOLDER);

    $query = "UPDATE `user` SET `profile`=? WHERE `id`=?";

    $values = [$img,$_SESSION['uId']];

    if (update($query, $values, 'ss')) {
        $_SESSION['uProfile'] = $img;
        echo 1;
    } else {
        echo 0;
    }
}

if (isset($_POST['pass_form'])) {

    $frm_data = filteration($_POST);

    session_start();

    if($frm_data['new_pass'] != $frm_data['confirm_pass']){
        echo 'mismatch';
        exit;
    }

    $enc_pass = password_hash($frm_data['new_pass'], PASSWORD_BCRYPT);

    $query = "UPDATE `user` SET `password`=? WHERE `id`=? LIMIT 1";

    $values = [$enc_pass,$_SESSION['uId']];

    if (update($query, $values, 'ss')) {
        echo 1;
    } else {
        echo 0;
    }
}
