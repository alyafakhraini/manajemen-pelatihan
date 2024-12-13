<?php
session_start();
include "koneksi.php";

$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;

$kategori_program = isset($_GET['kategori_program']) ? $_GET['kategori_program'] : '';

// Query to get the data from tbl_pelatihan with optional filtering by kategori_program
$query_pelatihan = "SELECT * FROM tbl_pelatihan WHERE status_kegiatan != 'postponed'";
if (!empty($kategori_program)) {
    $query_pelatihan .= " AND kategori_program = '" . mysqli_real_escape_string($conn, $kategori_program) . "'";
}
$query_pelatihan .= " ORDER BY tgl_pelatihan DESC";
$result_pelatihan = mysqli_query($conn, $query_pelatihan);

if (!$result_pelatihan) {
    throw new mysqli_sql_exception(mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="image/bcti_logo.png" type="image/png" />
    <title>Pelatihan BCTI</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
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
                            <h2>Pelatihan BCTI</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="courses.php">Pelatihan BCTI</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================ Start Popular Courses Area =================-->
    <div class="popular_courses section_gap_top">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3">Pelatihan BCTI</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- single course -->
                <?php
                if ($result_pelatihan->num_rows > 0) {
                    // Output data dari setiap baris
                    while ($row_pelatihan = $result_pelatihan->fetch_assoc()) {
                        // Format tanggal pelatihan
                        $tanggal_pelatihan = date("d", strtotime($row_pelatihan['tgl_pelatihan']));
                        $bulan_pelatihan = date("M", strtotime($row_pelatihan['tgl_pelatihan']));
                ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="single_event position-relative">
                                <div class="event_thumb">
                                    <img class="event_thumb_img" src="poster/<?php echo $row_pelatihan['poster']; ?>" alt="" />
                                </div>
                                <div class="event_details">
                                    <div class="d-flex mb-2">
                                        <div class="date"><span><?php echo $tanggal_pelatihan; ?></span> <?php echo $bulan_pelatihan; ?></div>
                                        <div class="time-location">
                                            <p>
                                                <span class="ti-location-pin mr-2"></span><?php echo $row_pelatihan['tempat']; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <p><strong><?php echo $row_pelatihan['nama_pelatihan']; ?></strong></p>
                                    <a href="course-detail.php?id_pelatihan=<?php echo $row_pelatihan['id_pelatihan']; ?>" class="genric-btn primary-border medium">Details</a>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>Belum ada pelatihan</p>";
                }
                ?>

            </div>
        </div>
    </div>
    <!--================ End Popular Courses Area =================-->


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
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>