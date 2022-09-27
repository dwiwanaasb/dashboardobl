<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
</head>

<body>
    <?php
    error_reporting(E_ERROR);
    session_start();
    require 'config/functions.php';

    if (!isset($_SESSION["login"])) {
        header('location: login.php');
        exit;
    }

    $id = $_GET["id"];

    if (delete($id) == 1) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Data berhasil dihapus',
                    showConfirmButton: false
                })
                setTimeout(function(){
                    document.location.href = 'index.php';
                }, 1800);
            </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi kesalahan',
                    showConfirmButton: false,
                    text: 'Data gagal dihapus!'
                })
                setTimeout(function(){
                    document.location.href = 'index.php';
                }, 1500);
            </script>";
    }
    ?>
</body>

</html>