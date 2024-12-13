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

$id_kehadiran = isset($_GET["id"]) ? intval($_GET["id"]) : 0;

$result_kehadiran = mysqli_query($conn, "SELECT H.id_kehadiran, D.id_pendaftaran, P.id_pelatihan, P.nama_pelatihan, P.tgl_pelatihan, C.nama_peserta,
                                            H.status_kehadiran, H.nilai, H.saran
                                         FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                                         WHERE H.id_kehadiran = $id_kehadiran
                                         AND H.id_pendaftaran = D.id_pendaftaran
                                         AND D.id_pelatihan = P.id_pelatihan
                                         AND D.id_peserta = C.id_peserta");
if (!$result_kehadiran) {
    die("Error: " . mysqli_error($conn));
}

$row_kehadiran = mysqli_fetch_assoc($result_kehadiran);

$id_pelatihan = $row_kehadiran["id_pelatihan"];

if (isset($_POST["submit"])) {
    $id_pendaftaran = $_POST['id_pendaftaran'];
    $status_kehadiran = $_POST['status_kehadiran'];
    $nilai = $_POST['nilai'];
    $saran = $_POST['saran'];

    $simpan = "UPDATE tbl_kehadiran 
               SET id_pendaftaran = '$id_pendaftaran', 
                   status_kehadiran = '$status_kehadiran', 
                   nilai = '$nilai',
                   saran = '$saran' 
               WHERE id_kehadiran = $id_kehadiran";

    if (mysqli_query($conn, $simpan)) {
        header("Location: kehadiran-show.php?id_pelatihan=" . $row_kehadiran['id_pelatihan']);
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
    <title> Edit kehadiran Peserta</title>
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
                                    <h3 class="mt-4"><b>Edit Data Peforma Peserta - <?php echo $row_kehadiran["nama_pelatihan"]; ?> (<?php echo date("d F Y", strtotime($row_kehadiran["tgl_pelatihan"])); ?>)</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="kehadiran-pelatihan-list.php">Pilih Pelatihan</a></li>
                                        <li class="breadcrumb-item"><a href="kehadiran-show.php?id_pelatihan=<?php echo $row_kehadiran["id_pelatihan"]; ?>">Data Performa Peserta - <?php echo $row_kehadiran["nama_pelatihan"]; ?></a></li>
                                        <li class="breadcrumb-item active">Edit Data Performa Peserta - <?php echo $row_kehadiran["nama_pelatihan"]; ?></li>
                                    </ol>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="id_peserta" class="col-sm-2 col-form-label">Nama Peserta</label>
                                        <div class="col-sm-10 mt-3">
                                            <span><strong><?php echo $row_kehadiran["nama_peserta"]; ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status Kehadiran</label>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status_kehadiran" id="status_kehadiran1" value="hadir" <?php if ($row_kehadiran["status_kehadiran"] == 'hadir') echo "checked"; ?>> Hadir </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status_kehadiran" id="status_kehadiran2" value="tidak hadir" <?php if ($row_kehadiran["status_kehadiran"] == 'tidak hadir') echo "checked"; ?>> Tidak Hadir </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nilai" class="col-sm-2 col-form-label">Nilai Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nilai" name="nilai" rows="10" value="<?php echo $row_kehadiran["nilai"] ?>" placeholder="Masukkan nilai untuk peserta"></input>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="saran" class="col-sm-2 col-form-label">Saran</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="saran" name="saran" rows="5"><?php echo htmlspecialchars($row_kehadiran['saran']); ?></textarea>
                                        </div>
                                    </div>
                                    <input type="hidden" value="<?php echo $row_kehadiran['id_pendaftaran']; ?>" name="id_pendaftaran">
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Edit</button>
                                            <a href="kehadiran-show.php?id_pelatihan=<?php echo $id_pelatihan; ?>" class="btn btn-light">Cancel</a>
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