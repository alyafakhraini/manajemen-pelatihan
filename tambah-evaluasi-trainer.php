<?php
session_start();
include "koneksi.php";

date_default_timezone_set('Asia/Makassar');

// Cek level user yang login
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;

// Mendapatkan ID pelatihan dari URL
$id_pelatihan = isset($_GET['id_pelatihan']) ? $_GET['id_pelatihan'] : null;
$id_peserta = isset($_SESSION['id_peserta']) ? $_SESSION['id_peserta'] : null; // Sesuaikan dengan cara Anda mendapatkan ID peserta yang sedang login

// Inisialisasi variabel untuk pesan dan status
$redirect_to_login = false;
$status_kegiatan = 'ongoing'; // Ubah sesuai dengan status sebenarnya dari kegiatan
$form_visible = false; // Default form tidak ditampilkan kecuali dicek
$form_submitted = false; // Apakah form sudah di-submit

// Cek apakah peserta sudah login
if (!$id_peserta) {
    $redirect_to_login = true;
}

// Mendapatkan data pelatihan dan peserta
$sql_pelatihan = "  SELECT P.nama_pelatihan, P.kategori_program, P.tgl_pelatihan, T.nama_trainer, T.id_trainer
                    FROM tbl_pelatihan P, tbl_trainer T
                    WHERE P.id_trainer = T.id_trainer
                    AND P.id_pelatihan = $id_pelatihan";
$result_pelatihan = mysqli_query($conn, $sql_pelatihan);
$row_pelatihan = mysqli_fetch_assoc($result_pelatihan);
$id_trainer = $row_pelatihan['id_trainer']; // Mendapatkan id_trainer dari hasil query

$nama_peserta = ''; // Inisialisasi variabel nama peserta
if ($id_peserta) {
    $sql_peserta = "SELECT nama_peserta FROM tbl_peserta WHERE id_peserta = $id_peserta";
    $result_peserta = mysqli_query($conn, $sql_peserta);
    $row_peserta = mysqli_fetch_assoc($result_peserta);
    $nama_peserta = $row_peserta['nama_peserta'];
}

// Memeriksa apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $rating_penguasaan_materi = $_POST['rating_penguasaan_materi'];
    $rating_metode_pengajaran = $_POST['rating_metode_pengajaran'];
    $rating_interaksi = $_POST['rating_interaksi'];
    $feedback = $_POST['feedback'];

    $sql_check_kehadiran = "SELECT H.id_kehadiran
                            FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                            WHERE H.id_pendaftaran = D.id_pendaftaran
                            AND D.id_pelatihan = P.id_pelatihan
                            AND D.id_peserta = C.id_peserta
                            AND C.id_peserta = $id_peserta
                            AND P.id_pelatihan = $id_pelatihan
                            AND H.status_kehadiran = 'hadir'";
    $result_check_kehadiran = mysqli_query($conn, $sql_check_kehadiran);

    if (mysqli_num_rows($result_check_kehadiran) > 0) {
        $row_kehadiran = mysqli_fetch_assoc($result_check_kehadiran);
        $id_kehadiran = $row_kehadiran['id_kehadiran'];

        // Query untuk memasukkan data ke tabel tbl_evaluasi_trainer
        $sql_evaluasi_trainer = "INSERT INTO tbl_evaluasi_trainer (id_kehadiran, id_trainer, id_pelatihan, id_peserta, rating_penguasaan_materi, rating_metode_pengajaran, rating_interaksi, feedback)
                         VALUES ($id_kehadiran, $id_trainer, $id_pelatihan, $id_peserta, '$rating_penguasaan_materi', '$rating_metode_pengajaran', '$rating_interaksi', '$feedback')";

        if (mysqli_query($conn, $sql_evaluasi_trainer)) {
            $form_submitted = true;
        } else {
            echo "Error: " . $sql_evaluasi_trainer . "<br>" . mysqli_error($conn);
        }
    } else {
        // Jika tidak ada kehadiran dengan status 'hadir', atur form_visible menjadi false
        $form_visible = false;
    }
}

// Memeriksa apakah peserta sudah mengisi form evaluasi
$sql_check = "SELECT * FROM tbl_evaluasi_trainer WHERE id_pelatihan = $id_pelatihan AND id_peserta = $id_peserta";
$result_check = mysqli_query($conn, $sql_check);
$form_submitted = (mysqli_num_rows($result_check) > 0);

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
    <title>Form Evaluasi Trainer: <?php echo htmlspecialchars($row_pelatihan['nama_pelatihan']); ?></title> <!-- Bootstrap CSS -->
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
                            <h2>Evaluasi Trainer</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="my-course.php">Pelatihan Saya</a>
                                <a href="tambah-evaluasi-trainer.php">Form Evaluasi Trainer</a>
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
                        <h2 class="mb-3">Form Evaluasi Trainer</h2>
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
                                Form Evaluasi Trainer - <?php echo htmlspecialchars(getKategoriProgramText($row_pelatihan['kategori_program']) . " : " . $row_pelatihan["nama_pelatihan"]); ?>
                            </h2>

                            <?php if ($redirect_to_login) : ?>
                                <div class="alert alert-warning" role="alert">
                                    Anda harus login terlebih dahulu untuk mengisi form evaluasi trainer.
                                </div>
                                <a href="login.php" class="btn btn-primary">Login</a>
                            <?php elseif ($status_kegiatan == 'done') : ?>
                                <div class="alert alert-primary" role="alert">
                                    Pelatihan ini telah selesai.
                                </div>
                            <?php elseif ($form_submitted) : ?>
                                <div class="alert alert-info text-center" role="alert">
                                    Terima kasih telah mengisikan evaluasi trainer untuk pelatihan ini. Form Evaluasi Trainer berhasil disubmit, silakan cek <a href="my-course.php" class="alert-link">Pelatihan Saya</a>.
                                <?php elseif ($form_visible) : ?>
                                    <div class="alert alert-warning text-center" role="alert">
                                        Anda tidak hadir dalam pelatihan ini, sehingga tidak bisa mengisi form evaluasi.
                                    <?php else : ?>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_pelatihan=$id_pelatihan"; ?>" enctype="multipart/form-data">
                                            <div>
                                                <input type="hidden" name="id_pelatihan" value="<?php echo htmlspecialchars($id_pelatihan); ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo htmlspecialchars($id_peserta); ?>">
                                                <input type="hidden" name="id_trainer" value="<?php echo htmlspecialchars($id_trainer); ?>">
                                                <input type="hidden" id="tgl_input_evaluasi_trainer" name="tgl_input_evaluasi_trainer">
                                            </div>
                                            <div class="form-group row">
                                                <label for="id_trainer" class="col-sm-2 col-form-label">Nama Trainer</label>
                                                <div class="col-sm-10 mt-3">
                                                    <span><strong><?php echo htmlspecialchars($row_pelatihan["nama_trainer"]); ?></strong></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="id_peserta" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10 mt-3">
                                                    <span><strong><?php echo htmlspecialchars($nama_peserta); ?></strong></span>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="rating_penguasaan_materi" class="col-sm-2 col-form-label">Rating Penguasaan Materi</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="rating_penguasaan_materi" name="rating_penguasaan_materi" rows="10" placeholder="Masukkan untuk rating penguasaan materi (1-100) dan alasannya. Contoh: 100, materinya sangat daging" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="rating_metode_pengajaran" class="col-sm-2 col-form-label">Rating Metode Pembelajaran</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="rating_metode_pengajaran" name="rating_metode_pengajaran" rows="10" placeholder="Masukkan rating untuk metode pembelajaran dari trainer (1-100) dan alasannya." required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="rating_interaksi" class="col-sm-2 col-form-label">Rating Interaksi Trainer</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="rating_interaksi" name="rating_interaksi" rows="10" placeholder="Masukkan rating untuk interaksi trainer (1-100) dan alasannya." required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="feedback" class="col-sm-2 col-form-label">Feedback</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="feedback" name="feedback" rows="10" placeholder="Masukkan feedback untuk trainer di pelatihan ini" required></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-10 offset-sm-2">
                                                    <button type="submit" name="submit" class="btn btn-primary me-2">Submit</button>
                                                    <a href="my-course.php" class="btn btn-light">Cancel</a>
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