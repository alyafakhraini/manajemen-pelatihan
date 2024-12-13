<?php
session_start();

use Mpdf\Mpdf;

require_once __DIR__ . '/vendor/autoload.php';
require "koneksi.php";

$id_pelatihan = isset($_GET['id_pelatihan']) ? $_GET['id_pelatihan'] : '';
$id_peserta = isset($_GET['id_peserta']) ? $_GET['id_peserta'] : '';

if (!empty($id_pelatihan) && !empty($id_peserta)) {
    // Query untuk mendapatkan data sertifikat
    $query_sertifikat = mysqli_query($conn, "SELECT sertif.*, pelatihan.nama_pelatihan, peserta.nama_peserta, hadir.status_kehadiran
                                            FROM tbl_sertifikat AS sertif
                                            JOIN tbl_kehadiran AS hadir ON sertif.id_kehadiran = hadir.id_kehadiran
                                            JOIN tbl_pelatihan AS pelatihan ON sertif.id_pelatihan = pelatihan.id_pelatihan
                                            JOIN tbl_peserta AS peserta ON sertif.id_peserta = peserta.id_peserta
                                            WHERE sertif.id_pelatihan = '$id_pelatihan' AND sertif.id_peserta = '$id_peserta'");
    $data_sertifikat = mysqli_fetch_assoc($query_sertifikat);

    // Jika data sertifikat ditemukan
    if ($data_sertifikat) {
        $id_sertifikat = $data_sertifikat['id_sertifikat']; // Mendapatkan id_sertifikat

        // Query untuk mendapatkan template sertifikat
        $query_template = mysqli_query($conn, "SELECT template_sertifikat FROM tbl_template_sertifikat WHERE id_pelatihan = '$id_pelatihan'");
        $data_template = mysqli_fetch_assoc($query_template);

        // Jika template ditemukan
        if ($data_template) {
            $background_image = 'template_sertifikat/' . htmlspecialchars($data_template['template_sertifikat']);

            // Inisialisasi objek Mpdf dengan format F4 dan orientasi landscape
            $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => [210, 330], 'orientation' => 'L']);
            $mpdf->SetDisplayMode('fullpage');

            // Konten HTML untuk PDF berdasarkan data sertifikat
            $html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat</title>
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("' . $background_image . '");
            background-size: cover;
            background-position: center;
            position: relative; /* Ensure absolute positioning works correctly */
            width: 100%;
            height: 100%;
        }
        .sertifikat-content {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        .nomor-sertifikat {
            font-size: 18px; /* Ukuran font nomor sertifikat */
            position: absolute;
            padding-top: 150px; /* Adjust this value as needed */
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
        .nama-peserta {
            font-family: "Lora", serif;
            font-size: 50px; /* Ukuran font nama peserta */
            font-weight: bold;
            position: absolute;
            padding-top: 100px; /* Adjust this value as needed */
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="sertifikat-content">
        <div class="nomor-sertifikat">' . htmlspecialchars($data_sertifikat['no_sertif']) . '</div>
        <div class="nama-peserta">' . htmlspecialchars($data_sertifikat['nama_peserta']) . '</div>
    </div>
</body>
</html>';

            // Tambahkan konten HTML ke halaman PDF
            $mpdf->WriteHTML($html);

            // Output PDF ke browser dengan nama file
            $filename = 'Sertifikat ' . htmlspecialchars($data_sertifikat['nama_pelatihan']) . ' - ' . htmlspecialchars($data_sertifikat['nama_peserta']) . '.pdf';
            $mpdf->Output($filename, \Mpdf\Output\Destination::INLINE);
        } else {
            echo "Template sertifikat tidak ditemukan.";
        }
    } else {
        echo "Data sertifikat tidak ditemukan untuk peserta ini.";
    }
} else {
    echo "ID Pelatihan atau ID Peserta tidak valid.";
}
