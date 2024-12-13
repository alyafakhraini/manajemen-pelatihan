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

$query = "SELECT pelatihan.*, trainer.nama_trainer
        FROM tbl_pelatihan AS pelatihan
        JOIN tbl_trainer AS trainer ON pelatihan.id_trainer = trainer.id_trainer
        WHERE pelatihan.id_trainer = $id_trainer";

if (!empty($search_query)) {
    $query .= " AND pelatihan.nama_pelatihan LIKE '%$search_query%'";
}

// Urutkan berdasarkan tanggal pelatihan dari terbaru ke terlama
$query .= " ORDER BY pelatihan.tgl_pelatihan DESC";

$result = $conn->query($query);

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
    <title>Trainer Schedule</title>
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
                            <h2>Trainer Schedule</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="trainer-schedule.php">Trainer Schedule</a>
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
                        <h2 class="mb-3">Trainer Schedule</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <?php if (mysqli_num_rows($result) > 0) { ?>
                            <?php $row = mysqli_fetch_assoc($result); ?>
                            <h2 class="title">
                                Trainer Schedule - <?php echo htmlspecialchars($row['nama_trainer']); ?>
                                <a href="print-performa-trainer.php?id_trainer=<?= $id_trainer ?>" class="btn btn-warning btn-icon-text print-btn" target="_blank">Print Performa <i class="ti-printer btn-icon-append"></i></a>
                            </h2>

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
                                            <th>No</th>
                                            <th>Status</th>
                                            <th>Nama Pelatihan</th>
                                            <th>Tanggal & Waktu Pelatihan</th>
                                            <th>Tempat</th>
                                            <th>Pelaksanaan</th>
                                            <th>Daftar Peserta</th>
                                            <th>Hasil Evaluasi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        mysqli_data_seek($result, 0);
                                        $no = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $id_pelatihan = $row['id_pelatihan'];
                                            $id_trainer = $row['id_trainer'];
                                        ?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td>
                                                    <?php
                                                    if ($row["status_kegiatan"] == "on going") { //status 1 (on going)
                                                        echo "<div class='btn btn-sm btn-secondary'>On Going</div>";
                                                    } else if ($row["status_kegiatan"] == "done") { //status 2 (done)
                                                        echo "<div class='btn btn-sm btn-success'>Done</div>";
                                                    } else if ($row["status_kegiatan"] == "postponed") { //status 3 (postponed)
                                                        echo "<div class='btn btn-sm btn-dark'>Postponed</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo htmlspecialchars(getKategoriProgramText($row['kategori_program']) . " : " . $row["nama_pelatihan"]); ?></td>
                                                <td>
                                                    <?php
                                                    if (isset($row["tgl_pelatihan"]) && isset($row["waktu"])) {
                                                        $timestamp = strtotime($row["tgl_pelatihan"]);
                                                        $tanggal = date("j", $timestamp);
                                                        $bulan = date("n", $timestamp);
                                                        $tahun = date("Y", $timestamp);
                                                        $waktu = htmlspecialchars($row["waktu"]);
                                                        echo sprintf("%02d %s %d (%s)", $tanggal, getBulanIndonesia($bulan), $tahun, $waktu);
                                                    } else {
                                                        echo "Tanggal dan waktu tidak tersedia";
                                                    }
                                                    ?>
                                                </td>
                                                <td><?php echo $row["tempat"] ?></td>
                                                <td>
                                                    <?php
                                                    if ($row["pelaksanaan"] == "offline") { // 1 (offline)
                                                        echo "<div class='btn btn-sm btn-primary'>Offline</div>";
                                                    } else if ($row["pelaksanaan"] == "online") { //2 (online)
                                                        echo "<div class='btn btn-sm btn-secondary'>Online</div>";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="daftar-peserta.php?id_pelatihan=<?php echo $id_pelatihan; ?>" class="btn btn-info btn-sm">Lihat Daftar Peserta</a>
                                                </td>
                                                <td>
                                                    <a href="evaluasi-trainer.php?id_pelatihan=<?php echo $id_pelatihan; ?>" class="btn btn-info btn-sm">Lihat Hasil Evaluasi</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>

                                </table>
                            </div>
                        <?php } else { ?>
                            <div class="alert alert-info" role="alert">
                                Tidak ada data pelatihan yang ditemukan.
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