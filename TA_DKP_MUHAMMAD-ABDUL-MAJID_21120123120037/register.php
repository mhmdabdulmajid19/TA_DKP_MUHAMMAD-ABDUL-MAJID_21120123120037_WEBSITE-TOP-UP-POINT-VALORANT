<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Validasi input
    if (empty($username)) {
        echo "Username tidak boleh kosong!";
    } elseif (strlen($username) <= 7) {
        echo "Username terlalu pendek!";
    } elseif (empty($email)) {
        echo "Email tidak boleh kosong!";
    } elseif (strlen($email) <= 10) {
        echo "Email terlalu pendek!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email tidak valid!";
    } elseif (empty($password)) {
        echo "Password tidak boleh kosong!";
    } elseif (strlen($password) <= 8) {
        echo "Password terlalu pendek!";
    } else {
        // Simpan data ke file
        $file = fopen('database.txt', 'a');
        fwrite($file, "$username,$email,$password\n");
        fclose($file);
        echo "Registrasi berhasil!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        <h2>Register</h2>
        <form method="post" action="register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username"><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>
            <input type="submit" class="btn" value="Register">
        </form>
    </div>
</body>
</html>
