<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET["id_pendaftaran"])) {
    $id_pendaftaran = $_GET["id_pendaftaran"];

    // Ambil informasi peserta dan pelatihan berdasarkan id_pendaftaran
    $query_pendaftaran = mysqli_query($conn, "SELECT D.id_pelatihan, D.id_peserta, D.tgl_daftar, D.metode_pembayaran, D.jml_pembayaran, D.status_pembayaran, C.nama_peserta, C.email
                                               FROM tbl_pendaftaran D
                                               JOIN tbl_peserta C ON D.id_peserta = C.id_peserta
                                               WHERE D.id_pendaftaran = '$id_pendaftaran'");

    if ($query_pendaftaran && mysqli_num_rows($query_pendaftaran) > 0) {
        $row_performa = mysqli_fetch_assoc($query_pendaftaran);
        $id_pelatihan = $row_performa["id_pelatihan"];
        $id_peserta = $row_performa["id_peserta"];

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
    } else {
        $row_performa = false;
        $nama_pelatihan = "";
    }
} else {
    $row_performa = false;
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

function terbilang($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";

    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } elseif ($nilai < 20) {
        $temp = terbilang($nilai - 10) . " Belas";
    } elseif ($nilai < 100) {
        $temp = terbilang($nilai / 10) . " Puluh" . terbilang($nilai % 10);
    } elseif ($nilai < 200) {
        $temp = " Seratus" . terbilang($nilai - 100);
    } elseif ($nilai < 1000) {
        $temp = terbilang($nilai / 100) . " Ratus" . terbilang($nilai % 100);
    } elseif ($nilai < 2000) {
        $temp = " Seribu" . terbilang($nilai - 1000);
    } elseif ($nilai < 1000000) {
        $temp = terbilang($nilai / 1000) . " Ribu" . terbilang($nilai % 1000);
    } elseif ($nilai < 1000000000) {
        $temp = terbilang($nilai / 1000000) . " Juta" . terbilang($nilai % 1000000);
    }

    return $temp;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Kwitansi Pembayaran Pelatihan</title>
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

        .receipt-container {
            max-width: 700px;
            margin: 0 auto;
            padding: 50px;
            border: 1px solid #333;
            font-family: Arial, sans-serif;
            background-color: #fff;
            position: relative;
        }

        .title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .receipt-content {
            padding: 20px;
            border: 1px solid #000;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-table td {
            padding: 8px 0;
            font-size: 16px;
            font-weight: normal;
            vertical-align: top;
        }

        .receipt-table td:first-child {
            width: 200px;
        }

        .ttd {
            display: flex;
            height: 15%;
            width: 50%;
            margin-top: auto;
            background-color: rgb(255, 255, 255);
            justify-content: center;
            align-items: center;
            padding-top: 30px;
            padding-left: 300px;
            padding-bottom: 10px;
        }

        @media print {
            .receipt-container {
                border: none;
            }
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
                        <div class="receipt-container">
                            <?php if ($row_performa): ?>
                                <div class="receipt-content">
                                    <table class="receipt-table">
                                        <h2 class="title"><u>KWITANSI PEMBAYARAN PELATIHAN</u></h2>
                                        <tr>
                                            <td>Sudah diterima dari</td>
                                            <td>: <b><?php echo $row_performa["nama_peserta"]; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah Uang</td>
                                            <td>: <b><?php echo 'Rp. ' . number_format($row_performa["jml_pembayaran"], 0, ',', '.') . ',-'; ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Terbilang</td>
                                            <td>: <b><?php echo terbilang($row_performa["jml_pembayaran"]); ?> Rupiah</b></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Pembayaran</td>
                                            <td>: <b><?php echo date('d', strtotime($row_performa['tgl_daftar'])) . ' ' . getBulanIndonesia(date('n', strtotime($row_performa['tgl_daftar']))) . ' ' . date('Y', strtotime($row_performa['tgl_daftar'])); ?></b></td>
                                        </tr>
                                        <tr>
                                            <td>Untuk Pembayaran</td>
                                            <td>: <b>Pendaftaran <?php echo $kategori_program_text; ?>: <?php echo $nama_pelatihan; ?></b></td>
                                        </tr>
                                    </table>

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

                            <?php else: ?>
                                <h2>Data tidak ditemukan</h2>
                            <?php endif; ?>
                        </div>
                    </section>

                </div>

            </div>
        </div>


    </div>

</body>

</html>