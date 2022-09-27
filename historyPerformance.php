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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleHistory.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>History Performance Admin</title>
</head>

<body>
    <div class="container">
        <h1>History Performance Admin</h1>

        <div class="header">
            <!-- <div class="_1">
                <img src="img/search.png" alt="" id="search">
                <input type="text" name="keyword" id="keyword" placeholder="Masukkan keyword..." autocomplete="off">
            </div> -->
            <div class="_2">
                <a href="index.php"><button style="background-color: #20C997;"><img src="img/home.png" alt="">Dashboard</button></a>
                <div class="chooseBy_1">
                    <label for="segmen">History By</label>
                    <form action="" method="get">
                        <select name="chooseBy" id="chooseBy" onchange="this.form.submit();">
                            <option value="" disabled selected>Pilih</option>
                            <option value="tambah" <?php if ($_GET["chooseBy"] == "tambah") echo 'selected="selected"'; ?>>Tambah Data</option>
                            <option value="update" <?php if ($_GET["chooseBy"] == "update") echo 'selected="selected"'; ?>>Update Data</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <div class="note" id="note">
            <label for="">*Untuk melihat data history performance admin, silahkan pilih terlebih dahulu dropdown menu 'History By'</label>
        </div>

        <?php if (isset($_GET["chooseBy"])) { ?>
            <?php
            $chooseVal = $_GET["chooseBy"];
            if ($chooseVal == 'update') {
                $query = query("SELECT *, COUNT(*) AS totalNama FROM historyafter GROUP BY updated_by");
            } else if ($chooseVal == 'tambah') {
                $query = query("SELECT *, COUNT(*) AS totalNama FROM historytambah GROUP BY updated_by");
            }
            ?>

            <script>
                document.getElementById('note').style.display = 'none';
            </script>

            <div class="content" id="content-table">
                <table>
                    <tr>
                        <th>NO</th>
                        <th>NAMA</th>
                        <th>STATUS</th>
                        <th>JUMLAH KEGIATAN</th>
                        <th>DETAIL</th>
                    </tr>
                    <?php $i = 1; ?>
                    <?php foreach ($query as $row) : ?>
                        <tr>
                            <td class="no"><?= $i; ?></td>
                            <td><?= $row["updated_by"]; ?></td>
                            <?php
                            $updatedBy = $row["updated_by"];
                            $data = query("SELECT * FROM account WHERE nama = '$updatedBy'")[0];
                            $status = $data["level"];
                            $updatedBy = rawurlencode($updatedBy);
                            ?>
                            <td><?= $status; ?></td>
                            <td><?= $row["totalNama"]; ?></td>
                            <?php if ($chooseVal == 'update') { ?>
                                <td class="aksi" id="aksiTd">
                                    <div>
                                        <a href="detailHistoryPerformanceUpdate.php?nama=<?= $updatedBy; ?>"><button class="view"><img src="img/view.png" alt=""></button></a>
                                    </div>
                                </td>
                            <?php } else if ($chooseVal == 'tambah') { ?>
                                <td class="aksi" id="aksiTd">
                                    <div>
                                        <a href="detailHistoryPerformanceTambah.php?nama=<?= $updatedBy; ?>"><button class="view"><img src="img/view.png" alt=""></button></a>
                                    </div>
                                </td> <?php  } ?>
                            <?php $i++; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php }; ?>
    </div>
</body>

</html>