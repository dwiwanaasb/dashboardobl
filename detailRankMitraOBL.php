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
$mitra = $_GET["mitra"];

$query = query("SELECT * FROM report_obl WHERE 
                UPPER(proses) = 'MITRA OBL' AND 
                UPPER(nama_vendor) LIKE '%$mitra%'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleDetailAksi.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Detail Rank Mitra OBL</title>
</head>

<body>
    <div class="container">
        <h1>Detail Mitra <?= $mitra; ?></h1>

        <div class="header">
            <!-- <div class="_1">
                <img src="img/search.png" alt="" id="search">
                <input type="text" name="keyword" id="keyword" placeholder="Masukkan keyword..." autocomplete="off" autofocus>
            </div> -->
            <div class="_2">
                <a href="index.php"><button style="background-color: #20C997;"><img src="img/home.png" alt="">Dashboard</button></a>
            </div>
        </div>

        <div class="content" id="content-table">
            <table>
                <tr>
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
                    <th class="aksi" id="aksiTh">Aksi</th>
                </tr>
                <?php $i = 1; ?>
                <?php foreach ($query as $row) : ?>
                    <tr>
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