<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["id_pelatihan"]) & isset($_GET["id_peserta"])) {

    $id_pelatihan = $_GET["id_pelatihan"];
    $id_peserta = $_GET["id_peserta"];

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

    $result_performa = mysqli_query($conn, "SELECT C.nama_peserta, H.nilai, H.saran
                                           FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                                           WHERE H.id_pendaftaran = D.id_pendaftaran
                                           AND D.id_pelatihan = P.id_pelatihan
                                           AND D.id_peserta = C.id_peserta
                                           AND D.id_pelatihan = '$id_pelatihan' 
                                           AND D.id_peserta ='$id_peserta'
                                           AND D.status_pembayaran = 'confirmed' 
                                           AND H.status_kehadiran = 'hadir'");

    // Ambil data pre-test
    $query_pretest = mysqli_query($conn, "SELECT jawaban1, jawaban2, jawaban3, jawaban4, jawaban5 FROM tbl_pretest WHERE id_pelatihan = '$id_pelatihan' AND id_peserta = '$id_peserta'");
    $data_pretest = mysqli_fetch_assoc($query_pretest);

    // Ambil data post-test
    $query_posttest = mysqli_query($conn, "SELECT jawaban1, jawaban2, jawaban3, jawaban4, jawaban5 FROM tbl_posttest WHERE id_pelatihan = '$id_pelatihan' AND id_peserta = '$id_peserta'");
    $data_posttest = mysqli_fetch_assoc($query_posttest);

    // Fungsi untuk menghitung nilai
    function hitungNilai($data_test)
    {
        if ($data_test) {
            $total = $data_test['jawaban1'] + $data_test['jawaban2'] + $data_test['jawaban3'] + $data_test['jawaban4'] + $data_test['jawaban5'];
            $rata_rata = $total / 5;
            $nilai = ($rata_rata / 5) * 100; // Skala 100
            return round($nilai);
        } else {
            return null;
        }
    }

    // Hitung nilai pre-test dan post-test
    $nilai_pretest = hitungNilai($data_pretest);
    $nilai_posttest = hitungNilai($data_posttest);

    // Hitung peningkatan dan keterangan
    if ($nilai_pretest !== null && $nilai_posttest !== null) {
        $peningkatan = $nilai_posttest - $nilai_pretest;

        // Hitung persentase peningkatan
        $persentase_peningkatan = round((($peningkatan / $nilai_pretest) * 100), 0);

        // Tentukan keterangan berdasarkan persentase peningkatan atau penurunan
        if ($persentase_peningkatan > 0) {
            if ($persentase_peningkatan > 20) {
                $keterangan = "Peningkatan Signifikan sebesar $persentase_peningkatan%";
            } elseif ($persentase_peningkatan > 10) {
                $keterangan = "Peningkatan Sedang sebesar $persentase_peningkatan%";
            } else {
                $keterangan = "Peningkatan Sedikit sebesar $persentase_peningkatan%";
            }
        } elseif ($persentase_peningkatan < 0) {
            $keterangan = "Penurunan sebesar " . abs($persentase_peningkatan) . "%";
        } else {
            $keterangan = "Tidak ada perubahan nilai";
        }
    } else {
        $peningkatan = null;
        $keterangan = "Data tidak lengkap";
    }
} else {
    $result_performa = false;
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
    <title>Laporan Performa Peserta</title>
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
                        <div class="row">
                            <div class="col-12">
                                <?php $row_performa = mysqli_fetch_assoc($result_performa) ?>
                                <h2 style="text-align: center; margin-top: 50px;">
                                    <u>Laporan Performa <?php echo $kategori_program_text . ': ' . $nama_pelatihan; ?></u>
                                </h2>

                                <h2 style="text-align: center; margin-top: 10px;">
                                    <u>Nama Peserta: <?php echo $row_performa["nama_peserta"]; ?></u>
                                </h2>

                                <h3 style="text-align: center; margin-top: 70px;">
                                    Hasil Penilaian dari Trainer
                                </h3>
                                <table width="100%" style="border-collapse: collapse; margin-top: 10px;">
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #000; width: 30%; font-weight: bold;">Penilai</td>
                                        <td style="padding: 10px; border: 1px solid #000; width: 70%;"><?php echo $nama_trainer; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #000; font-weight: bold;">Nilai</td>
                                        <td style="padding: 10px; border: 1px solid #000;"><?php echo $row_performa["nilai"]; ?></td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #000; font-weight: bold;">Saran</td>
                                        <td style="padding: 10px; border: 1px solid #000;"><?php echo $row_performa["saran"]; ?></td>
                                    </tr>
                                </table>

                                <h3 style="text-align: center; margin-top: 60px;">
                                    Hasil Penilaian Pre-Test & Post Test
                                </h3>
                                <table width="100%" style="border-collapse: collapse; margin-top: 10px;">
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #000; width: 30%; font-weight: bold;">Nilai Hasil Pre-Test</td>
                                        <td style="padding: 10px; border: 1px solid #000; width: 70%;">
                                            <?php
                                            if ($nilai_pretest !== null) {
                                                echo number_format($nilai_pretest, 2);
                                            } else {
                                                echo "Belum mengisi Pre-Test";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #000; font-weight: bold;">Nilai Hasil Post-Test</td>
                                        <td style="padding: 10px; border: 1px solid #000;">
                                            <?php
                                            if ($nilai_posttest !== null) {
                                                echo number_format($nilai_posttest, 2);
                                            } else {
                                                echo "Belum mengisi Post-Test";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 10px; border: 1px solid #000; font-weight: bold;">Keterangan</td>
                                        <td style="padding: 10px; border: 1px solid #000;"><?php echo $keterangan; ?></td>
                                    </tr>
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