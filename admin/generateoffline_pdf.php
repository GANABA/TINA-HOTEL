<?php
require('includes/db_config.php');
require('includes/essentials.php');
require('includes/mpdf/vendor/autoload.php');

adminLogin();

if (isset($_GET['gen_pdf']) && isset($_GET['id'])) {

    $frm_data = filteration($_GET);

    $query = "SELECT bo.*, r.name AS room_name, r.price, r.type
              FROM booking_offline bo
              INNER JOIN rooms r ON bo.room_id = r.id
              WHERE bo.id = '$frm_data[id]'";

    $res = mysqli_query($con, $query);

    $total_rows = mysqli_num_rows($res);

    if ($total_rows == 0) {
        header("Location: dashboard.php");
        exit;
    }

    $data = mysqli_fetch_assoc($res);

    $date = date("h:ia | d-m-Y", strtotime($data['datentime']));
    $checkin = date("d-m-Y", strtotime($data['check_in']));
    $checkout = date("d-m-Y", strtotime($data['check_out']));

    $price = "";
    if($data['type'] == "Salle"){
        $price = "FCFA par jour";
    }else{
        $price = "FCFA par nuit";
    }

    $hotel_name = "TINA HOTEL";
    $color_primary = "#000000"; // Bleu professionnel
    $color_secondary = "#f8f9fa"; // Gris clair

    // Génération du contenu HTML pour le PDF
    $table_data = "
<style>
    body { font-family: Arial, sans-serif; }
    .container { width: 100%; padding: 20px; border: 2px solid $color_primary; border-radius: 10px; background: #fff; }
    .header { text-align: center; padding-bottom: 20px; border-bottom: 2px solid $color_primary; }
    .header img { width: 100px; }
    .header h1 { margin: 10px 0 0; color: $color_primary; }
    .details, .footer { margin-top: 20px; }
    .details table { width: 100%; border-collapse: collapse; }
    .details td { padding: 10px; border: 1px solid $color_primary; }
    .footer { text-align: center; font-size: 12px; color: #555; margin-top: 20px; padding-top: 10px; border-top: 1px solid $color_primary; }
</style>

<div class='container'>
    <div class='header'>
        <h1>QUITTANCE DE RÉSERVATION</h1>
    </div>

    <div class='details'>
        <table>
            <tr>
                <td><strong>Status:</strong> réservé</td>
                <td><strong>Motif:</strong> {$data['motif']}</td>
            </tr>
            <tr>
                <td><strong>Nom du client:</strong> {$data['name']}</td>
                <td><strong>Profession:</strong> {$data['profession']}</td>
            </tr>
            <tr>
                <td><strong>Téléphone:</strong> {$data['phonenum']}</td>
                <td><strong>Provenance:</strong> {$data['address']}</td>
            </tr>
            <tr>
                <td><strong>Chambre réservée:</strong> {$data['room_name']}</td>
                <td><strong>Tarif:</strong> {$data['price']} $price</td>
            </tr>
            <tr>
                <td><strong>Entrée:</strong> $checkin</td>
                <td><strong>Sortie:</strong> $checkout</td>
            </tr>
            <tr>
                <td colspan='2'><strong>Date de réservation:</strong> $date</td>
            </tr>
            <tr>
                <td><strong>Numéro de chambre:</strong> {$data['room_no']}</td>
                <td><strong>Montant total:</strong> {$data['trans_amount']} FCFA</td>
            </tr>
        </table>
    </div>

    <div class='footer'>
        <p>Merci d'avoir choisi <strong>$hotel_name</strong>. Nous espérons vous revoir bientôt.</p>
    </div>
</div>
";

    // Génération du PDF avec mPDF
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($table_data);
    $mpdf->Output("Quittance_{$data['id']}.pdf", 'D');
} else {
    header("Location: dashboard.php");
}