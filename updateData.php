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
$id = $_GET["id"];
$query = query("SELECT * FROM report_obl WHERE id = $id")[0];
$firstId = $query["id"];
$firstProses = $query["proses"];
$firstSegmen = $query["segmen"];
$firstTanggalSubmit = $query["tanggal_submit"];
$firstTanggalUpdate = $query["tanggal_update"];
$firstFolder = $query["folder"];
$firstJenisSPK = $query["jenis_spk"];
$firstWitel = $query["witel"];
$firstNamaPelanggan = $query["nama_pelanggan"];
$firstLayanan = $query["layanan"];
$firstNamaVendor = $query["nama_vendor"];
$firstJangkaWaktu = $query["jangka_waktu"];
$firstNilaiKB = $query["nilai_kb"];
$firstNoKFS = $query["no_KFS_SPK"];
$firstNoKL = $query["no_KL_WO_SuratPesanan"];
$firstNoOrder = $query["no_order"];
$firstSid = $query["sid"];
$firstPIC = $query["pic"];
$firstStatus = $query["status"];
$firstStatusSM = $query["statusSM"];
$firstKeterangan = $query["keterangan"];
$firstUpdatedBy = $query["updated_by"];

if ($query["tanggal_update"] == '-' or $query["tanggal_update"] == NULL) {
    $tanggal = "-";
} else {
    $tanggal = date('Y-m-d', strtotime($query["tanggal_update"]));
}

if ($query["tanggal_submit"] == '-' or $query["tanggal_submit"] == NULL) {
    $tanggalS = "-";
} else {
    $tanggalS = date('Y-m-d', strtotime($query["tanggal_submit"]));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styleForm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/script.js"></script>
    <title>Update Data</title>
</head>

<body>
    <div class="area">
        <div class="container">
            <h2>Update Data</h2>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?= $query["id"]; ?>">
                <div class="form-input">
                    <label for="">Proses</label>
                    <select name="proses" id="proses" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="WITEL" <?php if ($query["proses"] == "WITEL") echo 'selected="selected"'; ?> class="opt">WITEL</option>
                        <option value="OBL" <?php if ($query["proses"] == "OBL") echo 'selected="selected"'; ?> class="opt">OBL</option>
                        <option value="LEGAL" <?php if ($query["proses"] == "LEGAL") echo 'selected="selected"'; ?> class="opt">LEGAL</option>
                        <option value="MITRA OBL" <?php if ($query["proses"] == "MITRA OBL") echo 'selected="selected"'; ?> class="opt">MITRA OBL</option>
                        <option value="CLOSE SM" <?php if ($query["proses"] == "CLOSE SM") echo 'selected="selected"'; ?> class="opt">CLOSE SM</option>
                        <option value="PJM" <?php if ($query["proses"] == "PJM") echo 'selected="selected"'; ?> class="opt">PJM</option>
                        <option value="MITRA PJM" <?php if ($query["proses"] == "MITRA PJM") echo 'selected="selected"'; ?> class="opt">MITRA PJM</option>
                        <option value="DONE" <?php if ($query["proses"] == "DONE") echo 'selected="selected"'; ?> class="opt">DONE</option>
                        <option value="CANCEL" <?php if ($query["proses"] == "CANCEL") echo 'selected="selected"'; ?> class="opt">CANCEL</option>
                    </select>
                    <?php
                    if ($level == 'adminpjm') {
                        echo "<script>
                                var option = document.getElementsByClassName('opt');
                                for (var i = 0; i < option.length; i++) {
                                    if (option[i].value == 'MITRA OBL') {
                                        option[i].disabled = true;
                                    }
                                }
                            </script>
                        ";
                    } else if ($level == 'adminobl') {
                        echo "<script>
                                var option = document.getElementsByClassName('opt');
                                for (var i = 0; i < option.length; i++) {
                                    if (option[i].value == 'MITRA PJM') {
                                        option[i].disabled = true;
                                    }
                                }
                            </script>
                        ";
                    }
                    ?>
                </div>
                <div class="form-input">
                    <label for="segmen">Segmen</label>
                    <select name="segmen" id="segmen" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="DES" <?php if ($query["segmen"] == "DES") echo 'selected="selected"'; ?>>DES</option>
                        <option value="DGS" <?php if ($query["segmen"] == "DGS") echo 'selected="selected"'; ?>>DGS</option>
                        <option value="DBS" <?php if ($query["segmen"] == "DBS") echo 'selected="selected"'; ?>>DBS</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="tanggalSubmit">Tanggal Submit</label>
                    <input type="date" name="tanggalSubmit" id="tanggalSubmit" autocomplete="off" value="<?= $tanggalS; ?>" required>
                </div>
                <div class="form-input">
                    <label for="tanggalUpdate">Tanggal Update</label>
                    <input type="date" name="tanggalUpdate" id="tanggalUpdate" autocomplete="off" value="<?= $tanggal; ?>" required>
                </div>
                <div class="form-input">
                    <label for="folder">Folder</label>
                    <input type="text" name="folder" id="folder" placeholder="Masukkan nomor folder..." value="<?= $query["folder"]; ?>" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="jenisSPK">Jenis SPK</label>
                    <select name="jenisSPK" id="jenisSPK" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="KL" <?php if ($query["jenis_spk"] == "KL") echo 'selected="selected"'; ?>>KL</option>
                        <option value="SP" <?php if ($query["jenis_spk"] == "SP") echo 'selected="selected"'; ?>>SP</option>
                        <option value="WO" <?php if ($query["jenis_spk"] == "WO") echo 'selected="selected"'; ?>>WO</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="witel">Witel</label>
                    <select name="witel" id="witel" required>
                        <option value="-" selected disabled>Pilih</option>
                        <option value="BALIKPAPAN" <?php if ($query["witel"] == "BALIKPAPAN") echo 'selected="selected"'; ?>>BALIKPAPAN</option>
                        <option value="SAMARINDA" <?php if ($query["witel"] == "SAMARINDA") echo 'selected="selected"'; ?>>SAMARINDA</option>
                        <option value="KALBAR" <?php if ($query["witel"] == "KALBAR") echo 'selected="selected"'; ?>>KALBAR</option>
                        <option value="KALSEL" <?php if ($query["witel"] == "KALSEL") echo 'selected="selected"'; ?>>KALSEL</option>
                        <option value="KALTARA" <?php if ($query["witel"] == "KALTARA") echo 'selected="selected"'; ?>>KALTARA</option>
                        <option value="KALTENG" <?php if ($query["witel"] == "KALTENG") echo 'selected="selected"'; ?>>KALTENG</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="namaPelanggan">Nama Pelanggan</label>
                    <input type="text" name="namaPelanggan" id="namaPelanggan" placeholder="Masukkan nama pelanggan..." value="<?= $query["nama_pelanggan"]; ?>" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="layanan">Layanan</label>
                    <input type="text" name="layanan" id="layanan" placeholder="Masukkan jenis layanan..." value="<?= $query["layanan"]; ?>" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="namaVendor">Nama Vendor</label>
                    <input type="text" name="namaVendor" id="namaVendor" placeholder="Masukkan nama vendor..." value="<?= $query["nama_vendor"]; ?>" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="jangkaWaktu">Jangka Waktu (Bulan)</label>
                    <input type="number" name="jangkaWaktu" id="jangkaWaktu" placeholder="Masukkan jangka waktu..." value="<?= $query["jangka_waktu"]; ?>" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="nilaiKB">Nilai KB</label>
                    <input type="text" name="nilaiKB" id="nilaiKB" placeholder="Masukkan Nilai KB..." value="<?= rupiah($query["nilai_kb"]); ?>" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="no_KFS_SPK">No KFS/SPK</label>
                    <input type="text" name="no_KFS_SPK" id="no_KFS_SPK" placeholder="Masukkan No KFS/SPK..." value="<?= $query["no_KFS_SPK"]; ?>" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="no_KL_WO_SuratPesanan">No KL/WO/Surat Pesanan</label>
                    <input type="text" name="no_KL_WO_SuratPesanan" id="no_KL_WO_SuratPesanan" placeholder="Masukkan No KL/WO/Surat Pesanan..." value="<?= $query["no_KL_WO_SuratPesanan"]; ?>" autocomplete="off" required>
                </div>
                <?php if ($level == 'inputerwitel' and ($firstProses == 'WITEL' or $firstProses == 'OBL' or $firstProses == 'LEGAL' or $firstProses == 'MITRA OBL')) { ?>
                    <div class="form-input">
                        <label for="no_order">No Order</label>
                        <textarea name="no_order" id="no_order" placeholder="Masukkan No Order..." autocomplete="off" required><?= $query["no_order"]; ?></textarea>
                    </div>
                    <div class="form-input">
                        <label for="sid">sid</label>
                        <input type="text" name="sid" id="sid" value="<?= $query["sid"]; ?>" autocomplete="off" style="cursor: not-allowed;" disabled>
                    </div>
                <?php } else {; ?>
                    <div class="form-input">
                        <label for="no_order">No Order</label>
                        <textarea name="no_order" id="no_order" placeholder="Masukkan No Order..." autocomplete="off" required><?= $query["no_order"]; ?></textarea>
                    </div>
                    <div class="form-input">
                        <label for="sid">sid</label>
                        <input type="text" name="sid" id="sid" placeholder="Masukkan sid..." value="<?= $query["sid"]; ?>" autocomplete="off" required>
                    </div>
                <?php }; ?>
                <div class="form-input">
                    <label for="pic">PIC</label>
                    <input type="text" name="pic" id="pic" placeholder="Masukkan pic..." value="<?= $query["pic"]; ?>" autocomplete="off" required>
                </div>
                <?php
                $statusVal = $query["status"];
                $statusVal = ucwords(strtolower($statusVal));
                ?>
                <div class="form-input">
                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="Amandemen" <?php if ($statusVal == "Amandemen") echo 'selected="selected"'; ?>>AMANDEMEN</option>
                        <option value="Pasang Baru" <?php if ($statusVal == "Pasang Baru") echo 'selected="selected"'; ?>>PASANG BARU</option>
                        <option value="Perpanjangan" <?php if ($statusVal == "Perpanjangan") echo 'selected="selected"'; ?>>PERPANJANGAN</option>
                    </select>
                </div>
                <?php if ($firstProses == 'WITEL' or $firstProses == 'OBL' or $firstProses == 'LEGAL' or $firstProses == 'MITRA OBL') { ?>
                    <div class="form-input">
                        <label for="statusSM">Status SM</label>
                        <select name="statusSM" id="statusSM" style="cursor: not-allowed;" disabled>
                            <option value="NOT CLOSE" <?php if ($query["statusSM"] == "NOT CLOSE") echo 'selected="selected"'; ?>>NOT CLOSE</option>
                            <option value="CLOSE" <?php if ($query["statusSM"] == "CLOSE") echo 'selected="selected"'; ?>>CLOSE</option>
                        </select>
                    </div>
                    <input type="hidden" name="statusSM" value="<?= $query["statusSM"]; ?>">
                <?php } else {; ?>
                    <div class="form-input">
                        <label for="statusSM">Status SM</label>
                        <select name="statusSM" id="statusSM" required>
                            <option value="NOT CLOSE" <?php if ($query["statusSM"] == "NOT CLOSE") echo 'selected="selected"'; ?>>NOT CLOSE</option>
                            <option value="CLOSE" <?php if ($query["statusSM"] == "CLOSE") echo 'selected="selected"'; ?>>CLOSE</option>
                        </select>
                    </div>
                <?php }; ?>
                <div class="form-input">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan"><?= $query["keterangan"]; ?></textarea>
                </div>
                <div class="form-button">
                    <button type="submit" name="update">Update</button>
                    <a href="" id="clickTable" onclick="table()">Kembali ke Tabel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function(e) {
            $("#clickTable").on('click', function(e) {
                e.preventDefault();
                window.history.back()
            })
        })
    </script>

    <script>
        $(document).ready(function(e) {
            $("#namaPelanggan").autocomplete({
                source: 'autoComplete/namaPelanggan.php'
            });
            $("#namaVendor").autocomplete({
                source: 'autoComplete/namaVendor.php'
            });
            $("#layanan").autocomplete({
                source: 'autoComplete/layanan.php'
            });
        });
    </script>

    <?php
    if (isset($_POST["update"])) {
        $id = htmlspecialchars($_POST['id']);
        $proses = htmlspecialchars($_POST['proses']);
        $segmen = htmlspecialchars($_POST['segmen']);
        $tanggalSubmit = htmlspecialchars($_POST['tanggalSubmit']);
        $tanggalS = date("j-M-Y", strtotime($tanggalSubmit));
        $tanggalS = str_replace('-', ' ', $tanggalS);
        $tanggalUpdate = htmlspecialchars($_POST['tanggalUpdate']);
        $tanggal = date("j-M-Y", strtotime($tanggalUpdate));
        $tanggal = str_replace('-', ' ', $tanggal);
        $folder = htmlspecialchars($_POST['folder']);
        $jenisSPK = htmlspecialchars($_POST['jenisSPK']);
        $witel = htmlspecialchars($_POST['witel']);
        $namaPelanggan = htmlspecialchars($_POST['namaPelanggan']);
        $layanan = htmlspecialchars($_POST['layanan']);
        $namaVendor = htmlspecialchars($_POST['namaVendor']);
        $jangkaWaktu = htmlspecialchars($_POST['jangkaWaktu']);
        $valJangkaWaktu = intval($jangkaWaktu);
        $nilaiKB = htmlspecialchars($_POST['nilaiKB']);
        $valNilaiKB = intval(toNumber($nilaiKB));
        $no_KFS_SPK = htmlspecialchars($_POST['no_KFS_SPK']);
        $no_KL_WO_SuratPesanan = htmlspecialchars($_POST['no_KL_WO_SuratPesanan']);
        $noOrder = htmlspecialchars($_POST['no_order']);
        $sid = htmlspecialchars($_POST['sid']);
        $pic = htmlspecialchars($_POST['pic']);
        $statusSM = htmlspecialchars($_POST['statusSM']);
        $status = htmlspecialchars($_POST['status']);
        $keterangan = htmlspecialchars($_POST['keterangan']);
        $updatedBy = $nama;


        if ($proses == 'CLOSE SM' and ($noOrder != '-' and $noOrder != '') and ($sid != '-' and $sid != '') and $status == 'Perpanjangan') {
            $proses = 'DONE';
        } else if ($proses == 'CLOSE SM' and ($noOrder != '-' and $noOrder != '') and ($sid != '-' and $sid != '') and ($status == 'Amandemen' or $status == 'Pasang Baru')) {
            $proses = 'MITRA PJM';
        }

        if ($proses == 'CANCEL') {
            $query = "UPDATE report_obl SET
                    proses = '$proses',
                    segmen = '$segmen',
                    tanggal_submit = '$tanggalS', 
                    tanggal_update = '$tanggal', 
                    folder = '$folder', 
                    jenis_spk = '$jenisSPK', 
                    witel = '$witel',
                    nama_pelanggan = '$namaPelanggan',
                    layanan = '$layanan',
                    nama_vendor = '$namaVendor',
                    jangka_waktu = $valJangkaWaktu,
                    nilai_kb = $valNilaiKB,
                    no_KFS_SPK = '$no_KFS_SPK',
                    no_KL_WO_SuratPesanan = '$no_KL_WO_SuratPesanan',
                    no_order = '$noOrder',
                    sid = '$sid',
                    pic = '$pic',
                    status = '$status',
                    statusSM = '$statusSM',
                    keterangan = '$keterangan',
                    updated_by = '$updatedBy'
            WHERE id = $id";
            mysqli_query($conn, $query);
        } else {
            $query = "UPDATE report_obl SET
                    proses = '$proses',
                    segmen = '$segmen',
                    tanggal_submit = '$tanggalS', 
                    tanggal_update = '$tanggal', 
                    folder = '$folder', 
                    jenis_spk = '$jenisSPK', 
                    witel = '$witel',
                    nama_pelanggan = '$namaPelanggan',
                    layanan = '$layanan',
                    nama_vendor = '$namaVendor',
                    jangka_waktu = $valJangkaWaktu,
                    nilai_kb = $valNilaiKB,
                    no_KFS_SPK = '$no_KFS_SPK',
                    no_KL_WO_SuratPesanan = '$no_KL_WO_SuratPesanan',
                    no_order = '$noOrder',
                    sid = '$sid',
                    pic = '$pic',
                    status = '$status',
                    statusSM = '$statusSM',
                    keterangan = '$keterangan',
                    updated_by = '$updatedBy'
            WHERE id = $id";
            mysqli_query($conn, $query);
        }

        if (
            $firstProses != $proses or
            $firstSegmen != $segmen or
            $firstTanggalSubmit != $tanggalS or
            $firstTanggalUpdate != $tanggal or
            $firstFolder != $folder or
            $firstJenisSPK != $jenisSPK or
            $firstWitel != $witel or
            $firstNamaPelanggan != $namaPelanggan or
            $firstLayanan != $layanan or
            $firstNamaVendor != $namaVendor or
            $firstJangkaWaktu != $valJangkaWaktu or
            $firstNilaiKB != $valNilaiKB or
            $firstNoKFS != $no_KFS_SPK or
            $firstNoKL != $no_KL_WO_SuratPesanan or
            $firstNoOrder != $noOrder or
            $firstSid != $sid or
            $firstPIC != $pic or
            $firstStatus != $status or
            $firstStatusSM != $statusSM or
            $firstKeterangan != $keterangan
        ) {
            $query = "INSERT INTO historybefore (proses, segmen, tanggal_submit, tanggal_update, folder, jenis_spk, witel, nama_pelanggan, layanan, nama_vendor, jangka_waktu, nilai_kb, no_KFS_SPK, no_KL_WO_SuratPesanan, pic, status, statusSM, keterangan, updated_by) 
                    VALUES ('$firstProses', '$firstSegmen', '$firstTanggalSubmit', '$firstTanggalUpdate', '$firstFolder', '$firstJenisSPK', '$firstWitel', '$firstNamaPelanggan', '$firstLayanan', '$firstNamaVendor', $firstJangkaWaktu, $firstNilaiKB, '$firstNoKFS', '$firstNoKL', '$firstPIC', '$firstStatus', '$firstStatusSM', '$firstKeterangan', '$updatedBy')";
            mysqli_query($conn, $query);
            $query = "INSERT INTO historyafter (proses, segmen, tanggal_submit, tanggal_update, folder, jenis_spk, witel, nama_pelanggan, layanan, nama_vendor, jangka_waktu, nilai_kb, no_KFS_SPK, no_KL_WO_SuratPesanan, pic, status, statusSM, keterangan, updated_by) 
                    VALUES ('$proses', '$segmen', '$tanggalS', '$tanggal', '$folder', '$jenisSPK', '$witel', '$namaPelanggan', '$layanan', '$namaVendor', $jangkaWaktu, $valNilaiKB, '$no_KFS_SPK', '$no_KL_WO_SuratPesanan', '$pic', '$status', '$statusSM', '$keterangan', '$updatedBy')";
            mysqli_query($conn, $query);
        }

        if (mysqli_affected_rows($conn) == 1) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Update data berhasil',
                        showConfirmButton: false
                    })
                    setTimeout(function(){
                        window.history.go(-2)
                    }, 1800);
                </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'info',
                        title: 'Info',
                        showConfirmButton: false,
                        text: 'Tidak ada perubahan!'
                    })
                    setTimeout(function(){
                        window.history.back()
                    }, 1500);
                </script>";
        }
    }
    ?>
</body>

</html>