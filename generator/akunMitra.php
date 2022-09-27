<?php
session_start();
require '../config/functions.php';

$query = query("SELECT DISTINCT nama_vendor FROM report_obl WHERE nama_vendor IS NOT NULL AND nama_vendor != '-'");
$i = "akunmitra";
$j = 1;
foreach ($query as $data) {
    $nama = $data["nama_vendor"];
    $abbreviation = explode(' ', trim($nama))[0];
    $abbreviation = strtolower($abbreviation);
    $username = "mitra" . $abbreviation;
    $password = $i . $abbreviation;
    $level = "mitra";

    $cek_data = mysqli_query($conn, "SELECT username FROM account WHERE username = '$username'");

    if (mysqli_fetch_assoc($cek_data)) {
        mysqli_query($conn, "UPDATE account SET nama = '$nama', username = '$username', password = '$password', level = '$level' WHERE username = '$username'");
        $j++;
    } else {
        mysqli_query($conn, "INSERT INTO account (nama, username, password, level) VALUES ('$nama', '$username','$password','$level')");
        $j++;
    }
}
