<?php
session_start();
include "koneksi.php";

date_default_timezone_set('Asia/Makassar');

// Cek level user yang login
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;

$id_peserta = isset($_SESSION['id_peserta']) ? $_SESSION['id_peserta'] : null; // Sesuaikan dengan cara Anda mendapatkan ID peserta yang sedang login

// Inisialisasi variabel untuk pesan dan status
$redirect_to_login = false;
$form_submitted = false;

// Cek apakah peserta sudah login
if (!$id_peserta) {
    $redirect_to_login = true;
}

// Inisialisasi variabel nama peserta
$nama_peserta = '';
if ($id_peserta) {
    $sql_peserta = "SELECT nama_peserta FROM tbl_peserta WHERE id_peserta = " . intval($id_peserta);
    $result_peserta = mysqli_query($conn, $sql_peserta);
    if ($result_peserta) {
        $row_peserta = mysqli_fetch_assoc($result_peserta);
        $nama_peserta = $row_peserta['nama_peserta'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Memeriksa apakah form sudah disubmit
if (isset($_POST['submit'])) {
    $tgl_pengaduan = date('Y-m-d H:i:s');
    $isi_pengaduan = mysqli_real_escape_string($conn, $_POST['isi_pengaduan']);

    // Query untuk memasukkan data ke tabel tbl_pengaduan
    $sql_pengaduan = "INSERT INTO tbl_pengaduan (id_peserta, tgl_pengaduan, isi_pengaduan, status_pengaduan, tanggapan_admin)
                      VALUES ('$id_peserta', '$tgl_pengaduan', '$isi_pengaduan', '', '')";

    if (mysqli_query($conn, $sql_pengaduan)) {
        $form_submitted = true;
    } else {
        echo "Error: " . $sql_pengaduan . "<br>" . mysqli_error($conn);
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
    <title>Form Pengaduan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="assets/css/style.css" /> <!-- css dashboard -->
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
                            <h2>Form Pengaduan</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="pengaduan-peserta.php">Pengaduan</a>
                                <a href="tambah-pengaduan.php">Form Pengaduan</a>
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
                        <h2 class="mb-3"> Form Pengaduan</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="title">
                                Form Pengaduan
                            </h2>

                            <?php if ($redirect_to_login) : ?>
                                <div class="alert alert-warning" role="alert">
                                    Anda harus login terlebih dahulu untuk mengisi form pengaduan.
                                </div>
                                <a href="login.php" class="btn btn-primary">Login</a>
                            <?php elseif ($form_submitted) : ?>
                                <div class="alert alert-info text-center" role="alert">
                                    Form Pengaduan berhasil disubmit, silakan cek <a href="pengaduan-peserta.php" class="alert-link">Pengaduan Saya</a>.
                                </div>
                            <?php else : ?>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                    <div>
                                        <input type="hidden" name="id_peserta" value="<?php echo htmlspecialchars($id_peserta); ?>">
                                        <input type="hidden" id="tgl_input_pengaduan" name="tgl_input_pengaduan">
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_peserta" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10 mt-3">
                                            <span><strong><?php echo htmlspecialchars($nama_peserta); ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="isi_pengaduan" class="col-sm-2 col-form-label">Isi Pengaduan</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="isi_pengaduan" name="isi_pengaduan" rows="10" placeholder="Tuliskan keluhan mu atau kebingungan mu" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Submit</button>
                                            <a href="pengaduan-peserta.php" class="btn btn-light">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>
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
</body>

</html>