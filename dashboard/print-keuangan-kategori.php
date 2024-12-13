<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'admin') {
    header("Location: ../login.php");
    exit;
}

$total_records = 0;
$result_keuangan = false;
$result_daftar = false;

$id_pelatihan = isset($_GET["id_pelatihan"]) ? $_GET["id_pelatihan"] : '';
$kategori_transaksi = isset($_GET["kategori_transaksi"]) ? $_GET["kategori_transaksi"] : '';

if ($id_pelatihan) {

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

    $total_keuangan = 0;
    $total_daftar = 0;

    // Jika kategori_transaksi adalah 'pendapatan', ambil data dari tbl_pendaftaran
    if ($kategori_transaksi == 'pendapatan') {
        $result_total_daftar = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                    FROM tbl_pendaftaran
                                                    WHERE id_pelatihan = '$id_pelatihan'");
        $total_daftar = mysqli_fetch_assoc($result_total_daftar)['total'];
        $result_daftar = mysqli_query($conn, "SELECT SUM(jml_pembayaran) AS jml_pembayaran, 'daftar' AS tipe
                                              FROM tbl_pendaftaran
                                              WHERE id_pelatihan = '$id_pelatihan'");
        $total_records = $total_daftar;
    }

    // Selalu ambil data dari tbl_keuangan
    $result_total_keuangan = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                   FROM tbl_keuangan
                                                   WHERE id_pelatihan = '$id_pelatihan'
                                                   AND kategori_transaksi = '$kategori_transaksi'");
    $total_keuangan = mysqli_fetch_assoc($result_total_keuangan)['total'];
    $result_keuangan = mysqli_query($conn, "SELECT *, 'keuangan' AS tipe
                                             FROM tbl_keuangan
                                             WHERE id_pelatihan = '$id_pelatihan'
                                             AND kategori_transaksi = '$kategori_transaksi'");

    $total_records += $total_keuangan; // Total records adalah penjumlahan dari total keuangan dan total daftar
}

$rows_keuangan = [];
$rows_daftar = [];
if ($result_keuangan) $rows_keuangan = mysqli_fetch_all($result_keuangan, MYSQLI_ASSOC);
if ($result_daftar) $rows_daftar = mysqli_fetch_all($result_daftar, MYSQLI_ASSOC);

$rows = array_merge($rows_keuangan, $rows_daftar);

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
    <title>Laporan Keuangan Pelatihan</title>
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
                            <u>Laporan <?php echo ucfirst($kategori_transaksi); ?> Keuangan Pelatihan <?php echo $kategori_program_text . ': ' . $nama_pelatihan; ?> </u>
                        </h2>
                        <div class="row">
                            <div class="col-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Kategori Transaksi</th>
                                            <th>Deskripsi</th>
                                            <th>Jumlah Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $jumlah = 0;
                                        $jumlah_pendapatan = 0;
                                        $jumlah_pengeluaran = 0;

                                        foreach ($rows as $row) {
                                            if ($row['tipe'] == 'keuangan') {
                                                $tanggal_transaksi = date("d", strtotime($row["tgl_transaksi"])) . " " . getBulanIndonesia(date("n", strtotime($row["tgl_transaksi"]))) . " " . date("Y", strtotime($row["tgl_transaksi"]));
                                            } else {
                                                $tanggal_transaksi = "";
                                            }

                                            $kategori_transaksi = $row["kategori_transaksi"] ?? "pendapatan";
                                            $jumlah_transaksi = $row["jml_transaksi"] ?? $row["jml_pembayaran"];

                                            if (
                                                $kategori_transaksi == "pendapatan"
                                            ) {
                                                $jumlah_pendapatan += $jumlah_transaksi;
                                            } else if ($kategori_transaksi == "pengeluaran") {
                                                $jumlah_pengeluaran += $jumlah_transaksi;
                                            }

                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $tanggal_transaksi ?? ""; ?></td>
                                                <td>
                                                    <?php
                                                    if ($kategori_transaksi == "pendapatan") {
                                                        echo "<div class='btn btn-sm btn-info'>Pendapatan</div>";
                                                    } else if ($kategori_transaksi == "pengeluaran") {
                                                        echo "<div class='btn btn-sm btn-warning'>Pengeluaran</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $row["deskripsi"] ?? "Total Hasil Pembayaran Pendaftaran"; ?></td>
                                                <td class="text-right"><?php echo 'Rp. ' . number_format($row["jml_transaksi"] ?? $row["jml_pembayaran"], 0, ',', '.') . ',-'; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    <?php if ($kategori_transaksi == "pendapatan" || $kategori_transaksi == "") { ?>
                                        <tr>
                                            <th colspan="4">Total Pendapatan</th>
                                            <th><?php echo 'Rp. ' . number_format($jumlah_pendapatan, 0, ',', '.') . ',-'; ?></th>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($kategori_transaksi == "pengeluaran" || $kategori_transaksi == "") { ?>
                                        <tr>
                                            <th colspan="4">Total Pengeluaran</th>
                                            <th><?php echo 'Rp. ' . number_format($jumlah_pengeluaran, 0, ',', '.') . ',-'; ?></th>
                                        </tr>
                                    <?php } ?>
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