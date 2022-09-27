<?php
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'WITEL' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);
$totalWitel = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'OBL' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);
$totalOBL = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'LEGAL' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);
$totalLegal = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'MITRA OBL' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);
$totalMitraOBL = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'CLOSE' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);
$totalClose = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'MITRA PJM' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);
$totalMitraPJM = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'PJM' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);
$totalPJM = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'DONE' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);

$totalDone = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(proses) = 'CANCEL' AND 
                        (UPPER(witel) LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%')");
$data = mysqli_fetch_assoc($result);
$totalCancel = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl");
$data = mysqli_fetch_assoc($result);
$totalAll = $data['total'];
