<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'trainer') {
    header("Location: login.php");
    exit;
}

$limit = 50;
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

if (isset($_GET["id_pelatihan"])) {

    $id_pelatihan = $_GET["id_pelatihan"];

    // Ambil nama pelatihan dan kategori program
    $query_pelatihan = mysqli_query($conn, "SELECT nama_pelatihan, kategori_program FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'");
    $data_pelatihan = mysqli_fetch_assoc($query_pelatihan);
    $nama_pelatihan = $data_pelatihan['nama_pelatihan'];
    $kategori_program = $data_pelatihan['kategori_program'];

    // Menentukan teks kategori program
    switch ($kategori_program) {
        case 'level up':
            $kategori_program_text = 'Level Up';
            break;
        case 'psc':
            $kategori_program_text = 'Professional Skill Certificate';
            break;
        case 'ap':
            $kategori_program_text = 'Acceleration Program';
            break;
        case 'bootcamp':
            $kategori_program_text = 'Bootcamp';
            break;
        default:
            $kategori_program_text = ucfirst($kategori_program);
            break;
    }

    // Ambil nama trainer
    $query_trainer = mysqli_query($conn, "SELECT T.nama_trainer
                                         FROM tbl_pelatihan P, tbl_trainer T
                                         WHERE P.id_trainer = T.id_trainer
                                         AND P.id_pelatihan = '$id_pelatihan'");
    $data_trainer = mysqli_fetch_assoc($query_trainer);
    $nama_trainer = $data_trainer['nama_trainer'];

    $result_total = mysqli_query($conn, "SELECT COUNT(*) AS total
                                         FROM tbl_evaluasi_trainer E, tbl_pelatihan P, tbl_kehadiran H
                                         WHERE E.id_pelatihan = P.id_pelatihan
                                         AND E.id_kehadiran = H.id_kehadiran
                                         AND P.id_pelatihan = '$id_pelatihan'
                                         AND H.status_kehadiran = 'hadir'");
    $total_records = mysqli_fetch_assoc($result_total)['total'];

    $result_evaluasi = mysqli_query($conn, "SELECT C.nama_peserta, T.nama_trainer, E.tgl_input_evaluasi_trainer, E.rating_penguasaan_materi, E.rating_metode_pengajaran, E.rating_interaksi, E.feedback
                                           FROM tbl_evaluasi_trainer E, tbl_kehadiran H, tbl_trainer T, tbl_pelatihan P, tbl_peserta C
                                           WHERE E.id_kehadiran = H.id_kehadiran
                                           AND E.id_trainer = T.id_trainer
                                           AND E.id_pelatihan = P.id_pelatihan 
                                           AND E.id_peserta = C.id_peserta
                                           AND P.id_pelatihan = '$id_pelatihan' 
                                           AND H.status_kehadiran = 'hadir'  
                                           LIMIT $mulai, $limit");
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Evaluasi Trainer</title>
    <!-- Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Logo Halaman -->
    <link rel="icon" href="image/bcti_logo.png" type="image/png">
    <!-- Print CSS -->
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
                        <h2 style="text-align: center; margin-top: 40px;">
                            <u>Laporan Evaluasi Trainer <?php echo $kategori_program_text . ': ' . $nama_pelatihan; ?></u>
                        </h2>
                        <h2 style="text-align: center; margin-top: 10px;">
                            <u>Nama Trainer: <?php echo $nama_trainer; ?></u>
                        </h2>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta</th>
                                            <th>Tanggal Pengisian Evaluasi</th>
                                            <th>Rating Penguasaan Materi</th>
                                            <th>Rating Metode Pengajaran</th>
                                            <th>Rating Interaksi</th>
                                            <th>Feedback</th>
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
                                                    if (isset($row_evaluasi["tgl_input_evaluasi_trainer"])) {
                                                        $tgl_input_evaluasi_trainer = $row_evaluasi["tgl_input_evaluasi_trainer"];
                                                        $timestamp = strtotime($tgl_input_evaluasi_trainer);
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
                                                <td><?php echo $row_evaluasi["rating_penguasaan_materi"]; ?></td>
                                                <td><?php echo $row_evaluasi["rating_metode_pengajaran"]; ?></td>
                                                <td><?php echo $row_evaluasi["rating_interaksi"]; ?></td>
                                                <td><?php echo $row_evaluasi["feedback"]; ?></td>
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