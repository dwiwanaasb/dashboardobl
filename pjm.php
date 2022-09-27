<?php
error_reporting(E_ERROR);
session_start();
require 'config/functions.php';

if (!isset($_SESSION["login"])) {
    header('location: login.php');
    exit;
}

$nama = $_SESSION['nama'];
$namaAkun = query("SELECT * FROM account WHERE nama = '$nama'")[0];
$level = $namaAkun["level"];

if (isset($_GET["witel"]) or isset($_GET["tahun"]) or isset($_GET["mitra"]) or isset($_GET["pelanggan"]) or isset($_GET["segmen"]) or isset($_GET["status"])) {
    $witel = $_GET["witel"];
    $tahun = $_GET["tahun"];
    $mitra = $_GET["mitra"];
    $pelanggan = $_GET["pelanggan"];
    $segmen = $_GET["segmen"];
    $status = $_GET["status"];
} else {
    $witel = '';
    $tahun = '';
    $mitra = '';
    $pelanggan = '';
    $segmen = '';
    $status = '';
}

if ($level == 'mitra') {
    if ($witel == '' and $tahun == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $query = query("SELECT * FROM report_obl WHERE UPPER(proses) = 'PJM' AND 
                UPPER(nama_vendor) LIKE '%$mitra%'
                ORDER BY folder ASC");
    } else {
        $query = query("SELECT * FROM report_obl WHERE UPPER(proses) = 'PJM' AND 
                UPPER(nama_vendor) LIKE '%$mitra%' AND 
                (UPPER(segmen) LIKE '%$segmen%' AND
                SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                UPPER(witel) LIKE '%$witel%' AND 
                UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                UPPER(status) LIKE '%$status%') 
                ORDER BY folder ASC");
    }
} else if ($level == 'witel') {
    if ($tahun == '' and $mitra == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $query = query("SELECT * FROM report_obl WHERE UPPER(proses) = 'PJM' AND 
                UPPER(witel) LIKE '%$witel%'
                ORDER BY folder ASC");
    } else {
        $query = query("SELECT * FROM report_obl WHERE UPPER(proses) = 'PJM' AND 
                UPPER(witel) LIKE '%$witel%' AND 
                (UPPER(segmen) LIKE '%$segmen%' AND
                SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                UPPER(nama_vendor) LIKE '%$mitra%' AND 
                UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                UPPER(status) LIKE '%$status%') 
                ORDER BY folder ASC");
    }
} else {
    if ($witel == '' and $tahun == '' and $mitra == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $query = query("SELECT * FROM report_obl WHERE UPPER(proses) = 'PJM' 
            ORDER BY folder ASC");
    } else {
        $query = query("SELECT * FROM report_obl WHERE UPPER(proses) = 'PJM' AND 
            (UPPER(witel) LIKE '%$witel%' AND
            SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
            UPPER(segmen) LIKE '%$segmen%' AND 
            UPPER(nama_vendor) LIKE '%$mitra%' AND 
            UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
            UPPER(status) LIKE '%$status%') 
            ORDER BY folder ASC");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleDetail.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/ajax/ajaxPJM.js"></script>
    <title>Dokumen di PJM</title>
</head>

<body>
    <div class="container">
        <?php
        $witel = rawurlencode($witel);
        $tahun = rawurlencode($tahun);
        $mitra = rawurlencode($mitra);
        $pelanggan = rawurlencode($pelanggan);
        $segmen = rawurlencode($segmen);
        $status = rawurlencode($status);
        ?>
        <input type="hidden" id="dataWitel" value="<?= $witel; ?>">
        <input type="hidden" id="dataTahun" value="<?= $tahun; ?>">
        <input type="hidden" id="dataMitra" value="<?= $mitra; ?>">
        <input type="hidden" id="dataPelanggan" value="<?= $pelanggan; ?>">
        <input type="hidden" id="dataSegmen" value="<?= $segmen; ?>">
        <input type="hidden" id="dataStatus" value="<?= $status; ?>">
        <h1>Dokumen di PJM</h1>

        <div class="header">
            <div class="_1">
                <img src="img/search.png" alt="" id="search">
                <input type="text" name="keyword" id="keyword" placeholder="Masukkan keyword..." autocomplete="off">
            </div>
            <div class="_2">
                <a href="downloadData/downloadPJM.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>" id="btnDownload"><button class="download" style="background-color: #FD7E14;"><img src="./img/download.png" alt="">Download</button></a>
                <a href="index.php"><button class="dashboard" style="background-color: #20C997;"><img src="img/home.png" alt="">Dashboard</button></a>
            </div>
        </div>

        <div class="content" id="content-table">
            <table>
                <tr>
                    <th class="aksi" id="aksiTh">AKSI</th>
                    <th>NO</th>
                    <th>PROSES</th>
                    <th>SEGMEN</th>
                    <th>TANGGAL SUBMIT</th>
                    <th>TANGGAL UPDATE</th>
                    <th>FOLDER</th>
                    <th>JENIS SPK</th>
                    <th>WITEL</th>
                    <th>NAMA PELANGGAN</th>
                    <th>LAYANAN</th>
                    <th>NAMA VENDOR</th>
                    <th>JANGKA WAKTU</th>
                    <th>NILAI KB</th>
                    <th>NO KFS/SPK</th>
                    <th>NO KL/WO/Surat Pesanan</th>
                    <th>NO ORDER</th>
                    <th>SID</th>
                    <th>PIC</th>
                    <th>STATUS</th>
                    <th>STATUS SM</th>
                    <th>KETERANGAN</th>
                    <th>UPDATED BY</th>
                </tr>
                <?php $i = 1; ?>
                <?php foreach ($query as $row) : ?>
                    <tr>
                        <td class="aksi" id="aksiTd">
                            <div>
                                <a href="updateData.php?id=<?= $row["id"]; ?>"><button class="update"><img src="img/update.png" alt=""></button></a>
                                <a href="delete.php?id=<?= $row["id"]; ?>" class="deleteHref"><button class="delete"><img src="img/delete.png" alt=""></button></a>
                            </div>
                        </td>
                        <td class="no"><?= $i; ?></td>
                        <td><?= $row["proses"]; ?></td>
                        <td><?= $row["segmen"]; ?></td>
                        <td><?= $row["tanggal_submit"]; ?></td>
                        <td><?= $row["tanggal_update"]; ?></td>
                        <td><?= $row["folder"]; ?></td>
                        <td><?= $row["jenis_spk"]; ?></td>
                        <td><?= $row["witel"]; ?></td>
                        <td><?= $row["nama_pelanggan"]; ?></td>
                        <td><?= $row["layanan"]; ?></td>
                        <td><?= $row["nama_vendor"]; ?></td>
                        <td><?= $row["jangka_waktu"]; ?></td>
                        <td><?= rupiah($row["nilai_kb"]); ?></td>
                        <td><?= $row["no_KFS_SPK"]; ?></td>
                        <td><?= $row["no_KL_WO_SuratPesanan"]; ?></td>
                        <td><?= $row["no_order"]; ?></td>
                        <td><?= $row["sid"]; ?></td>
                        <td><?= $row["pic"]; ?></td>
                        <td><?= $row["status"]; ?></td>
                        <td><?= $row["statusSM"]; ?></td>
                        <td class="keterangan"><?= $row["keterangan"]; ?></td>
                        <td><?= $row["updated_by"]; ?></td>
                        <?php
                        if ($level == 'witel' or $level == 'mitra') {
                            echo "<script>
                                document.getElementById('aksiTh').style.display = 'none';
                                document.getElementById('aksiTd').remove();
                                var tdTable = document.getElementsByTagName('td');
                                for (var i = 0; i < tdTable.length; i++) {
                                    tdTable[i].style.padding = '4px 6px';
                                }
                            </script>";
                        }
                        ?>
                        <?php $i++; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>

</html>