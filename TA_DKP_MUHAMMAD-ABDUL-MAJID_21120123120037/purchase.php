<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['email'])) {
    // Redirect ke halaman login jika belum login
    header("Location: login.php");
    exit();
}

function validate_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$error_msg = "";
$success_msg = "";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = validate_input($_POST['user_id']);
        $server = validate_input($_POST['server']);
        $region = validate_input($_POST['region']);
        $point = validate_input($_POST['point']);
        $payment_method = validate_input($_POST['payment_method']);
        $phone_number = validate_input($_POST['phone_number']);

        if (empty($user_id)) {
            $error_msg = "ID tidak boleh kosong!";
        } elseif (strlen($user_id) <= 6) {
            $error_msg = "ID terlalu pendek!";
        } elseif (empty($server)) {
            $error_msg = "Server tidak boleh kosong!";
        } elseif (empty($point)) {
            $error_msg = "Harap pilih nominal point!";
        } elseif (empty($payment_method)) {
            $error_msg = "Harap pilih metode pembayaran!";
        } elseif (empty($phone_number)) {
            $error_msg = "No HP tidak boleh kosong!";
        } elseif (strlen($phone_number) <= 10) {
            $error_msg = "No HP terlalu pendek!";
        } else {
            $file = fopen('orders.txt', 'a');
            $date = date('Y-m-d H:i:s');
            $data = "$user_id,$server,$region,$point,$payment_method,$phone_number,$date\n";
            fwrite($file, $data);
            fclose($file);
            $success_msg = "Pembelian berhasil! Detail pesanan Anda: \nUser ID: $user_id\nServer: $server\nRegion: $region\npoint: $point\nMetode Pembayaran: $payment_method\nNo HP: $phone_number\nTanggal: $date";
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase point</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('bgvalorant.jpg') no-repeat center center fixed;
            background-size: cover;
            text-align: center;
        }
        .container {
            width: 50%;
            margin: auto;
            background: url('bgform.jpg') no-repeat center center fixed;
            background-size: cover;
            color: black;
            padding: 20px;
            border: 3px solid #135ec7;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .btn {
            padding: 10px 20px;
            background-color: #135ec7;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pembelian Point Valorant</h2>
        <?php
        if (!empty($error_msg)) {
            echo "<p style='color: red;'>$error_msg</p>";
        }
        if (!empty($success_msg)) {
            echo "<p style='color: green;'>$success_msg</p>";
        }
        ?>
        <form method="post" action="purchase.php">
            <label for="user_id">User ID:</label><br>
            <input type="text" id="user_id" name="user_id"><br><br>
            
            <label for="server">Server:</label><br>
            <select id="server" name="server">
                <option value="">Pilih Server</option>
                <option value="Asian">Asian</option>
                <option value="Europe">Europe</option>
                <option value="America">America</option>
            </select><br><br>

            <label for="region">Region:</label><br>
            <select id="region" name="region">
                <option value="">Pilih Region</option>
                <option value="Indonesia">Indonesia</option>
                <option value="Singapure">Singapure</option>
                <option value="Thailand">Thailand</option>
                <option value="Philippines">Philippines</option>
                <option value="Japan">Japan</option>
                <option value="China">China</option>
                <option value="Russia">Russia</option>
                <option value="Germany">Germany</option>
                <option value="Spain">Spain</option>
                <option value="France">France</option>
                <option value="Ukraine">Ukraine</option>
                <option value="Brazil">Brazil</option>
                <option value="USA">USA</option>
            </select><br><br>

            <label for="point">Nominal point:</label><br>
            <select id="point" name="point">
                <option value="">Pilih point</option>
                <option value="125 point - 13K">125 point - 13K</option>
                <option value="420 point - 45K">420 point - 45K</option>
                <option value="700 point - 72K">700 point - 72K</option>
                <option value="1375 point - 135K">1375 point - 135K</option>
                <option value="2400 point - 223K">2400 point - 223K</option>
                <option value="4000 point - 360K">4000 point - 360K</option>
                <option value="8150 point - 720K">8150  point - 720K</option>
            </select><br><br>

            <label for="payment_method">Metode Pembayaran:</label><br>
            <select id="payment_method" name="payment_method">
                <option value="">Pilih Metode Pembayaran</option>
                <option value="Gopay">Gopay</option>
                <option value="Dana">Dana</option>
                <option value="Shopeepay">Shopeepay</option>
            </select><br><br>

            <label for="phone_number">No HP:</label><br>
            <input type="text" id="phone_number" name="phone_number"><br><br>

            <input type="submit" class="btn" value="Order">
        </form>
    </div>
</body>
</html>
