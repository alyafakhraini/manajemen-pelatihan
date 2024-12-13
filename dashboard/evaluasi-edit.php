<?php
session_start();
include "../koneksi.php";

$id_evaluasi_pelatihan = $_GET["id_evaluasi_pelatihan"];

// Fetch evaluasi data
$query_evaluasi = "SELECT eval.*, pelatihan.nama_pelatihan, pelatihan.tgl_pelatihan, peserta.nama_peserta 
                    FROM tbl_evaluasi_pelatihan AS eval
                    JOIN tbl_kehadiran AS hadir ON eval.id_kehadiran = hadir.id_kehadiran
                    JOIN tbl_pelatihan AS pelatihan ON eval.id_pelatihan = pelatihan.id_pelatihan
                    JOIN tbl_peserta AS peserta ON eval.id_peserta = peserta.id_peserta
                    WHERE eval.id_evaluasi_pelatihan = '$id_evaluasi_pelatihan'";
$result_evaluasi = mysqli_query($conn, $query_evaluasi);
$row_evaluasi = mysqli_fetch_assoc($result_evaluasi);

if (!$row_evaluasi) {
    // Jika data evaluasi tidak ditemukan
    echo "Data evaluasi tidak ditemukan.";
    exit();
}

// Handle form submission
if (isset($_POST["submit"])) {
    $rating_materi = mysqli_real_escape_string($conn, $_POST['rating_materi']);
    $rating_fasilitas = mysqli_real_escape_string($conn, $_POST['rating_fasilitas']);
    $rating_bcti = mysqli_real_escape_string($conn, $_POST['rating_bcti']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
    $rekomendasi = mysqli_real_escape_string($conn, $_POST['rekomendasi']);
    $testimoni = mysqli_real_escape_string($conn, $_POST['testimoni']);

    // Update evaluasi data
    $query_update = "UPDATE tbl_evaluasi_pelatihan 
                     SET rating_materi = '$rating_materi', rating_fasilitas = '$rating_fasilitas', rating_bcti = '$rating_bcti', feedback = '$feedback', rekomendasi = '$rekomendasi', testimoni = '$testimoni' 
                     WHERE id_evaluasi_pelatihan = '$id_evaluasi_pelatihan'";

    $result_update = mysqli_query($conn, $query_update);

    if ($result_update) {
        // Redirect to evaluasi-show.php on success
        header("Location: evaluasi-show.php?id_pelatihan=" . $row_evaluasi['id_pelatihan']);
        exit();
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
    <title>Edit Evaluasi Pelatihan</title>
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
                                    <h3 class="mt-4"><b>Edit Evaluasi Pelatihan - <?php echo htmlspecialchars($row_evaluasi['nama_pelatihan']); ?> (<?php echo date("d F Y", strtotime($row_evaluasi['tgl_pelatihan'])); ?>)</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="evaluasi-pelatihan-list.php">Pilih Pelatihan</a></li>
                                        <li class="breadcrumb-item"><a href="evaluasi-show.php?id_pelatihan=<?php echo $row_evaluasi['id_pelatihan']; ?>">Data Evaluasi Pelatihan - <?php echo htmlspecialchars($row_evaluasi['nama_pelatihan']); ?></a></li>
                                        <li class="breadcrumb-item active">Edit Evaluasi Pelatihan - <?php echo htmlspecialchars($row_evaluasi['nama_pelatihan']); ?></li>
                                    </ol>
                                </div>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_evaluasi_pelatihan=$id_evaluasi_pelatihan"; ?>" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label for="id_peserta" class="col-sm-2 col-form-label">Nama Peserta</label>
                                        <div class="col-sm-10 mt-3">
                                            <span><strong><?php echo htmlspecialchars($row_evaluasi['nama_peserta']); ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tgl_input_evaluasi" class="col-sm-2 col-form-label">Tanggal Pengisian</label>
                                        <div class="col-sm-10 mt-3">
                                            <span><strong>
                                                    <?php
                                                    if (!empty($row_evaluasi["tgl_input_evaluasi_pelatihan"])) {
                                                        $timestamp = strtotime($row_evaluasi["tgl_input_evaluasi_pelatihan"]);
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
                                        <label for="rating_materi" class="col-sm-2 col-form-label">Rating Materi</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="rating_materi" name="rating_materi" rows="5" required><?php echo htmlspecialchars($row_evaluasi['rating_materi']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="rating_fasilitas" class="col-sm-2 col-form-label">Rating Fasilitas</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="rating_fasilitas" name="rating_fasilitas" rows="5" required><?php echo htmlspecialchars($row_evaluasi['rating_fasilitas']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="rating_bcti" class="col-sm-2 col-form-label">Rating BCTI</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="rating_bcti" name="rating_bcti" rows="5" required><?php echo htmlspecialchars($row_evaluasi['rating_bcti']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="feedback" class="col-sm-2 col-form-label">Feedback</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="feedback" name="feedback" rows="5" required><?php echo htmlspecialchars($row_evaluasi['feedback']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="rekomendasi" class="col-sm-2 col-form-label">Rekomendasi Pelatihan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="rekomendasi" id="rekomendasi" value="<?php echo htmlspecialchars($row_evaluasi['rekomendasi']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="testimoni" class="col-sm-2 col-form-label">Testimoni</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="testimoni" name="testimoni" rows="5" required><?php echo htmlspecialchars($row_evaluasi['testimoni']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Simpan</button>
                                            <a href="evaluasi-show.php?id_pelatihan=<?php echo $row_evaluasi['id_pelatihan']; ?>" class="btn btn-light">Batal</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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