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
    <link rel="stylesheet" href="css/styleForm.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/script.js"></script>
    <title>Tambah Data</title>
</head>

<body>
    <div class="area">
        <div class="container">
            <h2>Tambah Data</h2>
            <form action="" method="post">
                <div class="form-input">
                    <label for="">Proses</label>
                    <select name="proses" id="proses" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="WITEL" class="opt">WITEL</option>
                        <option value="OBL" class="opt">OBL</option>
                        <option value="LEGAL" class="opt">LEGAL</option>
                        <option value="MITRA OBL" class="opt">MITRA OBL</option>
                        <option value="CLOSE SM" class="opt">CLOSE SM</option>
                        <option value="PJM" class="opt">PJM</option>
                        <option value="MITRA PJM" class="opt">MITRA PJM</option>
                        <option value="DONE" class="opt">DONE</option>
                        <option value="CANCEL" class="opt">CANCEL</option>
                    </select>
                </div>
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
                <div class="form-input">
                    <label for="segmen">Segmen</label>
                    <select name="segmen" id="segmen" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="DES">DES</option>
                        <option value="DGS">DGS</option>
                        <option value="DBS">DBS</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="tanggalSubmit">Tanggal Submit</label>
                    <input type="date" name="tanggalSubmit" id="tanggalSubmit" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="tanggalUpdate">Tanggal Update</label>
                    <input type="date" name="tanggalUpdate" id="tanggalUpdate" autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="folder">Folder</label>
                    <input type="text" name="folder" id="folder" placeholder="Masukkan nomor folder..." autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="jenisSPK">Jenis SPK</label>
                    <select name="jenisSPK" id="jenisSPK" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="KL">KL</option>
                        <option value="SP">SP</option>
                        <option value="WO">WO</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="witel">Witel</label>
                    <select name="witel" id="witel" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="BALIKPAPAN">BALIKPAPAN</option>
                        <option value="SAMARINDA">SAMARINDA</option>
                        <option value="KALBAR">KALBAR</option>
                        <option value="KALSEL">KALSEL</option>
                        <option value="KALTARA">KALTARA</option>
                        <option value="KALTENG">KALTENG</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="namaPelanggan">Nama Pelanggan</label>
                    <input type="text" name="namaPelanggan" id="namaPelanggan" placeholder="Masukkan nama pelanggan..." autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="layanan">Layanan</label>
                    <input type="text" name="layanan" id="layanan" placeholder="Masukkan jenis layanan..." autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="namaVendor">Nama Vendor</label>
                    <input type="text" name="namaVendor" id="namaVendor" placeholder="Masukkan nama vendor..." autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="jangkaWaktu">Jangka Waktu (Bulan)</label>
                    <input type="number" name="jangkaWaktu" id="jangkaWaktu" placeholder="Masukkan jangka waktu..." autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="nilaiKB">Nilai KB</label>
                    <input type="text" name="nilaiKB" id="nilaiKB" placeholder="Masukkan Nilai KB..." autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="no_KFS_SPK">No KFS/SPK</label>
                    <input type="text" name="no_KFS_SPK" id="no_KFS_SPK" placeholder="Masukkan No KFS/SPK..." autocomplete="off" required>
                </div>
                <div class="form-input">
                    <label for="no_KL_WO_SuratPesanan">No KL/WO/Surat Pesanan</label>
                    <input type="text" name="no_KL_WO_SuratPesanan" id="no_KL_WO_SuratPesanan" placeholder="Masukkan No KL/WO/Surat Pesanan..." autocomplete="off" required>
                </div>
                <?php if ($level == 'inputerwitel') { ?>
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
                    <input type="text" name="pic" id="pic" placeholder="Masukkan pic..." autocomplete="off" required>
                </div>
                <?php $statusVal = $query["status"]; ?>
                <?php $statusVal = strtolower($statusVal); ?>
                <div class="form-input">
                    <label for="status">Status</label>
                    <select name="status" id="status" required>
                        <option value="" selected disabled>Pilih</option>
                        <option value="Amandemen">AMANDEMEN</option>
                        <option value="Pasang Baru">PASANG BARU</option>
                        <option value="Perpanjangan">PERPANJANGAN</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="statusSM">status SM</label>
                    <select name="statusSM" id="statusSM" required>
                        <option value="NOT CLOSE" selected>NOT CLOSE</option>
                        <option value="CLOSE">CLOSE</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="keterangan">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" required></textarea>
                </div>
                <div class="form-button">
                    <button type="submit" name="tambah" id="tambah">Submit</button>
                    <a href="index.php">Kembali ke Dashboard</a>
                </div>
            </form>
        </div>
    </div>

    <?php
    if (isset($_POST["tambah"])) {
        $id_data = query("SELECT id FROM report_obl ORDER BY id DESC LIMIT 1")[0]["id"];
        $id = $id_data + 1;
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
        $jangkaWaktu = intval($jangkaWaktu);
        $nilaiKB = htmlspecialchars($_POST['nilaiKB']);
        $valNilaiKB = intval(toNumber($nilaiKB));
        $no_KFS_SPK = htmlspecialchars($_POST['no_KFS_SPK']);
        $no_KL_WO_SuratPesanan = htmlspecialchars($_POST['no_KL_WO_SuratPesanan']);
        $noOrder = htmlspecialchars($_POST['no_order']);
        $sid = htmlspecialchars($_POST['sid']);
        $pic = htmlspecialchars($_POST['pic']);
        $status = htmlspecialchars($_POST['status']);
        $statusSM = htmlspecialchars($_POST['statusSM']);
        $keterangan = htmlspecialchars($_POST['keterangan']);
        $updatedBy = $nama;

        if ($proses == 'CLOSE SM' and $noOrder != '-' and $sid != '-' and $status == 'Perpanjangan') {
            $proses = 'DONE';
        } else if ($proses == 'CLOSE SM' and $noOrder != '-' and $sid != '-' and ($status == 'Amandemen' or $status == 'Pasang Baru')) {
            $proses = 'MITRA PJM';
        }

        $query = "INSERT INTO report_obl (id, proses, segmen, tanggal_submit, tanggal_update, folder, jenis_spk, witel, nama_pelanggan, layanan, nama_vendor, jangka_waktu, nilai_kb, no_KFS_SPK, no_KL_WO_SuratPesanan, pic, status, statusSM, keterangan, updated_by) 
                    VALUES ('$id', '$proses', '$segmen', '$tanggalS', '$tanggal', '$folder', '$jenisSPK', '$witel', '$namaPelanggan', '$layanan', '$namaVendor', $jangkaWaktu, $valNilaiKB, '$no_KFS_SPK', '$no_KL_WO_SuratPesanan', '$pic', '$status', '$statusSM', '$keterangan', '$updatedBy')";
        mysqli_query($conn, $query);
        $query = "INSERT INTO historytambah (proses, segmen, tanggal_submit, tanggal_update, folder, jenis_spk, witel, nama_pelanggan, layanan, nama_vendor, jangka_waktu, nilai_kb, no_KFS_SPK, no_KL_WO_SuratPesanan, pic, status, statusSM, keterangan, updated_by) 
                    VALUES ('$proses', '$segmen', '$tanggalS', '$tanggal', '$folder', '$jenisSPK', '$witel', '$namaPelanggan', '$layanan', '$namaVendor', $jangkaWaktu, $valNilaiKB, '$no_KFS_SPK', '$no_KL_WO_SuratPesanan', '$pic', '$status', '$statusSM', '$keterangan', '$updatedBy')";
        mysqli_query($conn, $query);


        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Tambah data berhasil!',
                        showConfirmButton: false
                    })
                    setTimeout(function(){
                        document.location.href = 'index.php';
                    }, 1800);
                </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi kesalahan',
                        showConfirmButton: false,
                        text: 'Tambah data gagal!'
                    })
                    setTimeout(function(){
                        window.history.back()
                    }, 1500);
                </script>";
        }
    }
    ?>

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
</body>

</html>