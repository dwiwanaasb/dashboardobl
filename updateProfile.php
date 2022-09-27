<?php
error_reporting(E_ERROR);
session_start();
require 'config/functions.php';

if (!isset($_SESSION["login"])) {
    header('location: login.php');
    exit;
}

$username = $_SESSION["username"];
$query = query("SELECT id FROM account WHERE username = '$username'")[0];
$id = $query["id"];
$query = query("SELECT * FROM account WHERE id = $id")[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/styleForm.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/script.js"></script>
    <title>Update Profile</title>
</head>

<body>
    <div class="area">
        <div class="container">
            <h2>Update Profile</h2>
            <form action="" method="post">
                <div class="form-input">
                    <label for="">Nama</label>
                    <input type="text" name="nama" placeholder="Masukkan nama..." value="<?= $query["nama"] ?>" autocomplete="off" required />
                </div>
                <div class="form-input" style="cursor: not-allowed;">
                    <label for="">Username</label>
                    <input type="text" name="username" placeholder="Masukkan username..." value="<?= $query["username"] ?>" autocomplete="off" required style="pointer-events: none;" />
                </div>
                <div class="form-input">
                    <label for="">Password</label>
                    <input type="password" name="password" id="id_password" placeholder=" Masukkan password..." autocomplete="off" required />
                    <i class="fa-regular fa-eye" id="togglePassword"></i>
                </div>
                <div class="form-input">
                    <label for="">Konfirmasi Password</label>
                    <input type="password" name="cpassword" id="id_cpassword" placeholder=" Masukkan konfirmasi password..." autocomplete="off" required />
                    <i class="fa-regular fa-eye" id="toggleCPassword"></i>
                </div>
                <div class="form-button">
                    <button type="submit" name="update">Update</button>
                    <a href="index.php">Kembali ke Dashboard</a>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST["update"])) {
        if (updateProfile($_POST, $id) == 'berhasil') {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Akun berhasil diperbarui, silahkan login ulang',
                    showConfirmButton: false
                })
                setTimeout(function(){
                    document.location.href = 'logout.php';
                }, 1800);                
            </script>";
        } else if (updateProfile($_POST, $id) == 'error konfirmasi') {
            echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    showConfirmButton: false,
                    text: 'Konfirmasi password tidak sesuai!'
                })
                setTimeout(function(){
                    window.history.back()
                }, 1500);
            </script>";
        } else if (updateProfile($_POST, $id) == 'error') {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    showConfirmButton: false,
                    text: 'Akun gagal diupdate!'
                })
                setTimeout(function(){
                    window.history.back()
                }, 1500);  
            </script>";
        }
    }
    ?>
</body>

</html>