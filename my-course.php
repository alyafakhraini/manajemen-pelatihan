<?php
session_start();
include "koneksi.php";

$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
$id_peserta = isset($_SESSION['id_peserta']) ? $_SESSION['id_peserta'] : null;

if ($id_peserta == null) {
    header("Location: login.php");
    exit();
}

// Ambil nama peserta dari tabel tbl_peserta
$query_nama_peserta = "SELECT nama_peserta FROM tbl_peserta WHERE id_peserta = $id_peserta";
$result_nama_peserta = mysqli_query($conn, $query_nama_peserta);

if ($result_nama_peserta) {
    $row_nama_peserta = mysqli_fetch_assoc($result_nama_peserta);
    $nama_peserta = htmlspecialchars($row_nama_peserta['nama_peserta']);
} else {
    $nama_peserta = "Nama peserta tidak ditemukan";
}

$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

$query_daftar = "SELECT D.id_pendaftaran, C.id_peserta, P.id_pelatihan, P.nama_pelatihan, P.tgl_pelatihan,
                        P.kategori_program, P.waktu, T.nama_trainer, C.nama_peserta, H.status_kehadiran,
                        D.tgl_daftar, D.status_pembayaran
                FROM tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C, tbl_trainer T, tbl_kehadiran H
                WHERE H.id_pendaftaran = D.id_pendaftaran
                AND D.id_pelatihan = P.id_pelatihan
                AND D.id_peserta = C.id_peserta
                AND P.id_trainer = T.id_trainer
                AND D.id_peserta = $id_peserta";

if (!empty($search_query)) {
    $search_query = mysqli_real_escape_string($conn, $search_query);
    $query_daftar .= " AND P.nama_pelatihan LIKE '%$search_query%'";
}

$result = mysqli_query($conn, $query_daftar);

$query_peserta = "SELECT id_peserta FROM tbl_peserta";
$result_peserta = mysqli_query($conn, $query_peserta);
$row_peserta = mysqli_fetch_assoc($result);

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="image/bcti_logo.png" type="image/png" />
    <title>Pelatihan Saya</title>
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
            vertical-align: middle;
            word-wrap: break-word;
            padding: 20px;
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
                            <h2>Pelatihan Saya</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="my-course.php">Pelatihan Saya</a>
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
                        <h2 class="mb-3">Pelatihan Saya</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <?php $row_daftar = mysqli_fetch_assoc($result); ?>
                        <h2 class="title">Pelatihan Saya - <?php echo $nama_peserta; ?> </h2>

                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3">
                            <input type="hidden" name="id_pelatihan" value="<?php echo $id_pelatihan; ?>">
                            <div class="input-group">
                                <input type="text" name="search_query" class="form-control" placeholder="Search..." value="<?php if (isset($_GET['search_query'])) echo htmlspecialchars($_GET['search_query']); ?>">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <?php if (mysqli_num_rows($result) > 0) { ?>
                                <table class="table table-striped table-centered" height="auto">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelatihan</th>
                                            <th>Nama Trainer</th>
                                            <th>Tanggal & Waktu Pelatihan</th>
                                            <th>Waktu Pendaftaran</th>
                                            <th>Status Pembayaran</th>
                                            <th>ID Card</th>
                                            <th>Pre-Test</th>
                                            <th>Status Kehadiran</th>
                                            <th>Materi</th>
                                            <th>Post-Test</th>
                                            <th>Performa</th>
                                            <th>Evaluasi Pelatihan</th>
                                            <th>Evaluasi Trainer</th>
                                            <th>Sertifikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        mysqli_data_seek($result, 0);
                                        $no = 1;
                                        while ($row_daftar = mysqli_fetch_assoc($result)) {
                                            $id_pelatihan = $row_daftar['id_pelatihan'];
                                            $id_peserta = $row_daftar['id_peserta'];
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo htmlspecialchars(getKategoriProgramText($row_daftar['kategori_program']) . " : " . $row_daftar["nama_pelatihan"]); ?></td>
                                                <td><?php echo htmlspecialchars($row_daftar["nama_trainer"]); ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($row_daftar["tgl_pelatihan"]) && isset($row_daftar["waktu"])) {
                                                        $timestamp = strtotime($row_daftar["tgl_pelatihan"]);
                                                        $tanggal = date("j", $timestamp);
                                                        $bulan = date("n", $timestamp);
                                                        $tahun = date("Y", $timestamp);
                                                        $waktu = htmlspecialchars($row_daftar["waktu"]);
                                                        echo sprintf("%02d %s %d (%s)", $tanggal, getBulanIndonesia($bulan), $tahun, $waktu);
                                                    } else {
                                                        echo "Tanggal dan waktu tidak tersedia";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if (isset($row_daftar["tgl_daftar"])) {
                                                        $tgl_daftar = $row_daftar["tgl_daftar"];
                                                        $timestamp = strtotime($tgl_daftar);
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

                                                <!-- button konfirm pembayaran, dan kwitansi -->
                                                <td>
                                                    <?php
                                                    $id_pelatihan = $row_daftar["id_pelatihan"];
                                                    $id_peserta = $row_daftar["id_peserta"];

                                                    if ($row_daftar["status_pembayaran"] == "confirmed") {
                                                    ?>
                                                        <a href="print-kwitansi.php?id_pelatihan=<?= $id_pelatihan; ?>&id_peserta=<?= $id_peserta; ?>" target="_blank" class="btn btn-sm btn-success">Confirmed</a>
                                                        <?php
                                                    } elseif ($row_daftar["status_pembayaran"] == "failed") {
                                                        // Mencari id_pendaftaran dari tbl_pendaftaran
                                                        $query_id_pendaftaran = "SELECT id_pendaftaran FROM tbl_pendaftaran WHERE id_pelatihan = $id_pelatihan AND id_peserta = $id_peserta";
                                                        $result_id_pendaftaran = mysqli_query($conn, $query_id_pendaftaran);

                                                        if ($row_id_pendaftaran = mysqli_fetch_assoc($result_id_pendaftaran)) {
                                                            $id_pendaftaran = $row_id_pendaftaran["id_pendaftaran"];
                                                        ?>
                                                            <a href="edit-form-pendaftaran.php?id_pendaftaran=<?php echo $id_pendaftaran; ?>" class="btn btn-sm btn-danger">Edit Form Pendaftaran</a>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <span class="btn btn-sm btn-warning">Data tidak ditemukan</span>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <span class="btn btn-sm btn-warning">Pending</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>

                                                <!-- ID CARD -->
                                                <td>
                                                    <?php
                                                    $id_pelatihan = $row_daftar["id_pelatihan"];
                                                    $id_peserta = $row_daftar["id_peserta"];

                                                    if ($row_daftar["status_pembayaran"] == "confirmed") {
                                                        echo '<a href="print-idcard.php?id_pelatihan=' . $id_pelatihan . '&id_peserta=' . $id_peserta . '" target="_blank">Lihat ID Card</a>';
                                                    } else {
                                                        echo '<span class="btn btn-sm btn-warning">Belum Tersedia</span>';
                                                    }
                                                    ?>
                                                </td>

                                                <!-- PRE-TEST -->
                                                <td>
                                                    <?php
                                                    if ($row_daftar["status_pembayaran"] == "confirmed") {
                                                        $id_pelatihan = $row_daftar["id_pelatihan"];
                                                        $id_peserta = $row_daftar["id_peserta"];

                                                        // Query untuk cek apakah pre-test sudah diisi peserta
                                                        $query_pre = "SELECT * FROM tbl_pretest WHERE id_peserta = $id_peserta AND id_pelatihan = $id_pelatihan";
                                                        $result_pre = mysqli_query($conn, $query_pre);

                                                        if (mysqli_num_rows($result_pre) > 0) { ?>
                                                            <span class="btn btn-sm btn-success">Done</span>
                                                        <?php
                                                        } else { ?>
                                                            <a href="tambah-pretest.php?id_pelatihan=<?php echo $id_pelatihan; ?>&id_peserta=<?php echo $id_peserta; ?>" class="btn btn-sm btn-primary">Isi Pre-Test</a>
                                                        <?php
                                                        }
                                                    } else { ?>
                                                        <span class="btn btn-sm btn-warning">Belum tersedia</span>
                                                    <?php } ?>
                                                </td>

                                                <!-- Status Kehadiran -->
                                                <td>
                                                    <?php if (isset($row_daftar["status_kehadiran"])) {
                                                        if ($row_daftar["status_kehadiran"] == "hadir") { ?>
                                                            <span class="btn btn-sm btn-success">Hadir</span>
                                                        <?php } elseif ($row_daftar["status_kehadiran"] == "tidak hadir") { ?>
                                                            <span class="btn btn-sm btn-danger">Tidak Hadir</span>
                                                        <?php } else { ?>
                                                            <span class="btn btn-sm btn-warning">Belum Tersedia</span>
                                                        <?php }
                                                    } else { ?>
                                                        <span class="btn btn-sm btn-warning">Belum Tersedia</span>
                                                    <?php } ?>
                                                </td>

                                                <!-- File MATERI -->
                                                <td>
                                                    <?php
                                                    if ($row_daftar["status_kehadiran"] == "hadir") {
                                                        $id_pelatihan = $row_daftar["id_pelatihan"];

                                                        // Query untuk cek status_post peserta
                                                        $query_materi = "SELECT P.materi
                                                                      FROM tbl_pelatihan P
                                                                      WHERE P.id_pelatihan = $id_pelatihan";
                                                        $result_materi = mysqli_query($conn, $query_materi);

                                                        if ($result_materi) {
                                                            $row_materi = mysqli_fetch_assoc($result_materi);
                                                            if ($row_materi['materi']) {
                                                                echo '<a href="materi/' . $row_materi['materi'] . '" target="_blank">Lihat Materi</a>';
                                                            } else {
                                                                echo '<span>No File</span>';
                                                            }
                                                        } else {
                                                            echo '<span>Error retrieving data</span>';
                                                        }
                                                    }
                                                    ?>
                                                </td>

                                                <!-- POST-TEST -->
                                                <td>
                                                    <?php
                                                    if ($row_daftar["status_kehadiran"] == "hadir") {
                                                        $id_pelatihan = $row_daftar["id_pelatihan"];
                                                        $id_peserta = $row_daftar["id_peserta"];

                                                        // Query untuk cek apakah post-test sudah diisi peserta
                                                        $query_post = "SELECT * FROM tbl_posttest WHERE id_peserta = $id_peserta AND id_pelatihan = $id_pelatihan";
                                                        $result_post = mysqli_query($conn, $query_post);

                                                        if (mysqli_num_rows($result_post) > 0) { ?>
                                                            <span class="btn btn-sm btn-success">Done</span>
                                                        <?php
                                                        } else { ?>
                                                            <a href="tambah-posttest.php?id_pelatihan=<?php echo $id_pelatihan; ?>&id_peserta=<?php echo $id_peserta; ?>" class="btn btn-sm btn-primary">Isi Post-Test</a>
                                                        <?php
                                                        }
                                                    } else { ?>
                                                        <span class="btn btn-sm btn-warning">Belum tersedia</span>
                                                    <?php } ?>
                                                </td>

                                                <!-- report PERFORMA -->
                                                <td>
                                                    <?php
                                                    $id_pelatihan = $row_daftar["id_pelatihan"];
                                                    $id_peserta = $row_daftar["id_peserta"];

                                                    if ($row_daftar["status_kehadiran"] == "hadir") {
                                                        echo '<a href="print-performa-peserta.php?id_pelatihan=' . $id_pelatihan . '&id_peserta=' . $id_peserta . '" target="_blank">Lihat Performa</a>';
                                                    } else {
                                                        echo '<span class="btn btn-sm btn-warning">Belum Tersedia</span>';
                                                    }
                                                    ?>
                                                </td>

                                                <!-- EVALUASI PELATIHAN -->
                                                <td>
                                                    <?php
                                                    if ($row_daftar["status_kehadiran"] == "hadir") {
                                                        $id_pelatihan = $row_daftar["id_pelatihan"];
                                                        $id_peserta = $row_daftar["id_peserta"];

                                                        // Query untuk cek apakah sudah ada evaluasi pelatihan peserta
                                                        $query_evalpel = "SELECT * FROM tbl_evaluasi_pelatihan WHERE id_peserta = $id_peserta AND id_pelatihan = $id_pelatihan";
                                                        $result_evalpel = mysqli_query($conn, $query_evalpel);

                                                        if (mysqli_num_rows($result_evalpel) > 0) {
                                                    ?>
                                                            <span class="btn btn-sm btn-success">Done</span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="tambah-evaluasi-pelatihan.php?id_pelatihan=<?php echo $id_pelatihan; ?>&id_peserta=<?php echo $id_peserta; ?>" class="btn btn-sm btn-primary">Isi Evaluasi</a>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <span class="btn btn-sm btn-warning">Belum tersedia</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>

                                                <!-- EVALUASI TRAINER -->
                                                <td>
                                                    <?php
                                                    if ($row_daftar["status_kehadiran"] == "hadir") {
                                                        $id_pelatihan = $row_daftar["id_pelatihan"];
                                                        $id_peserta = $row_daftar["id_peserta"];

                                                        // Query untuk cek apakah sudah ada evaluasi trainer peserta
                                                        $query_eval = "SELECT * FROM tbl_evaluasi_trainer WHERE id_peserta = $id_peserta AND id_pelatihan = $id_pelatihan";
                                                        $result_eval = mysqli_query($conn, $query_eval);

                                                        if (mysqli_num_rows($result_eval) > 0) {
                                                    ?>
                                                            <span class="btn btn-sm btn-success">Done</span>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <a href="tambah-evaluasi-trainer.php?id_pelatihan=<?php echo $id_pelatihan; ?>&id_peserta=<?php echo $id_peserta; ?>" class="btn btn-sm btn-primary">Isi Evaluasi</a>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <span class="btn btn-sm btn-warning">Belum tersedia</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>

                                                <!-- SERTIFIKAT -->
                                                <td>
                                                    <?php
                                                    $id_pelatihan = $row_daftar["id_pelatihan"];
                                                    $id_peserta = $row_daftar["id_peserta"];

                                                    // Query untuk cek apakah post-test sudah done
                                                    $query_post_test = "SELECT * FROM tbl_posttest WHERE id_peserta = $id_peserta AND id_pelatihan = $id_pelatihan";
                                                    $result_post_test = mysqli_query($conn, $query_post_test);

                                                    // Query untuk cek apakah evaluasi pelatihan sudah terisi
                                                    $query_eval_pelatihan = "SELECT * FROM tbl_evaluasi_pelatihan WHERE id_peserta = $id_peserta AND id_pelatihan = $id_pelatihan";
                                                    $result_eval_pelatihan = mysqli_query($conn, $query_eval_pelatihan);

                                                    // Query untuk cek apakah evaluasi trainer sudah terisi
                                                    $query_eval_trainer = "SELECT * FROM tbl_evaluasi_trainer WHERE id_peserta = $id_peserta AND id_pelatihan = $id_pelatihan";
                                                    $result_eval_trainer = mysqli_query($conn, $query_eval_trainer);

                                                    // Cek apakah semua syarat terpenuhi
                                                    if (mysqli_num_rows($result_post_test) > 0 && mysqli_num_rows($result_eval_pelatihan) > 0 && mysqli_num_rows($result_eval_trainer) > 0) { ?>
                                                        <a href="print-sertifikat.php?id_pelatihan=<?php echo $id_pelatihan; ?>&id_peserta=<?php echo $id_peserta; ?>" class="btn btn-sm btn-success" target="_blank">Cetak Sertifikat</a>
                                                    <?php } else { ?>
                                                        <span class="btn btn-sm btn-warning">Belum tersedia</span>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } ?>

                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <div class="alert alert-info text-center" role="alert">
                                    Belum ada pelatihan yang terdaftar.
                                </div>
                            <?php } ?>
                        </div>

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