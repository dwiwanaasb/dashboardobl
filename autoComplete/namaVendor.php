<?php
include "../config/functions.php";
$searchTerm = $_GET['term'];

$sql = "SELECT DISTINCT nama_vendor FROM report_obl WHERE nama_vendor LIKE '%$searchTerm%' ORDER BY nama_vendor ASC";

$hasil = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($hasil)) {
    $data[] = $row['nama_vendor'];
}
echo json_encode($data);
