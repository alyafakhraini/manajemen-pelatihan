<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Ambil id_trainer dari sesi
$id_trainer = $_SESSION['id_trainer'];

// Query untuk mendapatkan nama trainer dari tbl_trainer
$query_trainer = mysqli_query($conn, "SELECT nama_trainer FROM tbl_trainer WHERE id_trainer = '$id_trainer'");
$data_trainer = mysqli_fetch_assoc($query_trainer);
$nama_trainer = $data_trainer['nama_trainer'];

// Query untuk mendapatkan data evaluasi dari tbl_evaluasi_trainer
$query_evaluasi = mysqli_query($conn, "SELECT rating_penguasaan_materi, rating_metode_pengajaran, rating_interaksi 
                                       FROM tbl_evaluasi_trainer WHERE id_trainer = '$id_trainer'");

$total_penguasaan_materi = 0;
$total_metode_pengajaran = 0;
$total_interaksi = 0;
$count = 0;

while ($row = mysqli_fetch_assoc($query_evaluasi)) {
    // Ambil angka sebelum koma dari tiap rating
    $penguasaan_materi = (float) explode(',', $row['rating_penguasaan_materi'])[0];
    $metode_pengajaran = (float) explode(',', $row['rating_metode_pengajaran'])[0];
    $interaksi = (float) explode(',', $row['rating_interaksi'])[0];

    // Tambahkan ke total
    $total_penguasaan_materi += $penguasaan_materi;
    $total_metode_pengajaran += $metode_pengajaran;
    $total_interaksi += $interaksi;
    $count++;
}

// Hitung rata-rata
$rata_penguasaan_materi = $count ? $total_penguasaan_materi / $count : 0;
$rata_metode_pengajaran = $count ? $total_metode_pengajaran / $count : 0;
$rata_interaksi = $count ? $total_interaksi / $count : 0;

// Query untuk mendapatkan kategori dan nama pelatihan
$query_pelatihan = mysqli_query($conn, "SELECT kategori_program, nama_pelatihan FROM tbl_pelatihan WHERE id_trainer = '$id_trainer'");
$pelatihan_data = [];
while ($row = mysqli_fetch_assoc($query_pelatihan)) {
    $pelatihan_data[] = $row;
}

function beriKeterangan($nilai, $jenis)
{
    if ($jenis === 'penguasaan_materi') {
        if ($nilai >= 91) return "Sangat Baik";
        elseif ($nilai >= 76) return "Baik";
        elseif ($nilai >= 61) return "Cukup";
        else return "Perlu Peningkatan";
    } elseif ($jenis === 'metode_pengajaran') {
        if ($nilai >= 91) return "Sangat Efektif";
        elseif ($nilai >= 76) return "Efektif";
        elseif ($nilai >= 61) return "Cukup Efektif";
        else return "Perlu Perbaikan";
    } elseif ($jenis === 'interaksi') {
        if ($nilai >= 91) return "Sangat Baik";
        elseif ($nilai >= 76) return "Baik";
        elseif ($nilai >= 61) return "Cukup";
        else return "Perlu Peningkatan";
    }
}

function getKategoriProgramText($kategori_program)
{
    switch ($kategori_program) {
        case 'level up':
            return 'Level Up';
        case 'ap':
            return 'Acceleration Program';
        case 'psc':
            return 'Professional Skill Certificate';
        case 'bootcamp':
            return 'Bootcamp';
        default:
            return 'Tidak Diketahui';
    }
}

function getBulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    return $bulanIndo[$bulan];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Performa Trainer</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" href="image/bcti_logo.png" type="image/png">
    <link rel="stylesheet" href="assets/css/print2.css">
    <style>
        .text-right {
            text-align: right !important;
        }
    </style>
    <script>
        window.print();
    </script>
</head>

<body>
    <div class="page-wrapper" id="main-wrapper">
        <div class="body-wrapper">
            <div class="container-fluid">
                <div class="content">
                    <div class="kop">
                        <div class="logo-bcti">
                            <img src="image/bcti_logo.png">
                        </div>
                        <div>
                            <center>
                                <font size="5"><b>BUSINESS & COMMUNICATION TRAINING INSTITUTE</b></font><br>
                                <font size="2"><b>Kampus SMP-SMA GIBS, Gedung Nurhayati Lantai 2</b></font><br>
                                <font size="2"><b>Jl. Trans Kalimantan, Sungai Lumbah, Alalak, Barito Kuala, Kalimantan Selatan – Indonesia 70582.</b></font><br>
                                <font size="2">Email: bcti@hasnurcentre.org website: www.bcti.id</font>
                            </center>
                        </div>
                    </div>

                    <section>
                        <h2 style="text-align: center; margin-top: 50px;">
                            <u>Laporan Performa Trainer: <?php echo $nama_trainer; ?></u>
                        </h2>
                        <h2 style="text-align: center; margin-top: 30px;">
                            <u>Pelatihan yang diampu:</u>
                            <ul style="list-style-type: none; padding: 0; margin-top: 5px;">
                                <?php
                                $pelatihan_ditampilkan = [];
                                foreach ($pelatihan_data as $row_pelatihan) {
                                    $pelatihan_key = $row_pelatihan['kategori_program'] . " : " . $row_pelatihan["nama_pelatihan"];
                                    if (!in_array($pelatihan_key, $pelatihan_ditampilkan)) {
                                        echo "<li>- " . getKategoriProgramText($row_pelatihan['kategori_program']) . " : " . $row_pelatihan["nama_pelatihan"] . "</li>";
                                        $pelatihan_ditampilkan[] = $pelatihan_key; // Tambahkan pelatihan ke array untuk mencegah duplikasi
                                    }
                                }
                                ?>
                            </ul>
                        </h2>

                        <div class="row">
                            <div class="col-12">
                                <table class="table" style="margin-top: 50px;">
                                    <thead>
                                        <tr>
                                            <th>Kriteria</th>
                                            <th>Rata-rata Nilai</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Penguasaan Materi</td>
                                            <td>
                                                <?php echo number_format($rata_penguasaan_materi, 2); ?>
                                            </td>
                                            <td>
                                                <?php echo beriKeterangan($rata_penguasaan_materi, 'penguasaan_materi'); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Metode Pengajaran</td>
                                            <td>
                                                <?php echo number_format($rata_metode_pengajaran, 2); ?>
                                            </td>
                                            <td>
                                                <?php echo beriKeterangan($rata_metode_pengajaran, 'metode_pengajaran'); ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Interaksi ke Peserta</td>
                                            <td>
                                                <?php echo number_format($rata_interaksi, 2); ?> </td>
                                            <td>
                                                <?php echo beriKeterangan($rata_interaksi, 'interaksi'); ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <div class="ttd">
            <table width="100%">
                <tr>
                    <td width="340px">
                        <center>
                            <p>Barito Kuala, <?php echo date("d") . ' ' . getBulanIndonesia(date("n")) . ' ' . date("Y"); ?></p>
                        </center>
                        <center>
                            <img src="image/ttd.png" style="max-width: 100px; width: 100px; height: auto;">
                        </center>
                        <br>
                        <center><b>Muhammad Zain Mahbuby, B.Eng. (Hons) CETP, CLMA.</b></center>
                        <center>Koordinator BCTI</center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>