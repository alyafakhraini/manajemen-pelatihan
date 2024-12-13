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

$limit = 50;
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

if (isset($_GET["id_pelatihan"])) {

    $id_pelatihan = $_GET["id_pelatihan"];

    // Ambil nama pelatihan dan kategori program
    $query_pelatihan = mysqli_query($conn, "SELECT nama_pelatihan, kategori_program FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'");
    $pelatihan_data = mysqli_fetch_assoc($query_pelatihan);

    $nama_pelatihan = $pelatihan_data['nama_pelatihan'];
    $kategori_program = $pelatihan_data['kategori_program'];
    $kategori_program_text = getKategoriProgramText($kategori_program); // Panggil fungsi untuk mendapatkan teks kategori program

    $result_total = mysqli_query($conn, "SELECT COUNT(*) AS total
                                         FROM tbl_evaluasi_pelatihan E, tbl_pelatihan P, tbl_kehadiran H
                                         WHERE E.id_pelatihan = P.id_pelatihan
                                         AND E.id_kehadiran = H.id_kehadiran
                                         AND P.id_pelatihan = '$id_pelatihan'
                                         AND H.status_kehadiran = 'hadir'");
    $total_records = mysqli_fetch_assoc($result_total)['total'];

    $result_evaluasi = mysqli_query($conn, "SELECT C.nama_peserta, E.tgl_input_evaluasi_pelatihan, E.rating_materi, E.rating_fasilitas, E.rating_bcti, E.feedback, E.rekomendasi
                                           FROM tbl_evaluasi_pelatihan E, tbl_kehadiran H, tbl_pelatihan P, tbl_peserta C
                                           WHERE E.id_kehadiran = H.id_kehadiran
                                           AND E.id_pelatihan = P.id_pelatihan 
                                           AND E.id_peserta = C.id_peserta
                                           AND P.id_pelatihan = '$id_pelatihan' 
                                           AND H.status_kehadiran = 'hadir'  
                                           LIMIT $mulai, $limit");

    // Hitung rata-rata nilai
    $avg_result = mysqli_query($conn, "SELECT AVG(rating_materi) AS avg_materi, 
                                               AVG(rating_fasilitas) AS avg_fasilitas, 
                                               AVG(rating_bcti) AS avg_bcti
                                        FROM tbl_evaluasi_pelatihan E
                                        JOIN tbl_kehadiran H ON E.id_kehadiran = H.id_kehadiran
                                        WHERE H.status_kehadiran = 'hadir' AND E.id_pelatihan = '$id_pelatihan'");
    $avg_data = mysqli_fetch_assoc($avg_result);
} else {
    $total_records = 0;
    $result_evaluasi = false;
    $nama_pelatihan = "";
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

function beriKeterangan($nilai, $jenis)
{
    if ($jenis === 'materi') {
        if ($nilai >= 91) return "Sangat Baik";
        elseif ($nilai >= 76) return "Baik";
        elseif ($nilai >= 61) return "Cukup";
        else return "Perlu Peningkatan";
    } elseif ($jenis === 'fasilitas') {
        if ($nilai >= 91) return "Sangat Memuaskan";
        elseif ($nilai >= 76) return "Memuaskan";
        elseif ($nilai >= 61) return "Cukup Memuaskan";
        else return "Perlu Peningkatan";
    } elseif ($jenis === 'bcti') {
        if ($nilai >= 91) return "Sangat Baik";
        elseif ($nilai >= 76) return "Baik";
        elseif ($nilai >= 61) return "Cukup";
        else return "Perlu Peningkatan";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Evaluasi Pelatihan</title>
    <!-- Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Logo Halaman -->
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <!-- Print CSS -->
    <link rel="stylesheet" href="../assets/css/print2.css">
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
                            <img src="../image/bcti_logo.png">
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
                        <h2 style="text-align: center; margin-top: 40px;">
                            <u>Laporan Evaluasi Pelatihan </u>
                        </h2>
                        <h2 style="text-align: center;">
                            <u><?php echo $kategori_program_text . ': ' . $nama_pelatihan; ?></u>
                        </h2>

                        <!-- Tabel Rata-Rata Penilaian -->
                        <table style="width: 100%; border-collapse: collapse; margin-top: 50px;">
                            <tr>
                                <th style="border: 1px solid #000; padding: 10px; text-align: center;">Kriteria</th>
                                <th style="border: 1px solid #000; padding: 10px; text-align: center;">Rata-Rata Nilai</th>
                                <th style="border: 1px solid #000; padding: 10px; text-align: center;">Keterangan</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;">Materi Pelatihan</td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo number_format($avg_data['avg_materi'], 2); ?></td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo beriKeterangan($avg_data['avg_materi'], 'materi'); ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;">Fasilitas Pelatihan</td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo number_format($avg_data['avg_fasilitas'], 2); ?></td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo beriKeterangan($avg_data['avg_fasilitas'], 'fasilitas'); ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;">Service BCTI</td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo number_format($avg_data['avg_bcti'], 2); ?></td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo beriKeterangan($avg_data['avg_bcti'], 'bcti'); ?></td>
                            </tr>
                        </table>

                        <div class="row">
                            <div class="col-12">
                                <table class="table" style="margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta</th>
                                            <th>Tanggal Pengisian Evaluasi</th>
                                            <th>Rating Materi</th>
                                            <th>Rating Fasilitas</th>
                                            <th>Rating BCTI</th>
                                            <th>Feedback</th>
                                            <th>Rekomendasi Pelatihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_evaluasi = mysqli_fetch_assoc($result_evaluasi)) { ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row_evaluasi["nama_peserta"]; ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($row_evaluasi["tgl_input_evaluasi_pelatihan"])) {
                                                        $tgl_input_evaluasi_pelatihan = $row_evaluasi["tgl_input_evaluasi_pelatihan"];
                                                        $timestamp = strtotime($tgl_input_evaluasi_pelatihan);
                                                        $bulan = date("n", $timestamp);
                                                        $tahun = date("Y", $timestamp);
                                                        $tanggal = date("j", $timestamp);
                                                        $jam = date("H:i:s", $timestamp);
                                                        echo sprintf("%02d %s %d %s", $tanggal, getBulanIndonesia($bulan), $tahun, $jam);
                                                    } else {
                                                        echo "Tanggal tidak tersedia";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $row_evaluasi["rating_materi"]; ?></td>
                                                <td><?php echo $row_evaluasi["rating_fasilitas"]; ?></td>
                                                <td><?php echo $row_evaluasi["rating_bcti"]; ?></td>
                                                <td><?php echo $row_evaluasi["feedback"]; ?></td>
                                                <td><?php echo $row_evaluasi["rekomendasi"]; ?></td>
                                            </tr>
                                        <?php } ?>
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
                            <img src="../image/ttd.png" style="max-width: 100px; width: 100px; height: auto;">
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