<?php
error_reporting(E_ERROR);
session_start();
require '../config/functions.php';

if (!isset($_SESSION["login"])) {
    header('location: ../login.php');
    exit;
}

$nama = $_SESSION['nama'];
$mitra = $nama;

$namaAkun = query("SELECT * FROM account WHERE nama = '$nama'")[0];
$level = $namaAkun["level"];

$keyword = $_GET["keyword"];
$total = query("SELECT nama_vendor, COUNT(*) AS totalOrder, SUM(nilai_kb) AS totalNilaiKB FROM report_obl 
                WHERE nama_vendor LIKE '%$keyword%' AND
                UPPER(proses) = 'MITRA OBL'
                GROUP BY nama_vendor
                ORDER BY totalNilaiKB DESC");
?>

<table>
    <tr>
        <th>Rank</th>
        <th>Mitra</th>
        <th>Total Order</th>
        <th>Total Nilai kb</th>
        <th class="aksi" id="aksiTh">Aksi</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach ($total as $row) { ?>
        <tr>
            <?php
            $namaVendor = $row["nama_vendor"];
            $totalOrder = intval($row["totalOrder"]);
            $totalNilaiKB = intval($row["totalNilaiKB"]);
            $cek_data = mysqli_query($conn, "SELECT nama_vendor FROM rankmitraobl WHERE nama_vendor = '$namaVendor'");

            if (mysqli_fetch_assoc($cek_data)) {
                $query = "UPDATE rankmitraobl SET nama_vendor = '$namaVendor', total_order = $totalOrder, total_nilaiKB = $totalNilaiKB WHERE nama_vendor = '$namaVendor' ";
            } else {
                $query = "INSERT INTO rankmitraobl (nama_vendor, total_order, total_nilaiKB) VALUES ('$namaVendor', $totalOrder, $totalNilaiKB)";
            }
            mysqli_query($conn, $query);
            ?>
            <td class="no_rank"><?= $i; ?></td>
            <td><?= $namaVendor; ?></td>
            <td><?= $totalOrder; ?></td>
            <td><?= rupiah($totalNilaiKB); ?></td>
            <td class="aksi" id="aksiTd">
                <div>
                    <a href="detailRankMitraOBL.php?mitra=<?= $row["nama_vendor"]; ?>"><button class="view"><img src="img/view.png" alt=""></button></a>
                </div>
            </td>
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
    <?php } ?>
    <tr class="sum">
        <?php
        $query = query("SELECT SUM(total_order) AS totalOrder, SUM(total_nilaiKB) AS totalNilaiKB FROM rankmitraobl")[0];
        ?>
        <td colspan="2"><b>TOTAL SELURUH MITRA</b></td>
        <td><?= $query["totalOrder"]; ?></td>
        <td><?= rupiah($query["totalNilaiKB"]); ?></td>
        <td id="sumTd"></td>
        <?php
        if ($level == 'witel' or $level == 'mitra') {
            echo "<script>
                    document.getElementById('sumTd').remove();
                    var tdTable = document.getElementsByTagName('td');
                    for (var i = 0; i < tdTable.length; i++) {
                        tdTable[i].style.padding = '4px 6px';
                    }
                </script>";
        }
        ?>
    </tr>
</table>