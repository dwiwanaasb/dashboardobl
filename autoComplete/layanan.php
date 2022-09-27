<?php
include "../config/functions.php";
$searchTerm = $_GET['term'];

$sql = "SELECT DISTINCT layanan FROM report_obl WHERE layanan LIKE '%$searchTerm%' ORDER BY layanan ASC";

$hasil = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_array($hasil)) {
    $data[] = $row['layanan'];
}
echo json_encode($data);
