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

    $result_total = mysqli_query($conn, "SELECT COUNT(*) AS total
                                         FROM tbl_pendaftaran
                                         WHERE id_pelatihan = '$id_pelatihan'
                                         AND status_pembayaran = 'confirmed'");
    $total_records = mysqli_fetch_assoc($result_total)['total'];

    $result_daftar = mysqli_query($conn, "SELECT C.nama_peserta, C.telp_peserta, C.domisili, C.status_peserta, C.gender 
                                           FROM tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                                           WHERE D.id_pelatihan = P.id_pelatihan 
                                           AND D.id_peserta = C.id_peserta
                                           AND D.id_pelatihan = '$id_pelatihan' 
                                           AND D.status_pembayaran = 'confirmed'  ");
} else {
    $total_records = 0;
    $result_daftar = false;
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
    <title>Laporan Data Pendaftar</title>
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
                            <u>Data Pendaftar Pelatihan <?php echo $kategori_program_text . ': ' . $nama_pelatihan; ?></u>
                        </h2>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th> No </th>
                                            <th> Nama Peserta </th>
                                            <th> Gender </th>
                                            <th> Domisili </th>
                                            <th> Status </th>
                                            <th> Kontak </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_daftar = mysqli_fetch_assoc($result_daftar)) { ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $row_daftar["nama_peserta"]; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row_daftar["gender"] == "lk") { // 1 (laki-laki)
                                                        echo "<div class='btn btn-sm btn-secondary'>Laki-laki</div>";
                                                    } else if ($row_daftar["gender"] == "pr") { //2 (perempuan)
                                                        echo "<div class='btn btn-sm btn-success'>Perempuan</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $row_daftar["domisili"]; ?></td>
                                                <td><?php echo $row_daftar["status_peserta"]; ?></td>
                                                <td><?php echo $row_daftar["telp_peserta"]; ?></td>
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