<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'admin' && $level != 'panitia') {
    header("Location: ../login.php");
    exit;
}

$data = array();

function getBulanIndonesia($bulan)
{
    $bulanIndonesia = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    return $bulanIndonesia[(int)$bulan];
}

function formatTanggalIndonesia($date)
{
    $timestamp = strtotime($date);
    $day = date('d', $timestamp);
    $month = getBulanIndonesia(date('n', $timestamp));
    $year = date('Y', $timestamp);
    return "$day $month $year";
}

// Query untuk tabel tbl_agenda
$query_agenda =
    "SELECT id_agenda AS id, nama_agenda AS title, tgl_agenda AS start, tgl_agenda AS end, deskripsi, tujuan_tempat AS location 
    FROM tbl_agenda";

$statement_agenda = $conn->prepare($query_agenda);
if (!$statement_agenda) {
    die('Query Error: ' . $conn->error);
}

$statement_agenda->execute();
$result_agenda = $statement_agenda->get_result();
if (!$result_agenda) {
    die('Execute Error: ' . $statement_agenda->error);
}

while ($row_agenda = $result_agenda->fetch_assoc()) {
    // Tetapkan warna untuk acara dari tabel tbl_agenda
    $color = '#a14242';

    $formattedDate = formatTanggalIndonesia($row_agenda['start']);

    $data[] = array(
        'id' => $row_agenda['id'],
        'title' => $row_agenda['title'],
        'start' => $row_agenda['start'],
        'end' => $row_agenda['end'],
        'description' => $row_agenda['deskripsi'],
        'location' => $row_agenda['location'],
        'color' => $color, // Warna untuk tbl_agenda
        'kategori_program' => null, // Tidak diperlukan untuk tbl_agenda
        'formattedDate' => $formattedDate
    );
}

// Query untuk tabel tbl_pelatihan
$query_pelatihan =
    "SELECT id_pelatihan AS id, nama_pelatihan AS title, tgl_pelatihan AS start, tgl_pelatihan AS end, waktu, deskripsi, tempat AS location, kategori_program 
    FROM tbl_pelatihan";

$statement_pelatihan = $conn->prepare($query_pelatihan);
if (!$statement_pelatihan) {
    die('Query Error: ' . $conn->error);
}

$statement_pelatihan->execute();
$result_pelatihan = $statement_pelatihan->get_result();
if (!$result_pelatihan) {
    die('Execute Error: ' . $statement_pelatihan->error);
}

while ($row_pelatihan = $result_pelatihan->fetch_assoc()) {
    // Tentukan warna berdasarkan kategori program untuk acara dari tabel tbl_pelatihan
    switch ($row_pelatihan['kategori_program']) {
        case 'level up':
            $color = '#976ee2';
            break;
        case 'psc':
            $color = '#fa8526';
            break;
        case 'ap':
            $color = '#4c8adb';
            break;
        case 'bootcamp':
            $color = '#35cb88';
            break;
        default:
            $color = '#000000'; // Warna default jika kategori tidak dikenali
            break;
    }

    $formattedDate = formatTanggalIndonesia($row_pelatihan['start']) . ' (' . $row_pelatihan['waktu'] . ')';

    $data[] = array(
        'id' => $row_pelatihan['id'],
        'title' => $row_pelatihan['title'],
        'start' => $row_pelatihan['start'],
        'end' => $row_pelatihan['end'],
        'description' => $row_pelatihan['deskripsi'],
        'location' => $row_pelatihan['location'],
        'color' => $color, // Warna berdasarkan kategori program
        'kategori_program' => $row_pelatihan['kategori_program'],
        'time' => $row_pelatihan['waktu'],
        'formattedDate' => $formattedDate
    );
}

// Mengirimkan hasil sebagai JSON
header('Content-Type: application/json');
echo json_encode($data);
