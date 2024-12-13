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

$total_records = 0;
$result_pelatihan = false;
$result_agenda = false;

if (isset($_GET["bulan"]) && isset($_GET["tahun"])) {

    $bulan = $_GET["bulan"];
    $tahun = $_GET["tahun"];
    $bulanan = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '%';

    $result_total_pelatihan = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                   FROM tbl_pelatihan
                                                   WHERE tgl_pelatihan LIKE '$bulanan'");
    $result_total_agenda = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                FROM tbl_agenda
                                                WHERE tgl_agenda LIKE '$bulanan'");

    $total_pelatihan = mysqli_fetch_assoc($result_total_pelatihan)['total'];
    $total_agenda = mysqli_fetch_assoc($result_total_agenda)['total'];
    $total_records = $total_pelatihan + $total_agenda;

    $result_pelatihan = mysqli_query($conn, "SELECT *, 'pelatihan' AS tipe
                                             FROM tbl_pelatihan
                                             WHERE tgl_pelatihan LIKE '$bulanan'");
    $result_agenda = mysqli_query($conn, "SELECT *, 'agenda' AS tipe
                                          FROM tbl_agenda
                                          WHERE tgl_agenda LIKE '$bulanan'  ");
}

$rows_pelatihan = [];
$rows_agenda = [];
if ($result_pelatihan) $rows_pelatihan = mysqli_fetch_all($result_pelatihan, MYSQLI_ASSOC);
if ($result_agenda) $rows_agenda = mysqli_fetch_all($result_agenda, MYSQLI_ASSOC);

$rows = array_merge($rows_pelatihan, $rows_agenda);
usort($rows, function ($a, $b) {
    return strtotime($a['tgl_pelatihan'] ?? $a['tgl_agenda']) <=> strtotime($b['tgl_pelatihan'] ?? $b['tgl_agenda']);
});

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
    <title>Laporan Jadwal Pelatihan & Agenda BCTI Per Bulan</title>
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
                                Jadwal Pelatihan & Agenda BCTI Bulan <?php echo getBulanIndonesia($bulan) . " " . $tahun; ?>
                            </u>
                        </h1>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th> Tanggal </th>
                                            <th> Nama Acara </th>
                                            <th> Deskripsi </th>
                                            <th> Tempat </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($rows as $row) {
                                            $tanggal = date("d", strtotime($row["tgl_pelatihan"] ?? $row["tgl_agenda"])) . " " . getBulanIndonesia(date("n", strtotime($row["tgl_pelatihan"] ?? $row["tgl_agenda"]))) . " " . date("Y", strtotime($row["tgl_pelatihan"] ?? $row["tgl_agenda"]));
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $tanggal; ?></td>
                                                <td><?php echo $row["nama_pelatihan"] ?? $row["nama_agenda"]; ?></td>
                                                <td><?php echo $row["deskripsi"] ?? "-"; ?></td>
                                                <td><?php echo $row["tempat"] ?? $row["tujuan_tempat"]; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
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