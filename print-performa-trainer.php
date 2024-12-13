<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'trainer') {
    header("Location: access-denied.php");
    exit;
}

$limit = 50;
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

$id_trainer = isset($_SESSION['id_trainer']) ? $_SESSION['id_trainer'] : '';

// Base query untuk mengambil data evaluasi
$query_evaluasi = "SELECT C.nama_peserta, E.tgl_input_evaluasi_trainer, E.rating_penguasaan_materi, T.nama_trainer,
                          E.rating_metode_pengajaran, E.rating_interaksi, E.feedback, P.nama_pelatihan, P.kategori_program
                   FROM tbl_evaluasi_trainer E
                   JOIN tbl_kehadiran H ON E.id_kehadiran = H.id_kehadiran
                   JOIN tbl_pelatihan P ON E.id_pelatihan = P.id_pelatihan
                   JOIN tbl_trainer T ON P.id_trainer = T.id_trainer
                   JOIN tbl_peserta C ON E.id_peserta = C.id_peserta
                   WHERE H.status_kehadiran = 'hadir'
                   AND P.id_trainer = '$id_trainer'";

// Jalankan query untuk mengambil data evaluasi
$result_evaluasi = mysqli_query($conn, $query_evaluasi);

// Simpan hasil query ke dalam array
$evaluasi_data = [];
while ($row_evaluasi = mysqli_fetch_assoc($result_evaluasi)) {
    $evaluasi_data[] = $row_evaluasi;
}

// Hitung rata-rata nilai
$avg_result = mysqli_query($conn, "SELECT AVG(rating_penguasaan_materi) AS avg_penguasaan,
                                            AVG(rating_metode_pengajaran) AS avg_metode,
                                            AVG(rating_interaksi) AS avg_interaksi
                                     FROM tbl_evaluasi_trainer E
                                     JOIN tbl_kehadiran H ON E.id_kehadiran = H.id_kehadiran
                                     WHERE H.status_kehadiran = 'hadir' " .
    (!empty($id_pelatihan) ? " AND E.id_pelatihan = '$id_pelatihan'" : "") .
    (!empty($id_trainer) ? " AND E.id_trainer = '$id_trainer'" : ""));

$avg_data = mysqli_fetch_assoc($avg_result);

function getBulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => "Januari",
        2 => "Februari",
        3 => "Maret",
        4 => "April",
        5 => "Mei",
        6 => "Juni",
        7 => "Juli",
        8 => "Agustus",
        9 => "September",
        10 => "Oktober",
        11 => "November",
        12 => "Desember"
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
    if ($jenis === 'penguasaan') {
        if ($nilai >= 91) return "Sangat Baik";
        elseif ($nilai >= 76) return "Baik";
        elseif ($nilai >= 61) return "Cukup";
        else return "Perlu Peningkatan";
    } elseif ($jenis === 'metode') {
        if ($nilai >= 91) return "Sangat Baik";
        elseif ($nilai >= 76) return "Baik";
        elseif ($nilai >= 61) return "Cukup";
        else return "Perlu Peningkatan";
    } elseif ($jenis === 'interaksi') {
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
    <title>Laporan Evaluasi Trainer</title>
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
                        <h2 style="text-align: center; margin-top: 40px;">
                            <u>Laporan Evaluasi Trainer</u>
                        </h2>
                        <h2 style="text-align: center; margin-top: 30px;">
                            <u>Nama Pelatihan:</u>
                            <ul style="list-style-type: none; padding: 0; margin-top: 5px;">
                                <?php
                                $pelatihan_ditampilkan = [];
                                foreach ($evaluasi_data as $row_evaluasi) {
                                    $pelatihan_key = $row_evaluasi['kategori_program'] . " : " . $row_evaluasi["nama_pelatihan"];
                                    if (!in_array($pelatihan_key, $pelatihan_ditampilkan)) {
                                        echo "<li>- " . getKategoriProgramText($row_evaluasi['kategori_program']) . " : " . $row_evaluasi["nama_pelatihan"] . "</li>";
                                        $pelatihan_ditampilkan[] = $pelatihan_key;
                                    }
                                }
                                ?>
                            </ul>
                        </h2>

                        <h2 style="text-align: center; margin-top: 20px;">
                            <u>Nama Trainer:
                                <?php
                                if (!empty($id_trainer)) {
                                    $query_trainer_by_id = "SELECT nama_trainer FROM tbl_trainer WHERE id_trainer = '$id_trainer'";
                                    $result_trainer_by_id = mysqli_query($conn, $query_trainer_by_id);

                                    if (mysqli_num_rows($result_trainer_by_id) > 0) {
                                        $row_trainer_by_id = mysqli_fetch_assoc($result_trainer_by_id);
                                        echo $row_trainer_by_id['nama_trainer'];
                                    } else {
                                        echo "Nama trainer tidak ditemukan.";
                                    }
                                } else {
                                    $query_trainer_by_pelatihan = "SELECT DISTINCT T.nama_trainer 
                                          FROM tbl_trainer T 
                                          JOIN tbl_pelatihan P ON T.id_trainer = P.id_trainer 
                                          WHERE P.id_pelatihan = '$id_pelatihan'";
                                    $result_trainer_by_pelatihan = mysqli_query($conn, $query_trainer_by_pelatihan);

                                    if (mysqli_num_rows($result_trainer_by_pelatihan) > 0) {
                                        $row_trainer_by_pelatihan = mysqli_fetch_assoc($result_trainer_by_pelatihan);
                                        echo $row_trainer_by_pelatihan['nama_trainer'];
                                    } else {
                                        echo "Nama trainer tidak ditemukan.";
                                    }
                                }
                                ?>
                            </u>
                        </h2>

                        <!-- Tabel Rata-Rata Penilaian -->
                        <table style="width: 100%; border-collapse: collapse; margin-top: 50px;">
                            <tr>
                                <th style="border: 1px solid #000; padding: 10px; text-align: center;">Kriteria</th>
                                <th style="border: 1px solid #000; padding: 10px; text-align: center;">Rata-Rata Nilai</th>
                                <th style="border: 1px solid #000; padding: 10px; text-align: center;">Keterangan</th>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;">Rating Penguasaan Materi</td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo number_format($avg_data['avg_penguasaan'], 2); ?></td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo beriKeterangan($avg_data['avg_penguasaan'], 'penguasaan'); ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;">Rating Metode Pengajaran</td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo number_format($avg_data['avg_metode'], 2); ?></td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo beriKeterangan($avg_data['avg_metode'], 'metode'); ?></td>
                            </tr>
                            <tr>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;">Rating Interaksi</td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo number_format($avg_data['avg_interaksi'], 2); ?></td>
                                <td style="border: 1px solid #000; padding: 10px; text-align: center;"><?php echo beriKeterangan($avg_data['avg_interaksi'], 'interaksi'); ?></td>
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
                                            <th>Rating Penguasaan Materi</th>
                                            <th>Rating Metode Pengajaran</th>
                                            <th>Rating Interaksi</th>
                                            <th>Feedback</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (count($evaluasi_data) > 0) {
                                            $no = $mulai + 1;
                                            foreach ($evaluasi_data as $row_evaluasi) { ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $row_evaluasi["nama_peserta"]; ?></td>
                                                    <td>
                                                        <?php
                                                        $tgl_input = $row_evaluasi["tgl_input_evaluasi_trainer"];
                                                        $timestamp = strtotime($tgl_input);
                                                        $bulan = date("n", $timestamp);
                                                        $tahun = date("Y", $timestamp);
                                                        $tanggal = date("j", $timestamp);
                                                        $jam = date("H:i:s", $timestamp);
                                                        echo sprintf("%02d %s %d %s", $tanggal, getBulanIndonesia($bulan), $tahun, $jam);
                                                        ?>
                                                    </td>
                                                    <td><?php echo $row_evaluasi["rating_penguasaan_materi"]; ?></td>
                                                    <td><?php echo $row_evaluasi["rating_metode_pengajaran"]; ?></td>
                                                    <td><?php echo $row_evaluasi["rating_interaksi"]; ?></td>
                                                    <td><?php echo $row_evaluasi["feedback"]; ?></td>
                                                </tr>
                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td colspan="7">Tidak ada data evaluasi yang ditemukan.</td>
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