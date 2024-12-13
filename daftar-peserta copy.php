<?php
session_start();
include "koneksi.php";

$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
$id_trainer = isset($_SESSION['id_trainer']) ? $_SESSION['id_trainer'] : null;

if ($id_trainer == null) {
    header("Location: login.php");
    exit();
}

$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

if (isset($_GET["id_pelatihan"])) {
    $id_pelatihan = $_GET["id_pelatihan"];

    $query_pelatihan = mysqli_query($conn, "SELECT nama_pelatihan, kategori_program FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'");
    $pelatihan = mysqli_fetch_assoc($query_pelatihan);
    $nama_pelatihan = $pelatihan['nama_pelatihan'];
    $kategori_program = $pelatihan['kategori_program'];

    $kategori_text = getKategoriProgramText($kategori_program);

    $query = "SELECT H.id_kehadiran, C.nama_peserta, P.id_pelatihan, C.id_peserta, H.nilai, H.saran, H.status_kehadiran
              FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
              WHERE H.id_pendaftaran = D.id_pendaftaran
              AND D.id_pelatihan = P.id_pelatihan
              AND D.id_peserta = C.id_peserta
              AND D.id_pelatihan = '$id_pelatihan' 
              AND D.status_pembayaran = 'confirmed'
              AND H.status_kehadiran = 'hadir'";

    if (!empty($search_query)) {
        $search_query = mysqli_real_escape_string($conn, $search_query);
        $query .= " AND C.nama_peserta LIKE '%$search_query%'";
    }

    $result_presensi = mysqli_query($conn, $query);
} else {
    $result_presensi = false;
    $nama_pelatihan = "";
    $kategori_text = "";
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
    <title>Daftar Peserta: <?php echo htmlspecialchars($nama_pelatihan); ?></title> <!-- Bootstrap CSS -->
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
                            <h2>Daftar Peserta</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="trainer-schedule.php">Trainer Schedule</a>
                                <a href="daftar-peserta.php">Daftar Peserta</a>
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
                        <h2 class="mb-3">Daftar Peserta</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="title">Daftar Peserta - <?php echo htmlspecialchars($kategori_text) . ': ' . htmlspecialchars($nama_pelatihan); ?> </h2>

                        <?php if ($result_presensi && mysqli_num_rows($result_presensi) > 0) { ?>

                            <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3">
                                <input type="hidden" name="id_pelatihan" value="<?php echo $id_pelatihan; ?>">
                                <div class="input-group">
                                    <input type="text" name="search_query" class="form-control" placeholder="Search..." value="<?php if (isset($_GET['search_query'])) echo htmlspecialchars($_GET['search_query']); ?>">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-striped table-centered" height="auto">
                                    <thead>
                                        <tr>
                                            <th> No </th>
                                            <th> Nama Peserta </th>
                                            <th> Nilai </th>
                                            <th> Saran </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        mysqli_data_seek($result_presensi, 0);
                                        $no = 1;
                                        while ($row_presensi = mysqli_fetch_assoc($result_presensi)) {
                                            $id_kehadiran = $row_presensi['id_kehadiran'];
                                            $nilai = $row_presensi['nilai'];
                                            $saran = $row_presensi['saran'];
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo htmlspecialchars($row_presensi["nama_peserta"]); ?></td>
                                                <td>
                                                    <?php if (empty($nilai)) { ?>
                                                        <a href="tambah-penilaian.php?id_kehadiran=<?php echo $id_kehadiran; ?>" class="btn btn-sm btn-primary">Isi Penilaian</a>
                                                    <?php } else { ?>
                                                        <?php echo htmlspecialchars($nilai); ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if (empty($saran)) { ?>
                                                        <?php if (empty($nilai)) { ?>
                                                            <!-- Display empty cell if both nilai and saran are missing -->
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php echo htmlspecialchars($saran); ?>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <a href="tambah-penilaian.php?id_kehadiran=<?php echo $row_presensi["id_kehadiran"]; ?>" class="btn btn-sm btn-outline-warning btn-fw">Edit</a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right mt-3">
                                <a href="trainer-schedule.php" class="btn btn-warning">Back</a>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info" role="alert">
                                Tidak ada data peserta yang ditemukan.
                            </div>
                            <div class="text-right mt-3">
                                <a href="trainer-schedule.php" class="btn btn-warning">Back</a>
                            </div>
                        <?php } ?>
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