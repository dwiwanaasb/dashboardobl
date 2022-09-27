<?php
clearstatcache();
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
$username = $namaAkun["username"];

if (isset($_GET["witel"]) or isset($_GET["tahun"]) or isset($_GET["mitra"]) or isset($_GET["pelanggan"]) or isset($_GET["segmen"]) or isset($_GET["status"])) {
    $witel = $_GET["witel"];
    $tahun = $_GET["tahun"];
    $mitra = $_GET["mitra"];
    $pelanggan = $_GET["pelanggan"];
    $segmen = $_GET["segmen"];
    $status = $_GET["status"];

    $witel = strtoupper($witel);
    $tahun = strtoupper($tahun);
    $mitra = strtoupper($mitra);
    $pelanggan = strtoupper($pelanggan);
    $segmen = strtoupper($segmen);
    $status = strtoupper($status);
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
        $mitra = $nama;
        require 'showData/mitraDefaultData.php';
        $query = query("SELECT * FROM report_obl WHERE UPPER(nama_vendor) LIKE '%$mitra%' 
                        ORDER BY folder ASC");
        $result = query("SELECT COUNT(DISTINCT id) AS totalData FROM report_obl WHERE 
                        UPPER(nama_vendor) LIKE '%$mitra%' 
                        ORDER BY folder ASC")[0];
    } else {
        $mitra = $nama;
        require 'showData/mitraSpesificData.php';
        $query = query("SELECT * FROM report_obl WHERE UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        (witel LIKE '%$witel%' AND 
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(status) LIKE '%$status%') 
                        ORDER BY folder ASC");
        $result = query("SELECT COUNT(DISTINCT id) AS totalData FROM report_obl WHERE 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        (witel LIKE '%$witel%' AND
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(status) LIKE '%$status%') 
                        ORDER BY folder ASC")[0];
    }
} else if ($level == 'witel') {
    if ($tahun == '' and $mitra == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $witel = $nama;
        $nama = rawurldecode($witel);
        $string = $nama;
        $last_word_start = strrpos($string, ' ') + 1;
        $nama = substr($string, $last_word_start);
        $witel = strtoupper($nama);
        require 'showData/witelDefaultData.php';
        $query = query("SELECT * FROM report_obl WHERE UPPER(witel) LIKE '%$witel%' 
                        ORDER BY folder ASC");
        $result = query("SELECT COUNT(DISTINCT id) AS totalData FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' 
                        ORDER BY folder ASC")[0];
    } else {
        $witel = $nama;
        $nama = rawurldecode($witel);
        $string = $nama;
        $last_word_start = strrpos($string, ' ') + 1;
        $nama = substr($string, $last_word_start);
        $witel = strtoupper($nama);
        require 'showData/witelSpesificData.php';
        $query = query("SELECT * FROM report_obl WHERE UPPER(witel) LIKE '%$witel%' AND 
                        (UPPER(nama_vendor) LIKE '%$mitra%' AND
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(status) LIKE '%$status%') 
                        ORDER BY folder ASC");
        $result = query("SELECT COUNT(DISTINCT id) AS totalData FROM report_obl WHERE 
                        UPPER(witel) LIKE '%$witel%' AND 
                        (UPPER(nama_vendor) LIKE '%$mitra%' AND
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(status) LIKE '%$status%') 
                        ORDER BY folder ASC")[0];
    }
} else {
    if ($witel == '' and $tahun == '' and $mitra == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        require 'showData/defaultData.php';
        $query = query("SELECT * FROM report_obl ORDER BY folder ASC");
        $result = query("SELECT COUNT(DISTINCT id) AS totalData FROM report_obl ORDER BY folder ASC")[0];
    } else {
        require 'showData/spesificData.php';
        $query = query("SELECT * FROM report_obl WHERE UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(status) LIKE '%$status%' 
                        ORDER BY folder ASC");
        $result = query("SELECT COUNT(DISTINCT id) AS totalData FROM report_obl WHERE UPPER(witel) LIKE '%$witel%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(status) LIKE '%$status%' 
                        ORDER BY folder ASC")[0];
    }
}
$total = $result["totalData"];
$historyUpdate = query("SELECT COUNT(*) AS countHistoryUpdate FROM historyafter")[0];
$totalHistoryUpdate = $historyUpdate["countHistoryUpdate"];
$historyTambah = query("SELECT COUNT(*) AS countHistoryTambah FROM historytambah")[0];
$totalHistoryTambah = $historyTambah["countHistoryTambah"];
$history = $totalHistoryUpdate + $totalHistoryTambah;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleDashboard.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/ajax/ajaxSearch.js"></script>
    <title>Dashboard</title>
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
        <div class="title">
            <div class="profile">
                <div class="picdtl">
                    <div class="say">
                        <h4>Hi, <?= $_SESSION["nama"]; ?>!</h4>
                    </div>
                    <div class="name">
                        <h2>Selamat Datang</h2>
                    </div>
                </div>
            </div>
            <div class="profile_2">
                <a href="updateProfile.php"><button class="updateProfile" id="updateProfile">Update Profile</button></a>
                <a href="logout.php"><button class="logout" id="logout"><img src="img/logout.png" alt="">Logout</button></a>
            </div>
        </div>

        <div class="header">
            <div class="dropdown">
                <?php if ($level == 'mitra') { ?>
                    <form action="" method="GET">
                        <div class="content">
                            <label for="witel">Witel</label>
                            <select name="witel" id="witel">
                                <option value="ALL" disabled selected>ALL</option>
                                <option value="BALIKPAPAN">BALIKPAPAN</option>
                                <option value="SAMARINDA">SAMARINDA</option>
                                <option value="KALBAR">KALBAR</option>
                                <option value="KALSEL">KALSEL</option>
                                <option value="KALTARA">KALTARA</option>
                                <option value="KALTENG">KALTENG</option>
                            </select>
                        </div>
                        <div class="content">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" id="tahun">
                                <option value="ALL" disabled selected>ALL</option>
                                <?php $tahun = query("SELECT DISTINCT SUBSTRING_INDEX(tanggal_update, ' ', -1) AS tanggal FROM report_obl WHERE tanggal_update IS NOT NULL AND tanggal_update != '-'"); ?>
                                <?php foreach ($tahun as $row) : ?>
                                    <?php $valTahun = strtoupper($row["tanggal"]); ?>
                                    <?php $tahun = substr($valTahun, 2); ?>
                                    <option value="<?= $tahun; ?>"><?= $valTahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content" id="cMitra" style="cursor: not-allowed;">
                            <label for="mitra">Mitra</label>
                            <select name="mitra" id="mitra" style="pointer-events: none;">
                                <option value="<?= $nama; ?>"><?= $nama ?></option>
                            </select>
                        </div>
                        <div class="content" id="cPelanggan">
                            <label for="pelanggan">Pelanggan</label>
                            <select name="pelanggan" id="pelanggan">
                                <option value="ALL" disabled selected>ALL</option>
                                <?php $pelanggan = query("SELECT DISTINCT nama_pelanggan FROM report_obl WHERE nama_pelanggan IS NOT NULL AND nama_pelanggan != '-' ORDER BY nama_pelanggan ASC"); ?>
                                <?php foreach ($pelanggan as $row) : ?>
                                    <?php $pelanggan = strtoupper($row["nama_pelanggan"]); ?>
                                    <option value="<?= $pelanggan; ?>"><?= $pelanggan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content">
                            <label for="segmen">Segmen</label>
                            <select name="segmen" id="segmen">
                                <option value="ALL" disabled selected>ALL</option>
                                <option value="DES">DES</option>
                                <option value="DGS">DGS</option>
                                <option value="DBS">DBS</option>
                            </select>
                        </div>
                        <div class="content">
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="ALL" disabled selected>ALL</option>
                                <option value="Amandemen">AMANDEMEN</option>
                                <option value="Pasang Baru">PASANG BARU</option>
                                <option value="Perpanjangan">PERPANJANGAN</option>
                            </select>
                        </div>
                        <div class="content" id="btn">
                            <button type="submit" name="filter" id="filter"><img src="img/filter.svg" alt=""> Filter</button>
                        </div>
                    </form>
                <?php } else if ($level == 'witel') {; ?>
                    <form action="" method="GET">
                        <div class="content" id="cMitra" style="cursor: not-allowed;">
                            <label for="witel">Witel</label>
                            <select name="witel" id="witel" style="pointer-events: none;">
                                <option value="<?= $witel; ?>"><?= $witel ?></option>
                            </select>
                        </div>
                        <div class="content">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" id="tahun">
                                <option value="ALL" disabled selected>ALL</option>
                                <?php $tahun = query("SELECT DISTINCT SUBSTRING_INDEX(tanggal_update, ' ', -1) AS tanggal FROM report_obl WHERE tanggal_update IS NOT NULL AND tanggal_update != '-'"); ?>
                                <?php foreach ($tahun as $row) : ?>
                                    <?php $valTahun = strtoupper($row["tanggal"]); ?>
                                    <?php $tahun = substr($valTahun, 2); ?>
                                    <option value="<?= $tahun; ?>"><?= $valTahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content" id="cMitra">
                            <label for="mitra">Mitra</label>
                            <select name="mitra" id="mitra">
                                <option value="ALL" disabled selected>ALL</option>
                                <?php $vendor = query("SELECT DISTINCT nama_vendor FROM report_obl WHERE nama_vendor IS NOT NULL AND nama_vendor != '-' ORDER BY nama_vendor ASC"); ?>
                                <?php foreach ($vendor as $row) : ?>
                                    <?php $mitra = strtoupper($row["nama_vendor"]); ?>
                                    <option value="<?= $mitra; ?>"><?= $mitra ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content" id="cPelanggan">
                            <label for="pelanggan">Pelanggan</label>
                            <select name="pelanggan" id="pelanggan">
                                <option value="ALL" disabled selected>ALL</option>
                                <?php $pelanggan = query("SELECT DISTINCT nama_pelanggan FROM report_obl WHERE nama_pelanggan IS NOT NULL AND nama_pelanggan != '-' ORDER BY nama_pelanggan ASC"); ?>
                                <?php foreach ($pelanggan as $row) : ?>
                                    <?php $pelanggan = strtoupper($row["nama_pelanggan"]); ?>
                                    <option value="<?= $pelanggan; ?>"><?= $pelanggan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content">
                            <label for="segmen">Segmen</label>
                            <select name="segmen" id="segmen">
                                <option value="ALL" disabled selected>ALL</option>
                                <option value="DES">DES</option>
                                <option value="DGS">DGS</option>
                                <option value="DBS">DBS</option>
                            </select>
                        </div>
                        <div class="content">
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="ALL" disabled selected>ALL</option>
                                <option value="Amandemen">Amandemen</option>
                                <option value="Pasang Baru">Pasang Baru</option>
                                <option value="Perpanjangan">Perpanjangan</option>
                            </select>
                        </div>
                        <div class="content" id="btn">
                            <button type="submit" name="filter" id="filter"><img src="img/filter.svg" alt=""> Filter</button>
                        </div>
                    </form>
                <?php } else { ?>
                    <form action="" method="GET">
                        <div class="content">
                            <label for="witel">Witel</label>
                            <select name="witel" id="witel">
                                <option value="ALL" disabled selected>ALL</option>
                                <option value="BALIKPAPAN">BALIKPAPAN</option>
                                <option value="SAMARINDA">SAMARINDA</option>
                                <option value="KALBAR">KALBAR</option>
                                <option value="KALSEL">KALSEL</option>
                                <option value="KALTARA">KALTARA</option>
                                <option value="KALTENG">KALTENG</option>
                            </select>
                        </div>
                        <div class="content">
                            <label for="tahun">Tahun</label>
                            <select name="tahun" id="tahun">
                                <option value="ALL" disabled selected>ALL</option>
                                <?php $tahun = query("SELECT DISTINCT SUBSTRING_INDEX(tanggal_update, ' ', -1) AS tanggal FROM report_obl WHERE tanggal_update IS NOT NULL AND tanggal_update != '-'"); ?>
                                <?php foreach ($tahun as $row) : ?>
                                    <?php $valTahun = strtoupper($row["tanggal"]); ?>
                                    <?php $tahun = substr($valTahun, 2); ?>
                                    <option value="<?= $tahun; ?>"><?= $valTahun ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content" id="cMitra">
                            <label for="mitra">Mitra</label>
                            <select name="mitra" id="mitra">
                                <option value="ALL" disabled selected>ALL</option>
                                <?php $vendor = query("SELECT DISTINCT nama_vendor FROM report_obl WHERE nama_vendor IS NOT NULL AND nama_vendor != '-' ORDER BY nama_vendor ASC"); ?>
                                <?php foreach ($vendor as $row) : ?>
                                    <?php $mitra = strtoupper($row["nama_vendor"]); ?>
                                    <option value="<?= $mitra; ?>"><?= $mitra ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content" id="cPelanggan">
                            <label for="pelanggan">Pelanggan</label>
                            <select name="pelanggan" id="pelanggan">
                                <option value="ALL" disabled selected>ALL</option>
                                <?php $pelanggan = query("SELECT DISTINCT nama_pelanggan FROM report_obl WHERE nama_pelanggan IS NOT NULL AND nama_pelanggan != '-' ORDER BY nama_pelanggan ASC"); ?>
                                <?php foreach ($pelanggan as $row) : ?>
                                    <?php $pelanggan = strtoupper($row["nama_pelanggan"]); ?>
                                    <option value="<?= $pelanggan; ?>"><?= $pelanggan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="content">
                            <label for="segmen">Segmen</label>
                            <select name="segmen" id="segmen">
                                <option value="ALL" disabled selected>ALL</option>
                                <option value="DES">DES</option>
                                <option value="DGS">DGS</option>
                                <option value="DBS">DBS</option>
                            </select>
                        </div>
                        <div class="content">
                            <label for="status">Status</label>
                            <select name="status" id="status">
                                <option value="ALL" disabled selected>ALL</option>
                                <option value="Amandemen">AMANDEMEN</option>
                                <option value="Pasang Baru">PASANG BARU</option>
                                <option value="Perpanjangan">PERPANJANGAN</option>
                            </select>
                        </div>
                        <div class="content" id="btn">
                            <button type="submit" name="filter" id="filter"><img src="img/filter.svg" alt=""> Filter</button>
                        </div>
                    </form>
                <?php }; ?>
            </div>
        </div>

        <div class="banner">
            <?php if ($level == 'mitra') { ?>
                <div class="content" id="notif">
                    <h3>Detail Filter</h3><br>
                    <div class="content_2">
                        <label for="">Witel<span>: <?= $witel = isset($_GET['witel']) ? $_GET['witel'] : ''; ?></span></label>
                        <label for="">Tahun<span>: <?= $tahun = isset($_GET['tahun']) ? '20' . $_GET['tahun'] : ''; ?></span></label>
                        <label for="">Pelanggan<span>: <?= $pelanggan = isset($_GET['pelanggan']) ? $_GET['pelanggan'] : ''; ?></span></label>
                        <label for="">Segmen<span>: <?= $segmen = isset($_GET['segmen']) ? $_GET['segmen'] : ''; ?></span></label>
                        <label for="">Status<span>: <?= $status = isset($_GET['status']) ? $_GET['status'] : ''; ?></span></label>
                    </div>
                </div>
            <?php } else if ($level == 'witel') { ?>
                <div class="content" id="notif">
                    <h3>Detail Filter</h3><br>
                    <div class="content_2">
                        <label for="">Tahun<span>: <?= $tahun = isset($_GET['tahun']) ? '20' . $_GET['tahun'] : ''; ?></span></label>
                        <label for="">Mitra<span>: <?= $mitra = isset($_GET['mitra']) ? $_GET['mitra'] : ''; ?></span></label>
                        <label for="">Pelanggan<span>: <?= $pelanggan = isset($_GET['pelanggan']) ? $_GET['pelanggan'] : ''; ?></span></label>
                        <label for="">Segmen<span>: <?= $segmen = isset($_GET['segmen']) ? $_GET['segmen'] : ''; ?></span></label>
                        <label for="">Status<span>: <?= $status = isset($_GET['status']) ? $_GET['status'] : ''; ?></span></label>
                    </div>
                </div>
            <?php } else { ?>
                <div class="content" id="notif">
                    <h3>Detail Filter</h3><br>
                    <div class="content_2">
                        <label for="">Witel<span>: <?= $witel = isset($_GET['witel']) ? $_GET['witel'] : ''; ?></span></label>
                        <label for="">Tahun<span>: <?= $tahun = isset($_GET['tahun']) ? '20' . $_GET['tahun'] : ''; ?></span></label>
                        <label for="">Mitra<span>: <?= $mitra = isset($_GET['mitra']) ? $_GET['mitra'] : ''; ?></span></label>
                        <label for="">Pelanggan<span>: <?= $pelanggan = isset($_GET['pelanggan']) ? $_GET['pelanggan'] : ''; ?></span></label>
                        <label for="">Segmen<span>: <?= $segmen = isset($_GET['segmen']) ? $_GET['segmen'] : ''; ?></span></label>
                        <label for="">Status<span>: <?= $status = isset($_GET['status']) ? $_GET['status'] : ''; ?></span></label>
                    </div>
                </div>
            <?php }; ?>
            <?php $tahun = substr($tahun, 2);
            ?>
            <div class="searching">
                <div class="searching_1">
                    <a href="index.php"><button class="refresh"><img src="img/refresh.svg" alt="">Reset</button></a>
                    <a href="tambahData.php"><button class="add" id="add"><img src="img/add.png" alt="">Tambah Data</button></a>
                    <?php
                    if ($level == 'witel' or $level == 'mitra') {
                        echo "<script>
                                document.getElementById('add').style.display = 'none';
                            </script>";
                    }
                    ?>
                    <a href="downloadData/download.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>" id="btnDownload"><button class="download" style="background-color: #FD7E14;"><img src="img/download.png" alt="">Download</button></a>
                </div>
                <div class="searching_2">
                    <img src="img/search.png" alt="" id="search">
                    <input type="text" name="keyword" id="keyword" placeholder="Masukkan keyword..." autocomplete="off">
                    <img src="img/cancel.png" alt="" id="cancel">
                </div>
            </div>
        </div>

        <div class="content-table" id="content-table">
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

        <?php $status = strtoupper($status); ?>
        <div class="detail" id="detail">
            <div class="content">
                <a href="dokumenWitel.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num">
                            <label for="">1</label>
                        </div>
                        <p>P0-P1</p>
                    </div>
                    <div class="_2">
                        <p class="text-1">Dokumen di Witel</p>
                        <p>Total : <span style="background-color: #dc3545;"><?= $totalWitel; ?></span></p>
                    </div>
                </a>
            </div>
            <div class="content">
                <a href="dokumenOBL.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num">
                            <label for="">2</label>
                        </div>
                        <p>P2-P8</p>
                    </div>
                    <div class="_2">
                        <p class="text-1">Dokumen di OBL</p>
                        <p>Total : <span style="background-color: #FD7E14;"><?= $totalOBL; ?></span></p>
                    </div>
                </a>
            </div>
            <div class="content">
                <a href="dokumenLegal.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num">
                            <label for="">3</label>
                        </div>
                        <p>KL KB</p>
                    </div>
                    <div class="_2">
                        <p class="text-1">Dokumen di Legal</p>
                        <p>Total : <span style="background-color: #6610F2;"><?= $totalLegal; ?></span></p>
                    </div>
                </a>
            </div>
            <div class="content">
                <a href="dokumenMitraOBL.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num">
                            <label for="">4</label>
                        </div>
                        <p>SPH SKM</p>
                    </div>
                    <div class="_2">
                        <p class="text-1">Dokumen di Mitra (OBL)</p>
                        <p>Total : <span style="background-color: #FFC107;"><?= $totalMitraOBL; ?></span></p>
                    </div>
                </a>
            </div>
            <div class="content">
                <a href="closeSM.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num">
                            <label for="">5</label>
                        </div>
                    </div>
                    <div class="_2">
                        <p class="text-1">Close SM</p>
                        <p>Total : <span style="background-color: #6610F2;"><?= $totalClose; ?></span></p>
                    </div>
                </a>
            </div>
            <div class="content">
                <a href=" dokumenMitraPJM.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num">
                            <label for="">6</label>
                        </div>
                        <p>BAST BAUT</p>
                    </div>
                    <div class="_2">
                        <p class="text-1">Dokumen di Mitra (PJM)</p>
                        <p>Total : <span style="background-color: #FFC107;"><?= $totalMitraPJM ?></span></p>
                    </div>
                </a>
            </div>
            <div class="content">
                <a href="pjm.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num">
                            <label for="">7</label>
                        </div>
                    </div>
                    <div class="_2">
                        <p class="text-1">PJM</p>
                        <p>Total : <span style="background-color: #20C997;"><?= $totalPJM; ?></span></p>
                    </div>
                </a>
            </div>
            <div class="content">
                <a href="done.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num">
                            <label for="">8</label>
                        </div>
                    </div>
                    <div class="_2">
                        <p class="text-1">Done</p>
                        <p>Total : <span style="background-color: #0DCAF0;"><?= $totalDone; ?></span></p>
                    </div>
                </a>
            </div>
            <div class="content total">
                <a href="cancel.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num" style="background-color: #dc3545;">
                            <label for="" style="color: white;"><?= $totalCancel; ?></label>
                        </div>
                    </div>
                    <div class="_2">
                        <p class="text-1">Cancel</p>
                    </div>
                </a>
            </div>
            <div class="content total">
                <a href="totalData.php?witel=<?= $witel; ?>&tahun=<?= $tahun; ?>&mitra=<?= $mitra; ?>&pelanggan=<?= $pelanggan; ?>&segmen=<?= $segmen; ?>&status=<?= $status; ?>">
                    <div class="_1">
                        <div class="num" style="background-color: #0d6efd;">
                            <label for="" style="color: white;"><?= $total; ?></label>
                        </div>
                    </div>
                    <div class="_2">
                        <p class="text-1">Total Data</p>
                    </div>
                </a>
            </div>

            <?php
            if ($username == 'admintaufik' or $username == 'adminyayan' or $username == 'adminandhy' or $username == 'tester') { ?>
                <div class="content total">
                    <a href="historyPerformance.php">
                        <div class="_1">
                            <div class="num" style="background-color: #FD7E14;">
                                <label for="" style="color: white;"><?= $history; ?></label>
                            </div>
                        </div>
                        <div class="_2">
                            <p class="text-1" style="text-align: center;">History Performance Admin</p>
                        </div>
                    </a>
                </div>
            <?php }; ?>
        </div>
    </div>

    <script>
        const search = document.getElementById('keyword');
        const cancel = document.getElementById('cancel');
        const table = document.getElementById('content-table');
        const detail = document.getElementById('detail');
        const filterBtn = document.getElementById('filter');
        let filter = document.getElementsByClassName('filter');

        if (search) {
            search.addEventListener('click', function(e) {
                table.style.display = 'block';
                detail.style.display = 'none';
                search.style.outlineWidth = '2px';
                search.style.outlineStyle = 'solid';
                search.style.outlineColor = '#0d6efd';
            });
        }

        if (cancel) {
            cancel.addEventListener('click', function(e) {
                table.style.display = 'none';
                detail.style.display = 'flex';
                search.style.outline = 'none';
            });
        }
    </script>
</body>

</html>