<?php
$server = "localhost";
$username = "root";
$password = "";
$db_name = "dashboa4_db_tr6bot";

$conn = mysqli_connect($server, $username, $password, $db_name);

if (!$conn) {
    die("Gagal terhubung ke database " . mysqli_connect_error());
}
