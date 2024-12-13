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

$id_pengaduan = isset($_GET["id_pengaduan"]) ? mysqli_real_escape_string($conn, $_GET["id_pengaduan"]) : '';

$result_pengaduan = mysqli_query($conn, "SELECT pengaduan.*, peserta.nama_peserta
                                    FROM tbl_pengaduan AS pengaduan
                                    JOIN tbl_peserta AS peserta ON pengaduan.id_peserta = peserta.id_peserta
                                    WHERE id_pengaduan = '$id_pengaduan'");
$row_pengaduan = mysqli_fetch_assoc($result_pengaduan);

$id_peserta = $row_pengaduan["id_peserta"];
$nama_peserta = $row_pengaduan["nama_peserta"];
$tgl_pengaduan = $row_pengaduan["tgl_pengaduan"];
$isi_pengaduan = $row_pengaduan["isi_pengaduan"];

if (isset($_POST["submit"])) {
    $tanggapan_admin = mysqli_real_escape_string($conn, $_POST["tanggapan_admin"]);

    $simpan = mysqli_query($conn, "UPDATE tbl_pengaduan SET tanggapan_admin = '$tanggapan_admin' WHERE id_pengaduan = '$id_pengaduan'");

    if ($simpan) {
        header("Location: pengaduan.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

function getBulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    return $bulanIndo[$bulan];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title>Edit Data Pengaduan</title>
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
                                    <h3 class="mt-4"><b>Edit Data Pengaduan</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="pengaduan.php">Data Pengaduan</a></li>
                                        <li class="breadcrumb-item active">Edit Pengaduan</li>
                                    </ol>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data" class="forms-sample">
                                    <div class="form-group row">
                                        <label for="id_peserta" class="col-sm-2 col-form-label">Nama Peserta</label>
                                        <div class="col-sm-10 mt-3">
                                            <span><strong><?php echo htmlspecialchars($row_pengaduan['nama_peserta']); ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tgl_pengaduan" class="col-sm-2 col-form-label">Tanggal Pengaduan</label>
                                        <div class="col-sm-10 mt-3">
                                            <span><strong>
                                                    <?php
                                                    if (!empty($row_pengaduan["tgl_pengaduan"])) {
                                                        $timestamp = strtotime($row_pengaduan["tgl_pengaduan"]);
                                                        $tanggal = date("d", $timestamp);
                                                        $bulan = date("n", $timestamp);
                                                        $tahun = date("Y", $timestamp);
                                                        $jam = date("H:i:s", $timestamp);
                                                        echo sprintf("%02d %s %d, %s", $tanggal, getBulanIndonesia($bulan), $tahun, $jam);
                                                    } else {
                                                        echo "Tanggal tidak tersedia";
                                                    }
                                                    ?>
                                                </strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="isi_pengaduan" class="col-sm-2 col-form-label">Isi Pengaduan</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="isi_pengaduan" name="isi_pengaduan" rows="5" required><?php echo htmlspecialchars($row_pengaduan['isi_pengaduan']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tanggapan_admin" class="col-sm-2 col-form-label">Tanggapan</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="tanggapan_admin" name="tanggapan_admin" rows="5" required><?php echo htmlspecialchars($row_pengaduan['tanggapan_admin']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Edit</button>
                                            <a href="pengaduan.php" class="btn btn-light">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <?php include "footer.php"; ?>
            </div>
        </div>
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