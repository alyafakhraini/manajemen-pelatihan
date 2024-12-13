<?php
session_start();
include "koneksi.php";

// Cek level user yang login
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;

$id_pelatihan = isset($_GET['id_pelatihan']) ? $_GET['id_pelatihan'] : '';
$query_pelatihan = "SELECT pelatihan.*, trainer.nama_trainer
                    FROM tbl_pelatihan AS pelatihan
                    JOIN tbl_trainer AS trainer ON pelatihan.id_trainer = trainer.id_trainer
                    WHERE id_pelatihan = ?";
$stmt_pelatihan = mysqli_prepare($conn, $query_pelatihan);
mysqli_stmt_bind_param($stmt_pelatihan, "s", $id_pelatihan);
mysqli_stmt_execute($stmt_pelatihan);
$result_pelatihan = mysqli_stmt_get_result($stmt_pelatihan);

if (mysqli_num_rows($result_pelatihan) > 0) {
    $row_pelatihan = mysqli_fetch_assoc($result_pelatihan);

    $tanggal_pelatihan = date("d F Y", strtotime($row_pelatihan['tgl_pelatihan']));
    $tanggal_pelatihan_parts = explode(' ', $tanggal_pelatihan);
    $bulan_english = $tanggal_pelatihan_parts[1];
    $tanggal_pelatihan_parts[1] = getBulanIndonesia($bulan_english);
    $tanggal_pelatihan = implode(' ', $tanggal_pelatihan_parts);

    switch ($row_pelatihan['kategori_program']) {
        case 'level up':
            $kategori_text = 'Level Up';
            break;
        case 'ap':
            $kategori_text = 'Acceleration Program';
            break;
        case 'psc':
            $kategori_text = 'Professional Skill Certificate';
            break;
        case 'bootcamp':
            $kategori_text = 'Bootcamp';
            break;
        default:
            $kategori_text = 'Tidak Diketahui';
            break;
    }
} else {
    echo "Pelatihan tidak ditemukan.";
    exit;
}

function getBulanIndonesia($bulan)
{
    $bulan_indonesia = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    );
    return $bulan_indonesia[$bulan];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="image/bcti_logo.png" type="image/png" />
    <title>Detail Pelatihan: <?php echo htmlspecialchars($row_pelatihan['nama_pelatihan']); ?></title> <!-- Bootstrap CSS -->
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
                            <h2>Detail Pelatihan</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="courses.php">Pelatihan BCTI</a>
                                <a href="course-details.php">Courses Details</a>
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
            <div class="row">
                <div class="col-lg-8 course_details_left">
                    <div class="main_image">
                        <img class="img-fluid" src="poster/<?php echo htmlspecialchars($row_pelatihan['poster']); ?>" alt="<?php echo htmlspecialchars($row_pelatihan['nama_pelatihan']); ?>" />
                    </div>
                </div>
                <div class="col-lg-4 right-contents">
                    <h2 class="title"><?php echo htmlspecialchars($kategori_text) . ': ' . htmlspecialchars($row_pelatihan['nama_pelatihan']); ?></h2>
                    <ul>
                        <li>
                            <a class="justify-content-between d-flex">
                                <p>Tanggal</p>
                                <span><b><?php echo htmlspecialchars($tanggal_pelatihan); ?></b></span>
                            </a>
                        </li>
                        <li>
                            <a class="justify-content-between d-flex">
                                <p>Waktu</p>
                                <b><?php echo htmlspecialchars($row_pelatihan['waktu']); ?></b>
                            </a>
                        </li>
                        <li>
                            <a class="justify-content-between d-flex">
                                <p>Nama Trainer</p>
                                <b><?php echo htmlspecialchars($row_pelatihan['nama_trainer']); ?></b>
                            </a>
                        </li>
                        <li>
                            <a class="justify-content-between d-flex">
                                <p>Biaya Pelatihan</p>
                                <b><?php echo 'Rp. ' . number_format($row_pelatihan['harga'], 0, ',', '.') . ',-'; ?></b>
                            </a>
                        </li>
                        <div class="content_wrapper">
                            <h2 class="title">Deskripsi Pelatihan</h2>
                            <p><?php echo htmlspecialchars($row_pelatihan['deskripsi']); ?></p>
                        </div>
                    </ul>
                </div>
            </div>
            <?php
            // Menyertakan daftar-course.php hanya jika level user adalah 'peserta'
            if ($user_level === 'peserta') {
                include "daftar-course.php";
            }
            ?>
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
</body>

</html>