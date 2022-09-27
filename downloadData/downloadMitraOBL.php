<?php
error_reporting(E_ERROR);
session_start();
require '../config/functions.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $query = mysqli_query($conn, "SELECT * FROM report_obl WHERE UPPER(nama_vendor) LIKE '%$nama%' AND
                    UPPER(proses) = 'MITRA OBL'
                    ORDER BY folder ASC");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM report_obl WHERE UPPER(nama_vendor) LIKE '%$nama%' AND
                    UPPER(proses) = 'MITRA OBL' AND
                    (UPPER(witel) LIKE '%$witel%' OR
                    SUBSTRING(folder, 1, 2) LIKE '%$tahun%' OR 
                    UPPER(segmen) LIKE '%$segmen%' OR 
                    UPPER(nama_pelanggan) LIKE '%$pelanggan%' OR 
                    UPPER(status) LIKE '%$status%')
                    ORDER BY folder ASC");
    }
} else if ($level == 'witel') {
    if ($tahun == '' and $mitra == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $query = mysqli_query($conn, "SELECT * FROM report_obl WHERE UPPER(witel) LIKE '%$witel%' AND
                    UPPER(proses) = 'MITRA OBL'
                    ORDER BY folder ASC");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM report_obl WHERE UPPER(witel) LIKE '%$witel%' AND
                    UPPER(proses) = 'MITRA OBL' AND
                    (UPPER(segmen) LIKE '%$segmen%' AND
                    SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                    UPPER(nama_vendor) LIKE '%$mitra%' AND 
                    UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                    UPPER(status) LIKE '%$status%')
                    ORDER BY folder ASC");
    }
} else {
    if ($witel == '' and $tahun == '' and $mitra == '' and $pelanggan == '' and $segmen == '' and $status == '') {
        $query = mysqli_query($conn, "SELECT * FROM report_obl WHERE UPPER(proses) = 'MITRA OBL'
                    ORDER BY folder ASC");
    } else {
        $query = mysqli_query($conn, "SELECT * FROM report_obl WHERE UPPER(proses) = 'MITRA OBL' AND
                    (UPPER(witel) LIKE '%$witel%' AND
                    SUBSTRING(folder, 1, 2) LIKE '%$tahun%' AND 
                    UPPER(segmen) LIKE '%$segmen%' AND 
                    UPPER(nama_vendor) LIKE '%$mitra%' AND 
                    UPPER(nama_pelanggan) LIKE '%$pelanggan%' AND 
                    UPPER(status) LIKE '%$status%')
                    ORDER BY folder ASC");
    }
}

$date = date("d-m-Y");
$fileName = "MitraOBL-report-obl(" . $date . ")";

if (mysqli_num_rows($query) > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'NO');
    $sheet->setCellValue('B1', 'PROSES');
    $sheet->setCellValue('C1', 'SEGMEN');
    $sheet->setCellValue('D1', 'TANGGAL SUBMIT');
    $sheet->setCellValue('E1', 'TANGGAL UPDATE');
    $sheet->setCellValue('F1', 'FOLDER');
    $sheet->setCellValue('G1', 'JENIS SPK');
    $sheet->setCellValue('H1', 'WITEL');
    $sheet->setCellValue('I1', 'NAMA PELANGGAN');
    $sheet->setCellValue('J1', 'LAYANAN');
    $sheet->setCellValue('K1', 'NAMA VENDOR');
    $sheet->setCellValue('L1', 'JANGKA WAKTU');
    $sheet->setCellValue('M1', 'NILAI KB');
    $sheet->setCellValue('N1', 'NO KFS/SPK');
    $sheet->setCellValue('O1', 'NO KL/WO/SURAT PESANAN');
    $sheet->setCellValue('P1', 'NO ORDER');
    $sheet->setCellValue('Q1', 'SID');
    $sheet->setCellValue('R1', 'PIC');
    $sheet->setCellValue('S1', 'STATUS');
    $sheet->setCellValue('T1', 'STATUS SM');
    $sheet->setCellValue('U1', 'KETERANGAN');

    $rowCount = 2;
    $no = 1;
    foreach ($query as $data) {
        $sheet->setCellValue('A' . $rowCount, $no);
        $sheet->setCellValue('B' . $rowCount, $data['proses']);
        $sheet->setCellValue('C' . $rowCount, $data['segmen']);
        $sheet->setCellValue('D' . $rowCount, $data['tanggal_submit']);
        $sheet->setCellValue('E' . $rowCount, $data['tanggal_update']);
        $sheet->setCellValue('F' . $rowCount, $data['folder']);
        $sheet->setCellValue('G' . $rowCount, $data['jenis_spk']);
        $sheet->setCellValue('H' . $rowCount, $data['witel']);
        $sheet->setCellValue('I' . $rowCount, $data['nama_pelanggan']);
        $sheet->setCellValue('J' . $rowCount, $data['layanan']);
        $sheet->setCellValue('K' . $rowCount, $data['nama_vendor']);
        $sheet->setCellValue('L' . $rowCount, $data['jangka_waktu']);
        $sheet->setCellValue('M' . $rowCount, $data['nilai_kb']);
        $sheet->setCellValue('N' . $rowCount, $data['no_KFS_SPK']);
        $sheet->setCellValue('O' . $rowCount, $data['no_KL_WO_SuratPesanan']);
        $sheet->setCellValue('P' . $rowCount, $data['no_order']);
        $sheet->setCellValue('Q' . $rowCount, $data['sid']);
        $sheet->setCellValue('R' . $rowCount, $data['pic']);
        $sheet->setCellValue('S' . $rowCount, $data['status']);
        $sheet->setCellValue('T' . $rowCount, $data['statusSM']);
        $sheet->setCellValue('U' . $rowCount, $data['keterangan']);
        $rowCount++;
        $no++;
    }

    $writer = new Xlsx($spreadsheet);
    $final_filename = $fileName . '.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . urlencode($final_filename) . '"');
    $writer->save('php://output');
} else {
    echo "<script>
            alert('Download tidak berhasil, data tidak ada');
            window.history.go(-1);
        </script>";
}
