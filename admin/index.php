<?php

require('includes/essentials.php');
require('includes/db_config.php');

session_start();
if ((isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == true)) {
    //header("Location: index.php");
    redirect('dashboard.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel Connexion Admin </title>
<?php require('includes/links.php'); ?>
<style>
    div.login-form {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 400px;
    }
</style>
</head>

<body class="bg-light">

    <div class="login-form text-center rounded bg-white overflow-hidden">
        <form method="post">
            <h4 class="bg-dark text-white py-3">CONNEXION ADMIN PANEL</h4>
            <div class="p-4">
                <div class="mb-3">
                    <input name="admin_name" required type="text" class="form-control shadow-none text-center" placeholder="Admin Name">
                </div>
                <div class="mb-4">
                    <input name="admin_pass" required type="password" class="form-control shadow-none text-center" placeholder="Password">
                </div>
                <button name="login" type="submit" class="btn text-white custum-bg shadow-none">CONNEXION</button>
            </div>
        </form>
    </div>

    <?php

    if (isset($_POST['login'])) {
        // fonction de (filtration) defini dans admin/includes/db_config.php
        $frm_data = filteration($_POST);

        $query = "SELECT * FROM `admin_cred` WHERE `admin_name`=? AND `admin_pass`=?";
        $values = [$frm_data['admin_name'], $frm_data['admin_pass']];
        $datatypes = "ss";

        // fonction de (select()) defini dans admin/includes/db_config.php
        $res = select($query, $values, $datatypes);
        if ($res->num_rows == 1) {
            $row = mysqli_fetch_assoc($res);
            $_SESSION['adminLogin'] = true;
            $_SESSION['adminId'] = $row['sr_no'];
            // fonction de redirection defini dans admin/includes/essentials.php
            redirect('dashboard.php');
        } else {
            // fonction d'alerte defini dans admin/includes/essentials.php
            alert('error', 'Echec de connexion - Identifiants invalide !');
        }

    }

    ?>



    <?php require('includes/scripts.php'); ?>
</body>

</html>