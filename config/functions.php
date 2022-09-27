<?php
require 'connection.php';

function query($query)
{
    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function rupiah($angka)
{
    if (is_null($angka)) {
        $hasil_rupiah = '-';
    } else {
        $uang = str_replace(".", "", $angka);
        $hasil_rupiah = "Rp. " . number_format($uang, 0, ',',);
    }

    return $hasil_rupiah;
}

function toNumber($angka)
{
    $val = preg_replace('/[^0-9]/', '', $angka);
    return $val;
}

function delete($id)
{
    global $conn;

    $query = "UPDATE report_obl SET proses = 'CANCEL' WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function updateProfile($post, $id)
{
    global $conn;

    $nama = htmlspecialchars($post['nama']);
    $username = htmlspecialchars($post['username']);
    $password = mysqli_real_escape_string($conn, $post['password']);
    $cpassword = mysqli_real_escape_string($conn, $post['cpassword']);

    if ($password === $cpassword) {
        $query = "UPDATE account SET nama = '$nama', username = '$username', password = '$password' WHERE id = $id";
        mysqli_query($conn, $query);

        $update = 'berhasil';
        return $update;
    } else {
        $update = 'error konfirmasi';
        return $update;
    }
}
