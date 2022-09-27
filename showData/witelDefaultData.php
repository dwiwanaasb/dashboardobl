<?php
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'WITEL'");
$data = mysqli_fetch_assoc($result);
$totalWitel = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'OBL'");
$data = mysqli_fetch_assoc($result);
$totalOBL = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'LEGAL'");
$data = mysqli_fetch_assoc($result);
$totalLegal = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'MITRA OBL'");
$data = mysqli_fetch_assoc($result);
$totalMitraOBL = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'CLOSE SM'");
$data = mysqli_fetch_assoc($result);
$totalClose = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'MITRA PJM'");
$data = mysqli_fetch_assoc($result);
$totalMitraPJM = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'PJM'");
$data = mysqli_fetch_assoc($result);
$totalPJM = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'DONE'");
$data = mysqli_fetch_assoc($result);
$totalDone = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(proses) = 'CANCEL'");
$data = mysqli_fetch_assoc($result);
$totalCancel = $data['total'];

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM report_obl");
$data = mysqli_fetch_assoc($result);
$totalAll = $data['total'];
