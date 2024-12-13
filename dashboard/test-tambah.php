<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'admin' && $level != 'panitia') {
    header("Location: ../login.php");
    exit;
}

if (isset($_POST["submit"])) {

    $id_pelatihan = $_POST["id_pelatihan"];
    $pertanyaan1 = $_POST["pertanyaan1"];
    $pertanyaan2 = $_POST["pertanyaan2"];
    $pertanyaan3 = $_POST["pertanyaan3"];
    $pertanyaan4 = $_POST["pertanyaan4"];
    $pertanyaan5 = $_POST["pertanyaan5"];

    $simpan = mysqli_query($conn, "INSERT INTO tbl_test VALUES(NULL, '$id_pelatihan', '$pertanyaan1', '$pertanyaan2', '$pertanyaan3', '$pertanyaan4', '$pertanyaan5')");

    if ($simpan) {
        header("Location: test-show.php");
    } else {
        header("Location: test-tambah.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title> Tambah Data Test</title>
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
                                    <h3 class="mt-4"><b>Tambah Data Test</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="test-show.php">Data Test</a></li>
                                        <li class="breadcrumb-item active">Tambah Data Test</li>
                                    </ol>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data" class="forms-sample">
                                    <div class="form-group row">
                                        <label for="id_pelatihan" class="col-sm-2 col-form-label">Nama Pelatihan</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <select name="id_pelatihan" id="id_pelatihan" class="form-control" required>
                                                    <option value="">-- Pilih Pelatihan --</option>
                                                    <?php
                                                    $query_pelatihan = mysqli_query($conn, "SELECT id_pelatihan, nama_pelatihan, kategori_program FROM tbl_pelatihan ORDER BY tgl_pelatihan DESC");
                                                    while ($row_pelatihan = mysqli_fetch_assoc($query_pelatihan)) {
                                                        // Menentukan teks kategori program
                                                        switch ($row_pelatihan["kategori_program"]) {
                                                            case 'level_up':
                                                                $kategori_program_text = 'Level Up';
                                                                break;
                                                            case 'psc':
                                                                $kategori_program_text = 'Professional Skill Certificate';
                                                                break;
                                                            case 'ap':
                                                                $kategori_program_text = 'Acceleration Program';
                                                                break;
                                                            case 'bootcamp':
                                                                $kategori_program_text = 'Bootcamp';
                                                                break;
                                                            default:
                                                                $kategori_program_text = ucfirst($row_pelatihan["kategori_program"]);
                                                                break;
                                                        }

                                                        // Menggabungkan kategori program dengan nama pelatihan
                                                        $nama_pelatihan = $kategori_program_text . ': ' . $row_pelatihan["nama_pelatihan"];

                                                        // Menampilkan opsi dropdown
                                                        echo '<option value="' . $row_pelatihan['id_pelatihan'] . '">' . $nama_pelatihan . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pertanyaan1" class="col-sm-2 col-form-label">Pertanyaan 1</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="pertanyaan1" name="pertanyaan1" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pertanyaan2" class="col-sm-2 col-form-label">Pertanyaan 2</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="pertanyaan2" name="pertanyaan2" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pertanyaan3" class="col-sm-2 col-form-label">Pertanyaan 3</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="pertanyaan3" name="pertanyaan3" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pertanyaan4" class="col-sm-2 col-form-label">Pertanyaan 4</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="pertanyaan4" name="pertanyaan4" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="pertanyaan5" class="col-sm-2 col-form-label">Pertanyaan 5</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="pertanyaan5" name="pertanyaan5" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Tambah</button>
                                            <a href="pre-test-show.php" class="btn btn-light">Cancel</a>
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