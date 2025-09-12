<?php

require('admin/includes/db_config.php');
require('admin/includes/essentials.php');

if(isset($_GET['email_confirmation'])){

    $data = filteration($_GET);

    $query = select("SELECT * FROM `user` WHERE `email`=? AND `token`=? LIMIT 1", [$data['email'], $data['token']],'ss');

    if(mysqli_num_rows($query) == 1){

        $fetch = mysqli_fetch_assoc($query);

        if($fetch['is_verified'] == 1){
            echo "<script>alert('Email déjà vérifié!')</script>";
            redirect('index.php');
        }else{
            $update = update("UPDATE `user` SET `is_verified`=? WHERE `id`=?",[1, $fetch['id']],'ii');
            if($update){
                echo "<script>alert('Vérification de l'email éffectué avec succès!')</script>";
            }else{
                echo "<script>alert('Echec lors de la vérification de l'email. Erreur serveur!')</script>";
            }
            redirect('index.php');
        }
    }else{
        echo "<script>alert('Lien de vérification invalide!')</script>";
        redirect('index.php');
    }

}