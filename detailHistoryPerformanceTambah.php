<?php
error_reporting(E_ERROR);
session_start();
require 'config/functions.php';

if (!isset($_SESSION["login"])) {
    header('location: login.php');
    exit;
}

$nama = $_SESSION['nama'];
$namaAdmin = $_GET["nama"];
$namaAdmin = rawurldecode($namaAdmin);
$namaAkun = query("SELECT * FROM account WHERE nama = '$nama'")[0];
$level = $namaAkun["level"];

$query = query("SELECT * FROM historytambah WHERE updated_by = '$namaAdmin'");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleHistory.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Detail History Performance</title>
</head>

<body>
    <div class="container">
        <h2>Detail History Performance</h2>
        <h1><?= $namaAdmin; ?></h1>

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
                    <th>TANGGAL SUBMIT</th>
                    <th>TANGGAL UPDATE</th>
                    <th>NAMA</th>
                    <th>KEGIATAN</th>
                </tr>
                <?php $i = 1; ?>
                <?php foreach ($query as $row) : ?>
                    <tr>
                        <td class="no"><?= $i; ?></td>
                        <td><?= $row["tanggal_submit"]; ?></td>
                        <td><?= $row["tanggal_update"]; ?></td>
                        <td><?= $row["updated_by"]; ?></td>
                        <td> Membuat dokumen baru</td>
                        <td class="aksi">
                            <div>
                                <a href="#<?= $row["id"]; ?>"><button class="detailDokumen">Detail</button></a>
                                <div id="<?= $row["id"]; ?>" class="overlay">
                                    <a class="cancel" href="#"></a>
                                    <div class="container">
                                        <div class="header">
                                            <h2>Hasil perubahan dokumen</h2>
                                        </div>
                                        <div class="modal">
                                            <div class="content">
                                                <label for="">PROSES</label>
                                                <span><?= $row["proses"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">SEGMEN</label>
                                                <span><?= $row["segmen"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">FOLDER</label>
                                                <span><?= $row["folder"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">JENIS SPK</label>
                                                <span><?= $row["jenis_spk"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">WITEL</label>
                                                <span><?= $row["witel"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NAMA PELANGGAN</label>
                                                <span><?= $row["nama_pelanggan"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">LAYANAN</label>
                                                <span><?= $row["layanan"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NAMA VENDOR</label>
                                                <span><?= $row["nama_vendor"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">JANGKA WAKTU</label>
                                                <span><?= $row["jangka_waktu"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NILAI KB</label>
                                                <span><?= rupiah($row["nilai_kb"]); ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NO KFS/SPK</label>
                                                <span><?= $row["no_KFS_SPK"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NO KL/WO/SURAT PESANAN</label>
                                                <span><?= $row["no_KL_WO_SuratPesanan"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NO ORDER</label>
                                                <span><?= $row["no_order"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">SID</label>
                                                <span><?= $row["sid"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">PIC</label>
                                                <span><?= $row["pic"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">STATUS</label>
                                                <span><?= $row["status"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">STATUS SM</label>
                                                <span><?= $row["statusSM"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="" class="keterangan">KETERANGAN</label>
                                                <textarea name="keterangan" id="keterangan" readonly><?= $row["keterangan"]; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                    unset($diffProses);
                    unset($diffSegmen);
                    unset($diffTanggalSubmit);
                    unset($diffTanggalUpdate);
                    unset($diffFolder);
                    unset($diffJenisSPK);
                    unset($diffWitel);
                    unset($diffNamaPelanggan);
                    unset($diffLayanan);
                    unset($diffNamaVendor);
                    unset($diffJangkaWaktu);
                    unset($diffNilaiKB);
                    unset($diffNoKFS);
                    unset($diffNoKL);
                    unset($diffNoOrder);
                    unset($diffSid);
                    unset($diffPIC);
                    unset($diffStatus);
                    unset($diffStatusSM);
                    unset($diffKeterangan);
                    ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>

</html>