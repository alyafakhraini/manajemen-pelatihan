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

if (isset($_GET["keahlian"])) {
    $keahlian = $_GET["keahlian"];
    // Menghitung total record
    $result_total = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_trainer WHERE keahlian = '$keahlian'");
    $total_records = mysqli_fetch_assoc($result_total)['total'];

    $result_trainer = mysqli_query($conn, "SELECT * FROM tbl_trainer WHERE keahlian = '$keahlian'");
} else {
    $total_records = 0;
    $result_trainer = false;
}

function getBulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    return $bulanIndo[$bulan];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Daftar Trainer</title>
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
                            <u>
                                Daftar Trainer <?php echo htmlspecialchars($keahlian); ?>
                            </u>
                        </h2>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Trainer</th>
                                            <th>Sertifikasi</th>
                                            <th>Keahlian</th>
                                            <th>NPWP</th>
                                            <th>Fee</th>
                                            <th>Kontak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_trainer = mysqli_fetch_assoc($result_trainer)) { ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row_trainer["nama_trainer"]; ?></td>
                                                <td><?php echo $row_trainer["sertifikasi"]; ?></td>
                                                <td><?php echo $row_trainer["keahlian"]; ?></td>
                                                <td><?php echo $row_trainer["npwp_trainer"]; ?></td>
                                                <td class="text-right"><?php echo 'Rp. ' . number_format($row_trainer["fee_trainer"], 0, ',', '.') . ',-'; ?></td>
                                                <td><?php echo $row_trainer["kontak_trainer"]; ?></td>
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
                        <br><br><br><br><br><br>
                        <center><b>Muhammad Zain Mahbuby, B.Eng. (Hons) CETP, CLMA.</b></center>
                        <center>Koordinator BCTI</center>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>