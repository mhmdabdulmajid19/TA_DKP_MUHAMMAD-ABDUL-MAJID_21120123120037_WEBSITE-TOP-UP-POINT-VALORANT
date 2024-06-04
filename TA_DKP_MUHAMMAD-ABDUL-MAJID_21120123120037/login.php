<?php
session_start();

class LoginController {
    private $error_msg = "";

    public function __construct() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->login();
        }
    }

    private function validate_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    private function login() {
        $email = $this->validate_input($_POST['email']);
        $password = $this->validate_input($_POST['password']);
    
        // Validasi input
        if (empty($email)) {
            $this->error_msg = "Email tidak boleh kosong!";
        } elseif (empty($password)) {
            $this->error_msg = "Password tidak boleh kosong!";
        } else {
            // Baca file database
            $file = fopen('database.txt', 'r');
            $sukses = false;
            while (($line = fgets($file)) !== false) {
                list($username, $user_email, $user_password) = explode(',', trim($line));
                if ($email == $user_email && $password == $user_password) {
                    $sukses = true;
                    $_SESSION['username'] = $username;
                    $_SESSION['email'] = $email;
                    break;
                }
            }
            fclose($file);
    
            if ($sukses) {
                // Redirect ke halaman purchase.php setelah login berhasil
                header("Location: purchase.php");
                exit();
            } else {
                $this->error_msg = "Email atau Password salah!";
            }
        }
    }
    

    public function get_error_message() {
        return $this->error_msg;
    }
}

$controller = new LoginController();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2>Login</h2>
        <?php
        if ($controller->get_error_message()) {
            echo "<p style='color: red;'>" . $controller->get_error_message() . "</p>";
        }
        ?>
        <form method="post" action="login.php">
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email"><br><br>
            
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br><br>
            
            <input type="submit" class="btn" value="Login">
        </form>
    </div>
</body>
</html>
