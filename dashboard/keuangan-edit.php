<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level !== 'admin') {
    header("Location: access-denied.php");
    exit;
}

$id_keuangan = $_GET["id_keuangan"];

$query = "SELECT keuangan.*, pelatihan.nama_pelatihan, pelatihan.tgl_pelatihan
          FROM tbl_keuangan AS keuangan
          JOIN tbl_pelatihan AS pelatihan ON keuangan.id_pelatihan = pelatihan.id_pelatihan
          WHERE keuangan.id_keuangan = '$id_keuangan'";
$result_keuangan = mysqli_query($conn, $query);
$row_keuangan = mysqli_fetch_assoc($result_keuangan);

if (!$row_keuangan) {
    echo "Data keuangan tidak ditemukan.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $kategori_transaksi = $_POST['kategori_transaksi'];
    $deskripsi = $_POST['deskripsi'];
    $jml_transaksi = intval($_POST["jml_transaksi"]);

    $query_update = "UPDATE tbl_keuangan SET tgl_transaksi = '$tgl_transaksi', kategori_transaksi = '$kategori_transaksi', deskripsi = '$deskripsi', jml_transaksi = '$jml_transaksi' WHERE id_keuangan = '$id_keuangan'";
    $simpan = mysqli_query($conn, $query_update);

    if ($simpan) {
        header("Location: keuangan.php?id_pelatihan={$row_keuangan['id_pelatihan']}");
        exit();
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
    <title>Edit Tambah Keuangan</title>
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

        .breadcrumb-container h3 {
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
                                    <h3 class="mt-4"><b>Edit Data Keuangan - <?php echo htmlspecialchars($row_keuangan['nama_pelatihan']); ?> (<?php echo date("d F Y", strtotime($row_keuangan['tgl_pelatihan'])); ?>)</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="keuangan-pelatihan-list.php">Pilih Pelatihan</a></li>
                                        <li class="breadcrumb-item"><a href="keuangan.php?id_pelatihan=<?php echo $row_keuangan['id_pelatihan']; ?>">Data Keuangan - <?php echo htmlspecialchars($row_keuangan['nama_pelatihan']); ?></a></li>
                                        <li class="breadcrumb-item active">Edit Data keuangan - <?php echo htmlspecialchars($row_keuangan['nama_pelatihan']); ?></li>
                                    </ol>
                                </div>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_keuangan=$id_keuangan"; ?>" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="tgl_transaksi" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" value="<?php echo htmlspecialchars($row_keuangan['tgl_transaksi']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Kategori Transaksi</label>
                                            <div class="col-sm-4">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="kategori_transaksi" id="kategori_transaksi1" value="pendapatan" <?php if ($row_keuangan["kategori_transaksi"] === 'pendapatan') echo "checked"; ?>> Pendapatan </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="kategori_transaksi" id="kategori_transaksi2" value="pengeluaran" <?php if ($row_keuangan["kategori_transaksi"] === 'pengeluaran') echo "checked"; ?>> Pengeluaran </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="10" required><?php echo htmlspecialchars($row_keuangan['deskripsi']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jml_transaksi" class="col-sm-2 col-form-label">Jumlah Transaksi</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" id="jml_transaksi" name="jml_transaksi" value="<?php echo htmlspecialchars($row_keuangan['jml_transaksi']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Edit</button>
                                            <a href="keuangan.php?id_pelatihan=<?php echo $row_keuangan['id_pelatihan']; ?>" class="btn btn-light">Cancel</a>
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