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

$id_agenda = $_GET["id"];
$result_agenda = mysqli_query($conn, "SELECT * FROM tbl_agenda WHERE id_agenda = '$id_agenda'");
$row_agenda = mysqli_fetch_assoc($result_agenda);

// Inisialisasi variabel $deskripsi dengan nilai dari database
$deskripsi = $row_agenda['deskripsi'];

if (isset($_POST["submit"])) {

    $tgl_agenda = $_POST["tgl_agenda"];
    $nama_agenda = $_POST["nama_agenda"];
    $deskripsi = $_POST["deskripsi"];
    $tujuan_tempat = $_POST["tujuan_tempat"];
    $status_agenda = $_POST["status_agenda"];

    // Hindari SQL Injection dengan menggunakan prepared statement
    $stmt = mysqli_prepare($conn, "UPDATE tbl_agenda SET tgl_agenda = ?, nama_agenda = ?, deskripsi = ?, tujuan_tempat = ?, status_agenda = ? WHERE id_agenda = ?");
    mysqli_stmt_bind_param($stmt, "sssssi", $tgl_agenda, $nama_agenda, $deskripsi, $tujuan_tempat, $status_agenda, $id_agenda);

    // Lakukan eksekusi statement
    $exec_update = mysqli_stmt_execute($stmt);

    if ($exec_update) {
        header("Location: agenda.php");
        exit(); // Penting: hentikan eksekusi skrip setelah redirect
    } else {
        echo "Gagal melakukan update agenda.";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title> Edit Agenda</title>
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
                                    <h3 class="mt-4"><b>Edit Agenda</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="agenda.php">Data Agenda</a></li>
                                        <li class="breadcrumb-item active">Edit Agenda</li>
                                    </ol>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data" class="forms-sample">
                                    <div class="form-group row">
                                        <label for="tgl_agenda" class="col-sm-2 col-form-label">Tanggal</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" name="tgl_agenda" id="tgl_agenda" value="<?php echo date('Y-m-d', strtotime($row_agenda["tgl_agenda"])); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama_agenda" class="col-sm-2 col-form-label">Agenda</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama_agenda" id="nama_agenda" value="<?php echo $row_agenda["nama_agenda"] ?>" placeholder="Masukkan agenda yang baru" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="10" required><?php echo htmlspecialchars($deskripsi); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tujuan_tempat" class="col-sm-2 col-form-label">Tujuan / Tempat</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="tujuan_tempat" id="tujuan_tempat" value="<?php echo $row_agenda["tujuan_tempat"] ?>" placeholder="Masukkan tujuan atau tempat yang baru" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="status_agenda" class="col-sm-2 col-form-label">Status Agenda</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <select name="status_agenda" id="status_agenda" class="form-control">
                                                    <option value="on going" <?php if ($row_agenda["status_agenda"] == 'on going') echo "SELECTED"; ?>>On Going</option>
                                                    <option value="done" <?php if ($row_agenda["status_agenda"] == 'done') echo "SELECTED"; ?>>Done</option>
                                                    <option value="postponed" <?php if ($row_agenda["status_agenda"] == 'postponed') echo "SELECTED"; ?>>Postponed</option>
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Edit</button>
                                            <a href="agenda.php" class="btn btn-light">Cancel</a>
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