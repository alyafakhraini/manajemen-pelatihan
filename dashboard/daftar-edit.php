<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'admin') {
    header("Location: access-denied.php");
    exit;
}

$id_pendaftaran = $_GET["id"];

// Mengambil data pendaftaran
$query = "SELECT pendaftaran.*, pelatihan.nama_pelatihan, pelatihan.tgl_pelatihan, peserta.nama_peserta 
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
$nama_peserta = $row_pendaftaran['nama_peserta'];
$tgl_daftar = $row_pendaftaran['tgl_daftar'];
$metode_pembayaran = $row_pendaftaran['metode_pembayaran'];
$jml_pembayaran = $row_pendaftaran['jml_pembayaran'];
$bukpem_lama = $row_pendaftaran["bukpem"];
$status_pembayaran = $row_pendaftaran['status_pembayaran'];

if (isset($_POST["submit"])) {
    $tgl_daftar = $_POST['tgl_daftar'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $jml_pembayaran = intval($_POST["jml_pembayaran"]);

    if ($_FILES['bukpem']['error'] === 4) {
        $bukpem = $bukpem_lama;
    } else {
        $bukpem = $_FILES["bukpem"]["name"];
        $upload_path = '../admin/bukpem/' . $bukpem;

        if (!move_uploaded_file($_FILES['bukpem']['tmp_name'], $upload_path)) {
            echo "Error: File upload failed.";
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
        header("Location: daftar-show.php?id_pelatihan=$id_pelatihan");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title>Edit Form Pendaftaran - <?php echo htmlspecialchars($nama_pelatihan); ?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="../assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="../assets/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- endinject -->
    <style>
        .breadcrumb-container {
            background-color: #e4eefc;
            padding: 0.2rem 1rem 0.2rem 1rem;
            border-radius: 0.375rem;
            margin-bottom: 1rem;
        }

        .breadcrumb-container h4 {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body class="with-welcome-text">
    <div class="container-scroller">

        <?php include "navbar.php"; ?>

        <div class="container-fluid page-body-wrapper">

            <?php include "sidebar.php"; ?>

            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="breadcrumb-container">
                                    <h3 class="mt-4"><b>Edit Form Pendaftaran - <?php echo htmlspecialchars($nama_pelatihan); ?> (<?php echo date("d F Y", strtotime($tgl_pelatihan)); ?>)</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="daftar-pelatihan-list.php">Pilih Pelatihan</a></li>
                                        <li class="breadcrumb-item"><a href="daftar-show.php?id_pelatihan=<?php echo $id_pelatihan; ?>">Data Pendaftar - <?php echo htmlspecialchars($nama_pelatihan); ?></a></li>
                                        <li class="breadcrumb-item active">Edit Form Pendaftaran - <?php echo htmlspecialchars($nama_pelatihan); ?></li>
                                    </ol>
                                </div>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=$id_pendaftaran"; ?>" enctype="multipart/form-data">
                                    <div>
                                        <input type="hidden" name="id_pelatihan" value="<?php echo htmlspecialchars($id_pelatihan); ?>">
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_peserta" class="col-sm-2 col-form-label">Nama Peserta</label>
                                        <div class="col-sm-10 mt-3">
                                            <span><strong><?php echo htmlspecialchars($nama_peserta); ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tgl_daftar" class="col-sm-2 col-form-label">Waktu Pendaftaran</label>
                                        <div class="col-sm-10">
                                            <input type="datetime-local" class="form-control" id="tgl_daftar" name="tgl_daftar" value="<?php echo htmlspecialchars($tgl_daftar); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Metode Pembayaran</label>
                                            <div class="col-sm-4">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="metode_pembayaran" id="metode_pembayaran1" value="tf" <?php if ($row_pendaftaran["metode_pembayaran"] == 'tf') echo "checked"; ?>> Transfer (Mandiri an. Yayasan Hasnur Centre: 0310019368888) </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="metode_pembayaran" id="metode_pembayaran2" value="cash" <?php if ($row_pendaftaran["metode_pembayaran"] == 'cash') echo "checked"; ?>> Cash </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jml_pembayaran" class="col-sm-2 col-form-label">Jumlah Pembayaran</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="jml_pembayaran" name="jml_pembayaran" value="<?php echo htmlspecialchars($jml_pembayaran); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bukpem" class="col-sm-2 col-form-label">Bukti Pembayaran Lama</label>
                                        <div class="col-sm-10">
                                            <img src="../bukpem/<?php echo $row_pendaftaran["bukpem"] ?>" alt="bukpem" class="img-thumnail" width="200">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="bukpem" class="col-sm-2 col-form-label">Bukti Pembayaran Baru</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="bukpem" id="bukpem">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Metode Pembayaran</label>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status_pembayaran" id="status_pembayaran1" value="pending" <?php if ($row_pendaftaran["status_pembayaran"] == 'pending') echo "checked"; ?>> Pending </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status_pembayaran" id="status_pembayaran2" value="confirmed" <?php if ($row_pendaftaran["status_pembayaran"] == 'confirmed') echo "checked"; ?>> Terkonfirmasi </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Edit</button>
                                            <a href="daftar-show.php?id_pelatihan=<?php echo $id_pelatihan; ?>" class="btn btn-light">Cancel</a>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <?php include "footer.php"; ?>
    </div>

    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/chart.umd.js"></script>
    <script src="../assets/vendors/progressbar.js/progressbar.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/template.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="../assets/js/dashboard.js"></script>
    <!-- End custom js for this page-->
</body>

</html>