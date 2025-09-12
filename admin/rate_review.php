<?php

require('includes/essentials.php');
require('includes/db_config.php');
//fonction de connection de l'admin definie dans admin/includes/essentials.php
adminLogin();

if(isset($_GET['seen'])){

    $frm_data = filteration($_GET);

    if($frm_data['seen'] == 'all'){
        $q = "UPDATE `rating_review` SET `seen`=?";
        $values = [1];
        if(update($q,$values,'i')){
            alert('success', 'Tous marqué comme lu!');
        }else{
            alert('error', 'Echec de l\'operation !');
        }
    }else{
        $q = "UPDATE `rating_review` SET `seen`=? WHERE `sr_no`=?";
        $values = [1,$frm_data['seen']];
        if(update($q,$values,'ii')){
            alert('success', 'Marqué comme lu!');
        }else{
            alert('error', 'Echec de l\'operation !');
        }
    }
}

if(isset($_GET['del'])){

    $frm_data = filteration($_GET);

    if($frm_data['del'] == 'all'){
        $q = "DELETE FROM `rating_review`";
        if(mysqli_query($con, $q)){
            alert('success', 'Toutes les données ont été supprimées!');
        }else{
            alert('error', 'Echec de l\'operation !');
        }
    }else{
        $q = "DELETE FROM `rating_review` WHERE `sr_no`=?";
        $values = [$frm_data['del']];
        if(delete($q,$values,'i')){
            alert('success', 'Donnée supprimée!');
        }else{
            alert('error', 'Echec de l\'operation !');
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Notes et Avis clients</title>
<?php require('includes/links.php') ?>
</head>

<body class="bg-light">

    <?php require('includes/header.php') ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">NOTES ET AVIS CLIENTS</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                    <!-- Marquer tout comme lu ou supprimer tout -->
                    <div class="text-end mb-4">
                        <a href="?seen=all" class="btn btn-dark rounded-pill shadow-none btn-sm">
                            <i class="bi bi-check-all"></i> Marqué tout lu
                        </a>
                        <a href="?del=all" class="btn btn-danger rounded-pill shadow-none btn-sm">
                            <i class="bi bi-trash"></i> Supprimer tout
                        </a>
                    </div>

                        <div class="table-responsive-md">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="table-dark text-light" >
                                        <th scope="col">#</th>
                                        <th scope="col">Chambre</th>
                                        <th scope="col">Nom client</th>
                                        <th scope="col">Note</th>
                                        <th scope="col" width="30%">Avis</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $q = "SELECT rr.*,u.name AS uname, r.name AS rname FROM `rating_review` rr
                                            INNER JOIN `user` u ON rr.user_id = u.id
                                            INNER JOIN `rooms` r ON rr.room_id = r.id
                                            ORDER BY `sr_no` DESC";

                                        $data = mysqli_query($con, $q);
                                        $i = 1;

                                        while($row = mysqli_fetch_assoc($data)){
                                            $date = date('d-m-Y', strtotime($row['datentime']));
                                            
                                            $seen = '';
                                            if($row['seen'] != 1){
                                                $seen = "<a href='?seen=$row[sr_no]' class='btn btn-primary btn-sm rounded-pill mb-2'>Marquer lu</a> <br>";
                                            }
                                            $seen.="<a href='?del=$row[sr_no]' class='btn btn-danger btn-sm rounded-pill'>Supprimer</a>";
                                            echo<<<query
                                                <tr>
                                                    <td>$i</td>
                                                    <td>$row[rname]</td>
                                                    <td>$row[uname]</td>
                                                    <td>$row[rating]</td>
                                                    <td>$row[review]</td>
                                                    <td>$date</td>
                                                    <td>$seen</td>
                                                </tr>
                                            query;
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


    <?php require('includes/scripts.php') ?>
</body>

</html>