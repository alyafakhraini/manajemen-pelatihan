<?php
session_start();
include "koneksi.php";

// Cek level user yang login
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
$id_trainer = isset($_SESSION['id_trainer']) ? $_SESSION['id_trainer'] : null;

// Inisialisasi variabel untuk pesan dan status
$redirect_to_login = false;
$form_submitted = false;

// Cek apakah trainer sudah login
if (!$id_trainer) {
    $redirect_to_login = true;
}

// Mendapatkan ID kehadiran dari URL
$id_kehadiran = isset($_GET['id_kehadiran']) ? intval($_GET['id_kehadiran']) : null;

if ($id_kehadiran) {
    // Mengambil data kehadiran
    $query = "SELECT P.nama_pelatihan, C.nama_peserta, H.nilai, H.saran, P.id_pelatihan 
              FROM tbl_kehadiran H
              JOIN tbl_pendaftaran D ON H.id_pendaftaran = D.id_pendaftaran
              JOIN tbl_pelatihan P ON D.id_pelatihan = P.id_pelatihan
              JOIN tbl_peserta C ON D.id_peserta = C.id_peserta
              WHERE H.id_kehadiran = $id_kehadiran";
    $result_kehadiran = mysqli_query($conn, $query);

    if (!$result_kehadiran) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    $row_penilaian = mysqli_fetch_assoc($result_kehadiran);
    $id_pelatihan = $row_penilaian["id_pelatihan"];

    if (isset($_POST["submit"])) {
        $nilai = $_POST['nilai'];
        $saran = $_POST['saran'];

        // Update data kehadiran
        $query = "UPDATE tbl_kehadiran SET 
                    nilai = '$nilai',
                    saran = '$saran'
                  WHERE id_kehadiran = $id_kehadiran";

        $simpan = mysqli_query($conn, $query);

        if ($simpan) {
            $form_submitted = true;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "ID kehadiran tidak valid.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="image/bcti_logo.png" type="image/png" />
    <title>Form Penilaian</title>
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
                            <h2>Form Penilaian</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="trainer-schedule.php">Trainer</a>
                                <a href="daftar-peserta.php">Daftar Peserta</a>
                                <a href="tambah-penilaian.php">Form Penilaian</a>
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
                        <h2 class="mb-3"> Form Penilaian - <?php echo $row_penilaian["nama_pelatihan"]; ?> </h2>
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
                            <h2 class="title"> Form Penilaian - <?php echo $row_penilaian["nama_pelatihan"]; ?> </h2>

                            <?php if ($redirect_to_login) : ?>
                                <div class="alert alert-warning" role="alert">
                                    Anda harus login terlebih dahulu untuk mengisi form Penilaian.
                                </div>
                                <a href="login.php" class="btn btn-primary">Login</a>
                            <?php elseif ($form_submitted) : ?>
                                <div class="alert alert-info" role="alert">
                                    Form Penilaian berhasil disubmit, silakan cek <a href="daftar-peserta.php?id_pelatihan=<?php echo $row_penilaian["id_pelatihan"] ?>" class="alert-link">Daftar Peserta</a>.
                                </div>
                            <?php else : ?>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_kehadiran=$id_kehadiran"; ?>" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="id_peserta" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10 mt-3">
                                            <span><strong><?php echo $row_penilaian["nama_peserta"]; ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nilai" class="col-sm-2 col-form-label">Nilai Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nilai" name="nilai" rows="10" value="<?php echo $row_penilaian["nilai"] ?>" placeholder="Masukkan nilai untuk peserta" required></input>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="saran" class="col-sm-2 col-form-label">Saran</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="saran" name="saran" rows="10" placeholder="Tuliskan saran untuk peserta" required><?php echo $row_penilaian["saran"] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Submit</button>
                                            <a href="daftar-peserta.php?id_pelatihan=<?= $id_pelatihan ?>" class="btn btn-light">Cancel</a>
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