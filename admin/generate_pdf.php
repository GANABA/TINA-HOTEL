<?php
require('includes/db_config.php');
require('includes/essentials.php');
require('includes/mpdf/vendor/autoload.php');

adminLogin();

if (isset($_GET['gen_pdf']) && isset($_GET['id'])) {

    $frm_data = filteration($_GET);

    $query = "SELECT bo.*, bd.*, uc.email, r.type
    FROM booking_order bo
    INNER JOIN booking_details bd ON bo.booking_id = bd.booking_id
    INNER JOIN user uc ON bo.user_id = uc.id
    INNER JOIN rooms r ON bd.room_name = r.name
    WHERE ((bo.booking_status = 'booked' AND bo.arrival = 1)
    OR (bo.booking_status = 'cancelled'))
    AND bo.booking_id = '$frm_data[id]'";


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

    if ($data['booking_status'] == 'cancelled') {
        $badge_span = "annulé";
    } else {
        $badge_span = "réservé";
    }

    $price = "";
    if($data['type'] == "Salle"){
        $price = "FCFA par jour";
    }else{
        $price = "FCFA par nuit";
    }

    $hotel_name = "TINA HOTEL";
    $color_primary = "#000000"; // Bleu professionnel
    $color_secondary = "#f8f9fa"; // Gris clair

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
        <h1>QUITTANCE DE RESERVATION</h1>
    </div>

    <div class='details'>
        <table>
            <tr>
                <td><strong>Numéro de réservation:</strong> $data[order_id]</td>
                <td><strong>Date de réservation:</strong> $date</td>
            </tr>
            <tr>
                <td colspan='2'><strong>Status:</strong> $badge_span</td>
            </tr>
            <tr>
                <td><strong>Nom du client:</strong> $data[user_name]</td>
                <td><strong>Email:</strong> $data[email]</td>
            </tr>
            <tr>
                <td><strong>Profession:</strong> $data[profession]</td>
                <td><strong>Téléphone:</strong> $data[phonenum]</td>
            </tr>
            <tr>
                <td><strong>Provenance:</strong> $data[address]</td>
                <td><strong>Motif:</strong> $data[motif]</td>
            </tr>
            <tr>
                <td><strong>Chambre réservée:</strong> $data[room_name]</td>
                <td><strong>Tarif:</strong> $data[price] $price</td>
            </tr>
            <tr>
                <td><strong>Entrée:</strong> $checkin</td>
                <td><strong>Sortie:</strong> $checkout</td>
            </tr>
";

    if ($data['booking_status'] == 'cancelled') {
        $table_data .= "
        <tr>
            <td colspan='2'><strong>Montant total:</strong> $data[trans_amount] FCFA</td>
        </tr>
    ";
    } else {
        $table_data .= "
        <tr>
            <td><strong>Numéro de chambre:</strong> $data[room_no]</td>
            <td><strong>Montant total:</strong> $data[trans_amount] FCFA</td>
        </tr>
    ";
    }

    $table_data .= "
        </table>
    </div>

    <div class='footer'>
        <p>Merci d'avoir choisi <strong>$hotel_name</strong>. Nous espérons vous revoir bientôt.</p>
    </div>
</div>
";

    //Genarate PDF

    // Create an instance of the class:
    $mpdf = new \Mpdf\Mpdf();
    // Write some HTML code:
    $mpdf->WriteHTML($table_data);
    // Output a PDF file directly to the browser
    $mpdf->Output($data['order_id'].'.pdf','D');

    echo $table_data;
} else {
    header("Location: dashboard.php");
}
