<?php
include "../config/functions.php";
$searchTerm = $_GET['term'];

$sql = "SELECT DISTINCT nama_pelanggan FROM report_obl WHERE nama_pelanggan LIKE '%$searchTerm%' ORDER BY nama_pelanggan ASC";

$hasil = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($hasil)) {
    $data[] = $row['nama_pelanggan'];
}
echo json_encode($data);
