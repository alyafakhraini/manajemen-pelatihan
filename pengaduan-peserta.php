<?php
session_start();
include "koneksi.php";

$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
$id_peserta = isset($_SESSION['id_peserta']) ? $_SESSION['id_peserta'] : null;

if ($id_peserta == null) {
    header("Location: login.php");
    exit();
}

// Ambil nama peserta berdasarkan id_peserta
$query_nama_peserta = "SELECT nama_peserta FROM tbl_peserta WHERE id_peserta = '$id_peserta'";
$result_nama_peserta = mysqli_query($conn, $query_nama_peserta);
$nama_peserta = '';
if ($result_nama_peserta && mysqli_num_rows($result_nama_peserta) > 0) {
    $row_nama_peserta = mysqli_fetch_assoc($result_nama_peserta);
    $nama_peserta = $row_nama_peserta['nama_peserta'];
}

$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

$query = "SELECT pengaduan.*, peserta.nama_peserta
            FROM tbl_pengaduan AS pengaduan
            JOIN tbl_peserta AS peserta ON pengaduan.id_peserta = peserta.id_peserta
            WHERE pengaduan.id_peserta = $id_peserta";

$result = mysqli_query($conn, $query);

function getBulanIndonesia($bulan)
{
    $bulanIndonesia = [
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
    return $bulanIndonesia[$bulan];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="image/bcti_logo.png" type="image/png" />
    <title>Data Pengaduan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="assets/css/style.css" /> <!-- css dashboard -->
    <style>
        .table-centered th,
        .table-centered td {
            text-align: center;
        }
    </style>
</head>

<body>
    <!--================ Start Header Menu Area =================-->
    <?php include "header.php"; ?>
    <!--================ End Header Menu Area =================-->


    <!--================Home Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="banner_content text-center">
                            <h2>Data Pengaduan</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="pengaduan-peserta.php">Form Pengaduan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================ Start Course Details Area =================-->
    <section class="course_details_area section_gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3">Data Pengaduan</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="title">Data Pengaduan <?php echo $nama_peserta ?></h2>

                        <a href="tambah-pengaduan.php" class="btn btn-outline-primary btn-fw mb-3">Tambah Pengaduan</a>
                        <div class="table-responsive">
                            <table class="table table-striped table-centered" height="auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Isi Pengaduan</th>
                                        <th>Status Pengaduan</th>
                                        <th>Tanggapan Admin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($row["tgl_pengaduan"])) {
                                                        $tgl_pengaduan = $row["tgl_pengaduan"];
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
                                                <td><?php echo $row["isi_pengaduan"]; ?></td>
                                                <td>
                                                    <?php if ($row["status_pengaduan"] == "") { ?>
                                                        <span class="btn btn-sm btn-warning">Sedang Ditangani</span>
                                                    <?php } elseif ($row["status_pengaduan"] == "done") { ?>
                                                        <span class="btn btn-sm btn-success">Done</span>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $row["tanggapan_admin"]; ?></td>
                                            </tr>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="5">
                                                <div class="alert alert-info text-center" role="alert">
                                                    Belum ada data pengaduan yang ditemukan.
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!--================ End Course Details Area =================-->

    <!--================ Start footer Area  =================-->
    <?php include "footer.php"; ?>
    <!--================ End footer Area  =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/owl-carousel-thumb.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/mail-script.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=API_KEY"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>