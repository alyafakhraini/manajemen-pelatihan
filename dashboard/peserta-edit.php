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

$id_peserta = $_GET["id_peserta"];
$result_peserta = mysqli_query($conn, "SELECT * FROM tbl_peserta WHERE id_peserta = '$id_peserta'");
$row_peserta = mysqli_fetch_assoc($result_peserta);

if (isset($_POST["submit"])) {

    $nama_peserta = $_POST["nama_peserta"];
    $email = $_POST["email"];
    $telp_peserta = $_POST["telp_peserta"];
    $gender = $_POST["gender"];
    $domisili = $_POST["domisili"];
    $status_peserta = $_POST["status_peserta"];
    $komunitas = $_POST["komunitas"];

    $simpan = mysqli_query($conn, "UPDATE tbl_peserta SET nama_peserta = '$nama_peserta', email = '$email', telp_peserta = '$telp_peserta', gender = '$gender', domisili = '$domisili', status_peserta = '$status_peserta', komunitas = '$komunitas' WHERE id_peserta = '$id_peserta'");

    if ($simpan) {
        header("Location: peserta.php");
    } else {
        header("Location: peserta-edit.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title> Edit Peserta</title>
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
            /* Warna latar belakang */
            padding: 0.2rem 1rem 0.2rem 1rem;
            /* Padding sesuai keinginan */
            border-radius: 0.375rem;
            /* Membuat sudut kartu menjadi bulat */
            margin-bottom: 1rem;
            /* Jarak bawah */
        }

        .breadcrumb-container h4 {
            margin-bottom: 0.5rem;
            /* Jarak bawah untuk heading */
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
                                    <h3 class="mt-4"><b>Edit Peserta</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="peserta.php">Data Peserta</a></li>
                                        <li class="breadcrumb-item active">Edit Peserta</li>
                                    </ol>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data" class="forms-sample">
                                    <div class="form-group row">
                                        <label for="nama_peserta" class="col-sm-2 col-form-label">Nama Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama_peserta" id="nama_peserta" value="<?php echo $row_peserta["nama_peserta"] ?>" placeholder="Masukkan nama peserta yang baru" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="email" id="email" value="<?php echo $row_peserta["email"] ?>" placeholder="Masukkan email baru" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="telp_peserta" class="col-sm-2 col-form-label">Nomor Telepon</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="telp_peserta" id="telp_peserta" value="<?php echo $row_peserta["telp_peserta"] ?>" placeholder="Masukkan nomor telepon yang baru" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender" id="gender1" value="lk" <?php if ($row_peserta["gender"] == 'lk') echo "checked"; ?>> Laki-laki </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="gender" id="gender2" value="pr" <?php if ($row_peserta["gender"] == 'pr') echo "checked"; ?>> Perempuan </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="domisili" class="col-sm-2 col-form-label">Domisili</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="domisili" id="domisili" value="<?php echo $row_peserta["domisili"] ?>" placeholder="Masukkan domisili yang baru" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="status_peserta" class="col-sm-2 col-form-label">Status Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="status_peserta" id="status_peserta" value="<?php echo $row_peserta["status_peserta"] ?>" placeholder="Contoh: peserta/mahasiswa/karyawan/umum" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="komunitas" class="col-sm-2 col-form-label">Komunitas</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="komunitas" id="komunitas" value="<?php echo $row_peserta["komunitas"] ?>" placeholder="contoh: FTI Uniska/Umum" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Edit</button>
                                            <a href="peserta.php" class="btn btn-light">Cancel</a>
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