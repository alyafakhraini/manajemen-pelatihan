<?php
session_start();
include "koneksi.php";

// Cek level user yang login
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;

// Mendapatkan ID pelatihan dari URL
$id_pelatihan = isset($_GET['id_pelatihan']) ? $_GET['id_pelatihan'] : null;
$id_peserta = isset($_SESSION['id_peserta']) ? $_SESSION['id_peserta'] : null; // Sesuaikan dengan cara Anda mendapatkan ID peserta yang sedang login

// Inisialisasi variabel untuk pesan dan status
$redirect_to_login = false;
$status_kegiatan = 'ongoing'; // Ubah sesuai dengan status sebenarnya dari kegiatan
$form_submitted = false;
$form_visible = true; // Inisialisasi variabel untuk menampilkan form evaluasi

// Cek apakah peserta sudah login
if (!$id_peserta) {
    $redirect_to_login = true;
}

// Mendapatkan data pelatihan
$sql_pelatihan = "SELECT * FROM tbl_pelatihan WHERE id_pelatihan = $id_pelatihan";
$result_pelatihan = mysqli_query($conn, $sql_pelatihan);
$row_pelatihan = mysqli_fetch_assoc($result_pelatihan);

// Mendapatkan nama peserta
$nama_peserta = ''; // Inisialisasi variabel nama peserta
if ($id_peserta) {
    $sql_peserta = "SELECT nama_peserta FROM tbl_peserta WHERE id_peserta = $id_peserta";
    $result_peserta = mysqli_query($conn, $sql_peserta);
    $row_peserta = mysqli_fetch_assoc($result_peserta);
    $nama_peserta = $row_peserta['nama_peserta'];
}

// Memeriksa apakah form sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $id_pelatihan = $_POST['id_pelatihan'];
    $id_peserta = $_POST['id_peserta'];
    $jawaban1 = $_POST['jawaban1'];
    $jawaban2 = $_POST['jawaban2'];
    $jawaban3 = $_POST['jawaban3'];
    $jawaban4 = $_POST['jawaban4'];
    $jawaban5 = $_POST['jawaban5'];

    // Query untuk memasukkan data ke tabel tbl_evaluasi_pelatihan
    $simpan = "INSERT INTO tbl_pretest (id_pelatihan, id_peserta, jawaban1, jawaban2, jawaban3, jawaban4, jawaban5) 
               VALUES ('$id_pelatihan', '$id_peserta', '$jawaban1', '$jawaban2', '$jawaban3', '$jawaban4', '$jawaban5')";
    if (mysqli_query($conn, $simpan)) {
        $form_submitted = true;
    } else {
        echo "Error: " . $simpan . "<br>" . mysqli_error($conn);
    }
}

// Query untuk memeriksa status pembayaran peserta
$sql_check_pembayaran = "SELECT D.id_pendaftaran
                        FROM tbl_pendaftaran D
                        WHERE D.id_pelatihan = $id_pelatihan
                        AND D.id_peserta = $id_peserta
                        AND D.status_pembayaran = 'confirmed'";
$result_check_pembayaran = mysqli_query($conn, $sql_check_pembayaran);

// Jika peserta tidak 'confirmed', form_visible menjadi false
$form_visible = (mysqli_num_rows($result_check_pembayaran) === 0);

// Memeriksa apakah peserta sudah mengisi form evaluasi
$sql_check = "SELECT * FROM tbl_pretest WHERE id_pelatihan = $id_pelatihan AND id_peserta = $id_peserta";
$result_check = mysqli_query($conn, $sql_check);
$form_submitted = (mysqli_num_rows($result_check) > 0);


// Mendapatkan pertanyaan dari tbl_test
$sql_test = "SELECT pertanyaan1, pertanyaan2, pertanyaan3, pertanyaan4, pertanyaan5 FROM tbl_test WHERE id_pelatihan = $id_pelatihan";
$result_test = mysqli_query($conn, $sql_test);
$row_test = mysqli_fetch_assoc($result_test);

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
    <title>Form Pre-Test: <?php echo htmlspecialchars($row_pelatihan['nama_pelatihan']); ?></title> <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="assets/css/style.css" /> <!-- css dashboard -->
    <style>
        .radio-inline {
            display: inline-block;
            margin-right: 20px;
        }

        .radio-group {
            padding-left: 40px;
            /* Memberikan padding untuk menjorok ke dalam */
        }

        .form-group.row .btn {
            margin-top: 50px;
            /* Atur jarak atas untuk tombol submit */
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
                            <h2>Pre-Test Pelatihan</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="my-course.php">Pelatihan Saya</a>
                                <a href="tambah-pretest.php">Form Pre-Test</a>
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
                        <h2 class="mb-3"> Form Pre-Test</h2>
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
                                Form Pre-Test - <?php echo htmlspecialchars(getKategoriProgramText($row_pelatihan['kategori_program']) . " : " . $row_pelatihan["nama_pelatihan"]); ?>
                            </h2>

                            <?php if ($redirect_to_login) : ?>
                                <div class="alert alert-warning" role="alert">
                                    Anda harus login terlebih dahulu untuk mengisi form evaluasi pelatihan.
                                </div>
                                <a href="login.php" class="btn btn-primary">Login</a>
                            <?php elseif ($status_kegiatan == 'done') : ?>
                                <div class="alert alert-primary" role="alert">
                                    Pelatihan ini telah selesai.
                                </div>
                            <?php elseif ($form_submitted) : ?>
                                <div class="alert alert-info text-center" role="alert">
                                    Terima kasih telah mengisikan Pre-Test untuk pelatihan ini. Form Pre-Test berhasil disubmit, silakan kembali ke <a href="my-course.php" class="alert-link">Pelatihan Saya</a>.
                                <?php elseif ($form_visible) : ?>
                                    <div class="alert alert-warning text-center" role="alert">
                                        Pendaftaran anda belum terkonfirmasi untuk pelatihan ini, sehingga tidak bisa mengisi form Pre-Test.
                                    <?php else : ?>

                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_pelatihan=$id_pelatihan"; ?>" enctype="multipart/form-data">
                                            <div>
                                                <input type="hidden" name="id_pelatihan" value="<?php echo htmlspecialchars($id_pelatihan); ?>">
                                                <input type="hidden" name="id_peserta" value="<?php echo htmlspecialchars($id_peserta); ?>">
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-12 mt-3 mb-5 text-center">
                                                    <span><strong>
                                                            Pre-test ini bertujuan untuk menilai pemahaman awal Anda terhadap materi pelatihan. Hasil pre-test akan membantu kami memahami tingkat pengetahuan Anda sebelum pelatihan dimulai.
                                                            Jawablah setiap pertanyaan dengan jujur. Setelah pelatihan, Anda akan diminta untuk mengisi post-test untuk menilai kemajuan Anda. Perbandingan antara pre-test dan post-test akan menunjukkan perkembangan Anda dan efektivitas pelatihan.
                                                        </strong></span>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label for="id_peserta" class="col-sm-1 col-form-label">Nama</label>
                                                <div class="col-sm-10 mt-3">
                                                    <span><strong><?php echo htmlspecialchars($nama_peserta); ?></strong></span>
                                                </div>
                                            </div>

                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <div class="form-group row">
                                                    <div class="col-sm-11 offset-sm-1 mt-3 mb-3">
                                                        <span><?php echo $i . ". " . $row_test["pertanyaan$i"]; ?></span>
                                                    </div>
                                                    <div class="col-sm-11 offset-sm-1 radio-group">
                                                        <?php for ($skala = 1; $skala <= 5; $skala++) { ?>
                                                            <span class="radio-inline">
                                                                <input type="radio" name="jawaban<?php echo $i; ?>" value="<?php echo $skala; ?>" required>
                                                                <?php
                                                                switch ($skala) {
                                                                    case 1:
                                                                        echo "1 Sangat Kurang";
                                                                        break;
                                                                    case 2:
                                                                        echo "2 Kurang";
                                                                        break;
                                                                    case 3:
                                                                        echo "3 Cukup";
                                                                        break;
                                                                    case 4:
                                                                        echo "4 Baik";
                                                                        break;
                                                                    case 5:
                                                                        echo "5 Sangat Baik";
                                                                        break;
                                                                }
                                                                ?>
                                                            </span>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>


                                            <div class="form-group row">
                                                <div class="col-sm-11 offset-sm-1">
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