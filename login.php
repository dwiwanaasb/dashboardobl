<?php
clearstatcache();
header('Expires: Sun, 01 Jan 2014 00:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
error_reporting(E_ERROR);
session_start();
require 'config/functions.php';

if (isset($_COOKIE["id"]) && isset($_COOKIE["key"])) {
    $id = $_COOKIE["id"];
    $key = $_COOKIE["key"];

    $result = mysqli_query($conn, "SELECT username FROM account WHERE id = $id");
    $data = mysqli_fetch_assoc($result);

    if ($key === hash('sha256', $row['username'])) {
        $_SESSION["login"] = true;
    }
}

if (isset($_SESSION["login"])) {
    header('location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styleLogin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/script.js"></script>
    <title>Login</title>
</head>

<body>
    <div class="area">
        <div class="container">
            <h2>Login Form</h2>
            <form action="" method="post">
                <div class="form-input">
                    <label for="">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username..." autocomplete="off" />
                </div>
                <div class="form-input">
                    <label for="">Password</label>
                    <input type="password" name="password" id="id_password" placeholder=" Masukkan password..." autocomplete="off" />
                    <i class="fa-regular fa-eye" id="togglePassword"></i>
                </div>
                <div class="form-cookie">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="">Remember me</label>
                </div>
                <div class="form-button">
                    <button type="submit" name="login" id="login">Login</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST["login"])) {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);

        $query = "SELECT * FROM account WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            $nama = $row["nama"];
            $username = $row["username"];
            $level = $row["level"];

            if ($level == 'adminpjm' or $level == 'adminobl' or $level == 'witel' or $level == 'mitra' or $level == 'inputerwitel') {
                $_SESSION["login"] = true;
                $_SESSION["nama"] = $nama;
                $_SESSION["username"] = $username;

                if (isset($_POST["remember"])) {
                    setcookie('id', $row['id'], time() + 604800);
                    setcookie('key', hash('sha256', $username), time() + 604800);
                }
                echo "<script>
                    let lat = '" . $nama . "';
                    Swal.fire({
                        icon: 'success',
                        title: 'Login berhasil',
                        showConfirmButton: false,
                        text: 'Selamat datang ${nama}!'
                    })
                    setTimeout(function(){
                        document.location.href = 'index.php';
                    }, 1800);
                </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        showConfirmButton: false,
                        text: 'Periksa kembali username dan password anda!'
                    })
                    setTimeout(function(){
                        document.location.href = 'login.php';
                    }, 1300);
                </script>";
        }
    }
    ?>
</body>

</html>