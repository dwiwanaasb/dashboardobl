<?php
error_reporting(E_ERROR);
session_start();
require '../config/functions.php';

if (!isset($_SESSION["login"])) {
    header('location: ../login.php');
    exit;
}

$nama = $_SESSION['nama'];

$namaAkun = query("SELECT * FROM account WHERE nama = '$nama'")[0];
$level = $namaAkun["level"];

if (isset($_GET["keyword"]) or isset($_GET["witel"]) or isset($_GET["tahun"]) or isset($_GET["mitra"]) or isset($_GET["pelanggan"]) or isset($_GET["segmen"]) or isset($_GET["status"])) {
    $keyword = $_GET["keyword"];
    $witel = $_GET["witel"];
    $tahun = $_GET["tahun"];
    $mitra = $_GET["mitra"];
    $pelanggan = $_GET["pelanggan"];
    $segmen = $_GET["segmen"];
    $status = $_GET["status"];
} else {
    $keyword = '';
    $witel = '';
    $tahun = '';
    $mitra = '';
    $pelanggan = '';
    $segmen = '';
    $status = '';
}

if ($level == 'mitra') {
    if ($witel == '' and $tahun == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $query = query("SELECT * FROM report_obl WHERE UPPER(nama_vendor) LIKE '%$nama%' AND
                        UPPER(proses) = 'LEGAL' AND
                        (UPPER(nama_pelanggan) LIKE '%$keyword%' OR 
                        UPPER(nama_vendor) LIKE '%$keyword%' OR
                        UPPER(folder) LIKE '%$keyword%' OR
                        UPPER(no_KFS_SPK) LIKE '%$keyword%' OR
                        UPPER(witel) LIKE '%$keyword%' OR
                        UPPER(segmen) LIKE '%$keyword%' OR 
                        UPPER(no_KL_WO_SuratPesanan) LIKE '%$keyword%') 
                        ORDER BY folder ASC");
    } else {
        $query = query("SELECT * FROM report_obl WHERE UPPER(nama_vendor) LIKE '%$nama%' AND
                        UPPER(proses) = 'LEGAL' AND
                        (UPPER(witel) LIKE '%$witel%' AND
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%') AND
                        (UPPER(nama_pelanggan) LIKE '%$keyword%' OR 
                        UPPER(nama_vendor) LIKE '%$keyword%' OR
                        UPPER(folder) LIKE '%$keyword%' OR
                        UPPER(no_KFS_SPK) LIKE '%$keyword%' OR
                        UPPER(witel) LIKE '%$keyword%' OR
                        UPPER(segmen) LIKE '%$keyword%' OR 
                        UPPER(no_KL_WO_SuratPesanan) LIKE '%$keyword%') 
                        ORDER BY folder ASC");
    }
} else if ($level == 'witel') {
    if ($tahun == '' and $mitra == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $query = query("SELECT * FROM report_obl WHERE UPPER(witel) LIKE '%$witel%' AND
                        UPPER(proses) = 'LEGAL' AND
                        (UPPER(nama_pelanggan) LIKE '%$keyword%' OR 
                        UPPER(nama_vendor) LIKE '%$keyword%' OR
                        UPPER(folder) LIKE '%$keyword%' OR
                        UPPER(no_KFS_SPK) LIKE '%$keyword%' OR
                        UPPER(witel) LIKE '%$keyword%' OR
                        UPPER(segmen) LIKE '%$keyword%' OR 
                        UPPER(no_KL_WO_SuratPesanan) LIKE '%$keyword%') 
                        ORDER BY folder ASC");
    } else {
        $query = query("SELECT * FROM report_obl WHERE UPPER(witel) LIKE '%$witel%' AND
                        UPPER(proses) = 'LEGAL' AND
                        (UPPER(segmen) LIKE '%$segmen%' AND
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%') AND
                        (UPPER(nama_pelanggan) LIKE '%$keyword%' OR 
                        UPPER(nama_vendor) LIKE '%$keyword%' OR
                        UPPER(folder) LIKE '%$keyword%' OR
                        UPPER(no_KFS_SPK) LIKE '%$keyword%' OR
                        UPPER(witel) LIKE '%$keyword%' OR
                        UPPER(segmen) LIKE '%$keyword%' OR 
                        UPPER(no_KL_WO_SuratPesanan) LIKE '%$keyword%') 
                        ORDER BY folder ASC");
    }
} else {
    if ($witel == '' and $tahun == '' and $mitra == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $query = query("SELECT * FROM report_obl WHERE UPPER(proses) = 'LEGAL' AND
                        (UPPER(nama_pelanggan) LIKE '%$keyword%' OR 
                        UPPER(nama_vendor) LIKE '%$keyword%' OR
                        UPPER(folder) LIKE '%$keyword%' OR
                        UPPER(no_KFS_SPK) LIKE '%$keyword%' OR
                        UPPER(witel) LIKE '%$keyword%' OR
                        UPPER(segmen) LIKE '%$keyword%' OR 
                        UPPER(no_KL_WO_SuratPesanan) LIKE '%$keyword%') 
                        ORDER BY folder ASC");
    } else {
        $query = query("SELECT * FROM report_obl WHERE UPPER(proses) = 'LEGAL' AND
                        (UPPER(witel) LIKE '%$witel%' AND
                        SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                        UPPER(segmen) LIKE '%$segmen%' AND 
                        UPPER(nama_vendor) LIKE '%$mitra%' AND 
                        UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                        UPPER(status) LIKE '%$status%') AND
                        (UPPER(nama_pelanggan) LIKE '%$keyword%' OR 
                        UPPER(segmen) LIKE '%$keyword%' OR  
                        UPPER(nama_vendor) LIKE '%$keyword%' OR
                        UPPER(folder) LIKE '%$keyword%' OR
                        UPPER(no_KFS_SPK) LIKE '%$keyword%' OR
                        UPPER(witel) LIKE '%$keyword%' OR
                        UPPER(segmen) LIKE '%$keyword%' OR 
                        UPPER(no_KL_WO_SuratPesanan) LIKE '%$keyword%') 
                        ORDER BY folder ASC");
    }
}
?>

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