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

if (isset($_GET["bulan"]) && isset($_GET["tahun"])) {

    $bulan = $_GET["bulan"];
    $tahun = $_GET["tahun"];
    $bulanan = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '%';

    $result_total = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                   FROM tbl_pengaduan
                                                   WHERE tgl_pengaduan LIKE '$bulanan'");

    $total_records = mysqli_fetch_assoc($result_total)['total'];

    $result_pengaduan = mysqli_query($conn, "SELECT C.nama_peserta, P.tgl_pengaduan, P.isi_pengaduan, P.status_pengaduan
                                            FROM tbl_pengaduan P, tbl_peserta C
                                            WHERE P.id_peserta = C.id_peserta
                                            AND P.tgl_pengaduan LIKE '$bulanan'");
} else {
    $total_records = 0;
    $result_pengaduan = false;
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
    <title>Laporan Pengaduan Per Bulan</title>
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
                        <h1 style="text-align: center; margin-top: 40px;">
                            <u>
                                Laporan Pengaduan Bulan <?php echo getBulanIndonesia($bulan) . " " . $tahun; ?>
                            </u>
                        </h1>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th> Tanggal </th>
                                            <th> Nama Peserta </th>
                                            <th> Isi Pengaduan </th>
                                            <th> Status Pengaduan </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_pengaduan = mysqli_fetch_assoc($result_pengaduan)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($row_pengaduan["tgl_pengaduan"])) {
                                                        $tgl_pengaduan = $row_pengaduan["tgl_pengaduan"];
                                                        $timestamp = strtotime($tgl_pengaduan);
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
                                                <td><?php echo $row_pengaduan["nama_peserta"]; ?></td>
                                                <td><?php echo $row_pengaduan["isi_pengaduan"]; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row_pengaduan["status_pengaduan"] == "done") { //kategori 1 (Level Up)
                                                        echo "<div class='btn btn-sm btn-success'>Sudah Ditanggapi</div>";
                                                    } else if ($row_pengaduan["status_pengaduan"] == "") { //kategori 2 (PSC)
                                                        echo "<div class='btn btn-sm btn-warning'>Menunggu Tanggapan</div>";
                                                    }
                                                    ?>
                                                </td>
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