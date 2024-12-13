<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'admin') {
    header("Location: access-denied.php");
    exit;
}

$kategori_program = isset($_GET['kategori_program']) ? $_GET['kategori_program'] : '';

// Menetapkan nilai default untuk $kategori_program_text
$kategori_program_text = '';

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

$result = mysqli_query($conn, "SELECT P.nama_pelatihan, P.tgl_pelatihan, P.waktu, P.tempat, T.nama_trainer, P.kategori_program
                        FROM tbl_pelatihan P, tbl_trainer T
                        WHERE P.id_trainer = T.id_trainer
                        AND P.kategori_program = '$kategori_program'
                        ORDER BY P.tgl_pelatihan DESC");
$jml_data = mysqli_num_rows($result);

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
    <title>Laporan Daftar Pelatihan Per Program</title>
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
                        <h2 style="text-align: center; margin-top: 40px;">
                            <u>
                                Daftar Pelatihan Program <?php echo htmlspecialchars($kategori_program_text, ENT_QUOTES, 'UTF-8'); ?>
                            </u>
                        </h2>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pelatihan</th>
                                            <th>Nama Trainer</th>
                                            <th>Tempat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_pelatihan = mysqli_fetch_assoc($result)) {
                                            $tgl_pelatihan = date('d', strtotime($row_pelatihan["tgl_pelatihan"])) . ' ' . getBulanIndonesia(date('n', strtotime($row_pelatihan["tgl_pelatihan"]))) . ' ' . date('Y', strtotime($row_pelatihan["tgl_pelatihan"])) . ' (' . $row_pelatihan["waktu"] . ')';
                                            $nama_pelatihan = $kategori_program_text . ': ' . $row_pelatihan["nama_pelatihan"];
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $tgl_pelatihan; ?></td>
                                                <td><?php echo $nama_pelatihan; ?></td>
                                                <td><?php echo $row_pelatihan["nama_trainer"]; ?></td>
                                                <td><?php echo $row_pelatihan["tempat"]; ?></td>
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