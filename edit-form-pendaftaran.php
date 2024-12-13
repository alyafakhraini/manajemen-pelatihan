<?php
session_start();
include "koneksi.php";

// Mengatur zona waktu
date_default_timezone_set('Asia/Makassar');

// Cek level user yang login
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;

// Mendapatkan ID pendaftaran dari URL
$id_pendaftaran = isset($_GET['id_pendaftaran']) ? $_GET['id_pendaftaran'] : null;

if ($id_pendaftaran) {
    // Mengambil data pendaftaran
    $query = "SELECT pendaftaran.*, pelatihan.nama_pelatihan, pelatihan.tgl_pelatihan, peserta.nama_peserta, pelatihan.harga 
              FROM tbl_pendaftaran pendaftaran
              JOIN tbl_pelatihan pelatihan ON pendaftaran.id_pelatihan = pelatihan.id_pelatihan
              JOIN tbl_peserta peserta ON pendaftaran.id_peserta = peserta.id_peserta
              WHERE pendaftaran.id_pendaftaran = $id_pendaftaran";
    $result_pendaftaran = mysqli_query($conn, $query);

    if (!$result_pendaftaran) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    $row_pendaftaran = mysqli_fetch_assoc($result_pendaftaran);

    $id_pelatihan = $row_pendaftaran["id_pelatihan"];
    $id_peserta = $row_pendaftaran["id_peserta"];
    $nama_pelatihan = $row_pendaftaran['nama_pelatihan'];
    $tgl_pelatihan = $row_pendaftaran['tgl_pelatihan'];
    $harga = $row_pendaftaran['harga'];
    $nama_peserta = $row_pendaftaran['nama_peserta'];
    $metode_pembayaran = $row_pendaftaran['metode_pembayaran'];
    $jml_pembayaran = $row_pendaftaran['jml_pembayaran'];
    $bukpem_lama = $row_pendaftaran["bukpem"];
    $status_pembayaran = $row_pendaftaran['status_pembayaran'];

    if (isset($_POST["submit"])) {
        $tgl_daftar = date('Y-m-d H:i:s');
        $metode_pembayaran = $_POST['metode_pembayaran'];
        $jml_pembayaran = intval($_POST["jml_pembayaran"]);

        // Mengelola file upload
        if ($_FILES['bukpem']['error'] === 4) {
            $bukpem = $bukpem_lama; // Gunakan bukti pembayaran lama jika tidak ada file baru
        } else {
            $bukpem = $_FILES["bukpem"]["name"];
            $target_file = 'bukpem/' . $bukpem;
            if (move_uploaded_file($_FILES['bukpem']['tmp_name'], $target_file)) {
                // Berhasil mengupload file
            } else {
                // Gagal mengupload file
                echo "Gagal mengunggah bukti pembayaran.";
                exit;
            }
        }

        $status_pembayaran = $_POST['status_pembayaran'];

        // Update data pendaftaran
        $query = "UPDATE tbl_pendaftaran SET 
                    tgl_daftar = '$tgl_daftar',
                    metode_pembayaran = '$metode_pembayaran',
                    jml_pembayaran = $jml_pembayaran,
                    bukpem = '$bukpem',
                    status_pembayaran = '$status_pembayaran'
                  WHERE id_pendaftaran = $id_pendaftaran";

        $simpan = mysqli_query($conn, $query);

        if ($simpan) {
            // Redirect ke halaman my-course.php jika berhasil
            header("Location: my-course.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "ID pendaftaran tidak valid.";
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
    <title>Form Pendaftaran Pelatihan: <?php echo htmlspecialchars($nama_pelatihan); ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
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
                            <h2>Edit Form Pendaftaran</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="my-course.php">Pelatihan Saya</a>
                                <a href="edit-form-pendaftaran.php">Edit Form Pendaftaran</a>
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
                        <h2 class="mb-3"> Edit Form Pendaftaran</h2>
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
                            <h2 class="title">Edit Form Pendaftaran - <?php echo htmlspecialchars($nama_pelatihan, ENT_QUOTES, 'UTF-8'); ?></h2>

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_pendaftaran=$id_pendaftaran"; ?>" enctype="multipart/form-data">
                                <div>
                                    <input type="hidden" name="id_pelatihan" value="<?php echo htmlspecialchars($id_pelatihan, ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="id_peserta" value="<?php echo htmlspecialchars($id_peserta, ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" id="tgl_daftar" name="tgl_daftar">
                                </div>
                                <div class="form-group row">
                                    <label for="id_peserta" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9 mt-3">
                                        <span><strong><?php echo htmlspecialchars($nama_peserta, ENT_QUOTES, 'UTF-8'); ?></strong></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="metode_pembayaran" class="col-sm-3 col-form-label">Metode Pembayaran</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                                <option value="tf" <?php if ($metode_pembayaran == 'tf') echo "SELECTED"; ?>>Transfer (Mandiri an. Yayasan Hasnur Centre: 0310019368888)</option>
                                                <option value="cash" <?php if ($metode_pembayaran == 'cash') echo "SELECTED"; ?>>Cash</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="jml_pembayaran" class="col-sm-3 col-form-label">Jumlah Pembayaran</label>
                                    <div class="col-sm-9 mt-3">
                                        <span><strong><?php echo 'Rp. ' . number_format($harga, 0, ',', '.') . ',-'; ?></strong></span>
                                        <input type="hidden" name="jml_pembayaran" value="<?php echo $harga; ?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bukpem" class="col-sm-3 col-form-label">Bukti Pembayaran Lama</label>
                                    <div class="col-sm-9">
                                        <img src="bukpem/<?php echo $bukpem_lama; ?>" alt="bukpem" class="img-thumbnail" width="200">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bukpem" class="col-sm-3 col-form-label">Upload Bukti Pembayaran Baru</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="bukpem" id="bukpem">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Course Details Area =================-->

    <!--================ Start Footer Area =================-->
    <?php include "footer.php"; ?>
    <!--================ End Footer Area =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>