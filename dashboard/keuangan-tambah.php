<?php
session_start();
include "../koneksi.php";

$id_pelatihan = isset($_GET['id_pelatihan']) ? (int)$_GET['id_pelatihan'] : 0;

$nama_pelatihan = '';
$tgl_pelatihan = '';

// Mengambil detail pelatihan jika id_pelatihan tersedia
if ($id_pelatihan > 0) {
    $pelatihan_detail_query = "
    SELECT nama_pelatihan, tgl_pelatihan
    FROM tbl_pelatihan
    WHERE id_pelatihan = '$id_pelatihan'
    ";

    $pelatihan_detail_result = mysqli_query($conn, $pelatihan_detail_query);

    if ($pelatihan_detail_result && mysqli_num_rows($pelatihan_detail_result) > 0) {
        $pelatihan_detail = mysqli_fetch_assoc($pelatihan_detail_result);
        $nama_pelatihan = $pelatihan_detail['nama_pelatihan'];
        $tgl_pelatihan = $pelatihan_detail['tgl_pelatihan'];
    }
} else {
    echo "ID Pelatihan tidak ditemukan.";
    exit;
}

if (isset($_POST["submit"])) {
    // Mengambil nilai input dari form
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $kategori_transaksi = $_POST['kategori_transaksi'];
    $deskripsi = $_POST['deskripsi'];
    $jml_transaksi = $_POST['jml_transaksi'];

    $simpan_keuangan = mysqli_query($conn, "INSERT INTO tbl_keuangan (id_pelatihan, tgl_transaksi, kategori_transaksi, deskripsi, jml_transaksi) 
                                    VALUES ('$id_pelatihan', '$tgl_transaksi', '$kategori_transaksi', '$deskripsi', '$jml_transaksi')");

    if ($simpan_keuangan) {
        header("Location: keuangan.php?id_pelatihan=$id_pelatihan");
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
    <title> Tambah Data Keuangan</title>
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
                                    <h3 class="mt-4"><b>Data Keuangan - <?php echo htmlspecialchars($nama_pelatihan); ?> (<?php echo date("d F Y", strtotime($tgl_pelatihan)); ?>)</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="keuangan-pelatihan-list.php">Pilih Pelatihan</a></li>
                                        <li class="breadcrumb-item"><a href="keuangan.php?id_pelatihan=<?php echo $id_pelatihan ?>">Data Keuangan - <?php echo htmlspecialchars($nama_pelatihan); ?></a></li>
                                        <li class="breadcrumb-item active">Tambah Data keuangan - <?php echo htmlspecialchars($nama_pelatihan); ?></li>
                                    </ol>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data" class="forms-sample">
                                    <input type="hidden" id="id_pelatihan" name="id_pelatihan" value="<?php echo $id_pelatihan; ?>">
                                    <div class="form-group row">
                                        <label for="tgl_transaksi" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Kategori Transaksi</label>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="kategori_transaksi" id="kategori_transaksi1" value="pendapatan"> Pendapatan </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="kategori_transaksi" id="kategori_transaksi2" value="pengeluaran"> Pengeluaran </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jml_transaksi" class="col-sm-2 col-form-label">Jumlah Transaksi</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="jml_transaksi" id="jml_transaksi" placeholder="Masukkan jumlah transaksi tanpa koma (contoh: 200000)" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Tambah</button>
                                            <a href="keuangan.php?id_pelatihan=<?php echo $id_pelatihan ?>" class="btn btn-light">Cancel</a>
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