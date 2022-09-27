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

$query = query("SELECT * FROM historybefore WHERE updated_by = '$namaAdmin'");
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
                        <?php
                        $id = $row["id"];
                        $id = intval($id);
                        $data = query("SELECT * FROM historyafter WHERE id = $id")[0];
                        $afterProses = $data["proses"];
                        $afterSegmen = $data["segmen"];
                        $afterTanggalSubmit = $data["tanggal_submit"];
                        $afterTanggalUpdate = $data["tanggal_update"];
                        $afterFolder = $data["folder"];
                        $afterJenisSPK = $data["jenis_spk"];
                        $afterWitel = $data["witel"];
                        $afterNamaPelanggan = $data["nama_pelanggan"];
                        $afterLayanan = $data["layanan"];
                        $afterNamaVendor = $data["nama_vendor"];
                        $afterJangkaWaktu = $data["jangka_waktu"];
                        $afterNilaiKB = $data["nilai_kb"];
                        $afterNoKFS = $data["no_KFS_SPK"];
                        $afterNoKL = $data["no_KL_WO_SuratPesanan"];
                        $afterNoOrder = $data["no_order"];
                        $afterSid = $data["sid"];
                        $afterPIC = $data["pic"];
                        $afterStatus = $data["status"];
                        $afterStatusSM = $data["statusSM"];
                        $afterKeterangan = $data["keterangan"];
                        ?>

                        <td class="no"><?= $i; ?></td>
                        <td><?= $row["tanggal_update"]; ?></td>
                        <td><?= $row["updated_by"]; ?></td>

                        <?php
                        if ($row["proses"] != $afterProses) {
                            $diffProses = "Memindahkan dokumen dari "  . "<b>" . $row["proses"] . "</b>" . " ke " . "<b>" . $afterProses . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["segmen"] != $afterSegmen) {
                            $diffSegmen = "Mengubah segmen dari " . "<b>" . $row["segmen"] . "</b>" . " menjadi " .  "<b>" . $afterSegmen . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["tanggal_submit"] != $afterTanggalSubmit) {
                            $diffTanggalSubmit = "Mengubah tanggal submit dari " .  "<b>" . $row["tanggal_submit"] . "</b>" . " menjadi " .  "<b>" . $afterTanggalSubmit . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["tanggal_update"] != $afterTanggalUpdate) {
                            $diffTanggalUpdate = "Mengubah tanggal update dari " .  "<b>" . $row["tanggal_update"] . "</b>" . " menjadi " .  "<b>" . $afterTanggalUpdate . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["folder"] != $afterFolder) {
                            $diffFolder = "Mengubah folder dari " . "<b>" . $row["folder"] . "</b>" . " menjadi " . "<b>" . $afterFolder . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["jenis_spk"] != $afterJenisSPK) {
                            $diffJenisSPK = "Mengubah jenis SPK dari " . "<b>" . $row["jenis_spk"]  . "</b>" . " menjadi " . "<b>" . $afterJenisSPK . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["witel"] != $afterWitel) {
                            $diffWitel = "Mengubah witel dari " . "<b>" . $row["witel"]  . "</b>" . " menjadi " . "<b>" . $afterWitel . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["nama_pelanggan"] != $afterNamaPelanggan) {
                            $diffNamaPelanggan = "Mengubah nama pelanggan dari " . "<b>" . $row["nama_pelanggan"]  . "</b>" . " menjadi " .  "<b>" . $afterNamaPelanggan . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["layanan"] != $afterLayanan) {
                            $diffLayanan = "Mengubah layanan dari " .  "<b>" . $row["layanan"]  . "</b>" . " menjadi " . "<b>" . $afterLayanan . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["nama_vendor"] != $afterNamaVendor) {
                            $diffNamaVendor = "Mengubah nama vendor dari " . "<b>" . $row["nama_vendor"] . "</b>" . " menjadi " .  "<b>" . $afterNamaVendor . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["jangka_waktu"] != $afterJangkaWaktu) {
                            $diffJangkaWaktu = "Mengubah jangka waktu dari " . "<b>" . $row["jangka_waktu"] . "</b>" . " menjadi " .  "<b>" . $afterJangkaWaktu . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["nilai_kb"] != $afterNilaiKB) {
                            $diffNilaiKB = "Mengubah nilai KB dari " . "<b>" . $row["nilai_kb"]  . "</b>" . " menjadi " . "<b>" . $afterNilaiKB . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["no_KFS_SPK"] != $afterNoKFS) {
                            $diffNoKFS = "Mengubah No KFS/SPK dari " . "<b>" . $row["no_KFS_SPK"]  . "</b>" . " menjadi " . "<b>" . $afterNoKFS . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["no_KL_WO_SuratPesanan"] != $afterNoKL) {
                            $diffNoKL = "Mengubah No KL/WO/Surat Pesanan " .  "<b>" . $row["no_KL_WO_SuratPesanan"]  . "</b>" . " menjadi " . "<b>" . $afterNoKL . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["no_order"] != $afterNoOrder) {
                            $diffNoKL = "Mengubah No Order " .  "<b>" . $row["no_order"]  . "</b>" . " menjadi " . "<b>" . $afterNoOrder . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["sid"] != $afterSid) {
                            $diffSid = "Mengubah sid  " .  "<b>" . $row["sid"]  . "</b>" . " menjadi " . "<b>" . $afterSid . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["pic"] != $afterPIC) {
                            $diffPIC = "Mengubah PIC " . "<b>" . $row["pic"]  . "</b>" . " menjadi " .  "<b>" . $afterPIC . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["status"] != $afterStatus) {
                            $diffStatus = "Mengubah status " . "<b>" . $row["status"] . "</b>" . " menjadi " . "<b>" . $afterStatus . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["statusSM"] != $afterStatusSM) {
                            $diffStatusSM = "Mengubah status SM " .  "<b>" . $row["statusSM"]  . "</b>" . " menjadi " . "<b>" . $afterStatusSM . "</b>" . "<br>" . "<br>";
                        }

                        if ($row["keterangan"] != $afterKeterangan) {
                            $diffKeterangan = "Mengubah keterangan " .  "<b>" . $row["keterangan"] . "</b><br>" . " menjadi " . "<b>" . $afterKeterangan . "</b>" . "<br>";
                        }
                        ?>
                        <td class="kegiatan">
                            <?=
                            $diffProses .
                                $diffSegmen .
                                $diffTanggalSubmit .
                                $diffTanggalUpdate .
                                $diffFolder .
                                $diffJenisSPK .
                                $diffWitel .
                                $diffNamaPelanggan .
                                $diffLayanan .
                                $diffNamaVendor .
                                $diffJangkaWaktu .
                                $diffNilaiKB .
                                $diffNoKFS .
                                $diffNoKL .
                                $diffNoOrder .
                                $diffSid .
                                $diffPIC .
                                $diffStatus .
                                $diffStatusSM .
                                $diffKeterangan
                            ?>
                        </td>
                        <td class="aksi">
                            <div>
                                <a href="#<?= $id; ?>"><button class="detailDokumen">Detail</button></a>
                                <div id="<?= $id; ?>" class="overlay">
                                    <a class="cancel" href="#"></a>
                                    <div class="container">
                                        <div class="header">
                                            <h2>Hasil perubahan dokumen</h2>
                                        </div>
                                        <div class="modal">
                                            <div class="content">
                                                <label for="">PROSES</label>
                                                <span><?= $data["proses"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">SEGMEN</label>
                                                <span><?= $data["segmen"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">FOLDER</label>
                                                <span><?= $data["folder"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">JENIS SPK</label>
                                                <span><?= $data["jenis_spk"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">WITEL</label>
                                                <span><?= $data["witel"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NAMA PELANGGAN</label>
                                                <span><?= $data["nama_pelanggan"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">LAYANAN</label>
                                                <span><?= $data["layanan"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NAMA VENDOR</label>
                                                <span><?= $data["nama_vendor"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">JANGKA WAKTU</label>
                                                <span><?= $data["jangka_waktu"] ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NILAI KB</label>
                                                <span><?= rupiah($data["nilai_kb"]); ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NO KFS/SPK</label>
                                                <span><?= $data["no_KFS_SPK"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NO KL/WO/SURAT PESANAN</label>
                                                <span><?= $data["no_KL_WO_SuratPesanan"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">NO ORDER</label>
                                                <span><?= $data["no_order"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">SID</label>
                                                <span><?= $data["sid"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">PIC</label>
                                                <span><?= $data["pic"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">STATUS</label>
                                                <span><?= $data["status"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="">STATUS SM</label>
                                                <span><?= $data["statusSM"]; ?></span>
                                            </div>
                                            <div class="content">
                                                <label for="" class="keterangan">KETERANGAN</label>
                                                <textarea name="keterangan" id="keterangan" readonly><?= $data["keterangan"]; ?></textarea>
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