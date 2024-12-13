<?php
session_start();
include "koneksi.php";

$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
$id_trainer = isset($_SESSION['id_trainer']) ? $_SESSION['id_trainer'] : null;

if ($id_trainer == null) {
    header("Location: login.php");
    exit();
}

if (isset($_GET["id_pelatihan"])) {
    $id_pelatihan = $_GET["id_pelatihan"];

    $query_pelatihan = mysqli_query($conn, "SELECT nama_pelatihan, kategori_program FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'");
    $pelatihan = mysqli_fetch_assoc($query_pelatihan);
    $nama_pelatihan = $pelatihan['nama_pelatihan'];
    $kategori_program = $pelatihan['kategori_program'];

    $kategori_text = getKategoriProgramText($kategori_program);

    $query = "SELECT evaluasi.*, peserta.nama_peserta 
              FROM tbl_evaluasi_trainer AS evaluasi
              JOIN tbl_kehadiran AS hadir ON evaluasi.id_kehadiran = hadir.id_kehadiran
              JOIN tbl_peserta AS peserta ON evaluasi.id_peserta = peserta.id_peserta 
              WHERE evaluasi.id_pelatihan = '$id_pelatihan'";

    $result_evaluasi = mysqli_query($conn, $query);
} else {
    $result_evaluasi = false;
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
    <title>Hasil Evaluasi Trainer: <?php echo htmlspecialchars($nama_pelatihan); ?></title> <!-- Bootstrap CSS -->
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

        .print-btn {
            float: right;
            margin-left: 10px;
            /* Optional: add some spacing between the text and the button */
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
                            <h2>Hasil Evaluasi Trainer</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="trainer-schedule.php">Trainer Schedule</a>
                                <a href="evaluasi_trainer.php">Hasil Evaluasi Trainer</a>
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
                        <h2 class="mb-3">Hasil Evaluasi Trainer</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h2 class="title">
                            Hasil Evaluasi Trainer - <?php echo htmlspecialchars($kategori_text) . ': ' . htmlspecialchars($nama_pelatihan); ?>
                            <a href="print-evaluasi-trainer.php?id_pelatihan=<?= $id_pelatihan ?>" class="btn btn-primary btn-icon-text print-btn" target="_blank">Print PDF <i class="ti-printer btn-icon-append"></i></a>
                        </h2>

                        <?php if ($result_evaluasi && mysqli_num_rows($result_evaluasi) > 0) { ?>

                            <div class="table-responsive">
                                <table class="table table-striped table-centered" height="auto">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peserta</th>
                                            <th>Penguasaan Materi</th>
                                            <th> Metode Pengajaran</th>
                                            <th> Interaksi</th>
                                            <th>Feedback</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        while ($row_evaluasi = mysqli_fetch_assoc($result_evaluasi)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo htmlspecialchars($row_evaluasi["nama_peserta"]); ?></td>
                                                <td><?php echo htmlspecialchars($row_evaluasi["rating_penguasaan_materi"]); ?></td>
                                                <td><?php echo htmlspecialchars($row_evaluasi["rating_metode_pengajaran"]); ?></td>
                                                <td><?php echo htmlspecialchars($row_evaluasi["rating_interaksi"]); ?></td>
                                                <td><?php echo htmlspecialchars($row_evaluasi["feedback"]); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                            <div class="text-right mt-3">
                                <a href="trainer-schedule.php" class="btn btn-warning">Back</a>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info text-center" role="alert">
                                Tidak ada data evaluasi yang ditemukan.
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