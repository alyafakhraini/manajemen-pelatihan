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

$tipe_kegiatan = "";
$pelaksanaan = "";

if (isset($_POST["submit"])) {

    $id_trainer = $_POST["id_trainer"];
    $tgl_pelatihan = $_POST["tgl_pelatihan"];
    $waktu = $_POST["waktu"];
    $nama_pelatihan = $_POST["nama_pelatihan"];
    $deskripsi = $_POST["deskripsi"];
    $tempat = $_POST["tempat"];
    $harga = intval($_POST["harga"]);
    $jml_peserta = intval($_POST["jml_peserta"]); // Konversi ke integer
    $kategori_program = $_POST["kategori_program"];
    $mitra = $_POST["mitra"];
    $tipe_kegiatan = $_POST["tipe_kegiatan"];
    $status_kegiatan = $_POST["status_kegiatan"];
    $pelaksanaan = $_POST["pelaksanaan"];

    $poster = $_FILES["poster"]["name"];
    $upload = move_uploaded_file($_FILES['poster']['tmp_name'], '../poster/' . $poster);

    $link_grub = $_POST["link_grub"];

    // Menangani upload file materi
    $materi = $_FILES["materi"]["name"];
    $upload_materi = move_uploaded_file($_FILES['materi']['tmp_name'], '../materi/' . $materi);

    $simpan = mysqli_query($conn, "INSERT INTO tbl_pelatihan VALUES(NULL, '$id_trainer', '$tgl_pelatihan', '$waktu', '$nama_pelatihan', '$deskripsi', '$tempat', $harga, $jml_peserta, '$kategori_program', '$mitra', '$tipe_kegiatan', '$status_kegiatan', '$pelaksanaan', '$poster', '$link_grub', '$materi')");

    if ($simpan) {
        header("Location: pelatihan.php");
    } else {
        header("Location: pelatihan-tambah.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title>Tambah Data Pelatihan</title>
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
                                    <h3 class="mt-4"><b>Tambah Data Pelatihan</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="pelatihan.php">Data Pelatihan</a></li>
                                        <li class="breadcrumb-item active">Tambah Data Pelatihan</li>
                                    </ol>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data" class="forms-sample">
                                    <div class="form-group row">
                                        <label for="tgl_pelatihan" class="col-sm-2 col-form-label">Tanggal Pelatihan</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control" id="tgl_pelatihan" name="tgl_pelatihan" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="waktu" class="col-sm-2 col-form-label">Waktu Pelatihan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="waktu" id="waktu" placeholder="Masukkan waktu pelatihan. contoh: 09.00-12.00 WITA" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="kategori_program" class="col-sm-2 col-form-label">Kategori Program</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <select name="kategori_program" id="kategori_program" class="form-control" required>
                                                    <option value="">-- Pilih Kategori Program --</option>
                                                    <option value="level up">Level Up</option>
                                                    <option value="psc">Professional Skill Certificate</option>
                                                    <option value="ap">Acceleration Program</option>
                                                    <option value="bootcamp">Bootcamp</option>
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="nama_pelatihan" class="col-sm-2 col-form-label">Nama Pelatihan</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="nama_pelatihan" id="nama_pelatihan" placeholder="Masukkan nama pelatihan" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="id_trainer" class="col-sm-2 col-form-label">Nama Trainer</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <select name="id_trainer" id="id_trainer" class="form-control" required>
                                                    <option value="">-- Pilih Trainer --</option>
                                                    <?php
                                                    // Query untuk mengambil data trainer dari tbl_trainer
                                                    $query = "SELECT id_trainer, nama_trainer FROM tbl_trainer";
                                                    $result = mysqli_query($conn, $query);

                                                    // Loop untuk menampilkan option
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . $row['id_trainer'] . '">' . $row['nama_trainer'] . '</option>';
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
                                        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi Pelatihan</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="10" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tempat" class="col-sm-2 col-form-label">Tempat</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="tempat" id="tempat" placeholder="Masukkan tempat pelatihan" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="harga" id="harga" placeholder="Masukkan harga (contoh: 75000, tanpa titik)" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="jml_peserta" class="col-sm-2 col-form-label">Jumlah Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="number" class="form-control" name="jml_peserta" id="jml_peserta" placeholder="Masukkan jumlah peserta" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="mitra" class="col-sm-2 col-form-label">Mitra</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="mitra" id="mitra" placeholder="Masukkan nama mitra yang bekerjasama" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tipe Kegiatan</label>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="tipe_kegiatan" id="tipe_kegiatan1" value="internal" <?php if ($tipe_kegiatan == 'internal') echo "SELECTED"; ?>> Internal </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="tipe_kegiatan" id="tipe_kegiatan2" value="eksternal" <?php if ($tipe_kegiatan == 'eksternal') echo "SELECTED"; ?>> Eksternal </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="status_kegiatan" class="col-sm-2 col-form-label">Status Kegiatan</label>
                                        <div class="col-sm-10">
                                            <div class="input-group">
                                                <select name="status_kegiatan" id="status_kegiatan" class="form-control" required>
                                                    <option value="">-- Pilih Status Kegiatan --</option>
                                                    <option value="on going">On Going</option>
                                                    <option value="done">Done</option>
                                                    <option value="postponed">Postponed</option>
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Pelaksanaan</label>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="pelaksanaan" id="pelaksanaan1" value="offline" <?php if ($pelaksanaan == 'offline') echo "SELECTED"; ?>> Offline </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="pelaksanaan" id="pelaksanaan2" value="online" <?php if ($pelaksanaan == 'online') echo "SELECTED"; ?>> Online </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="poster" class="col-sm-2 col-form-label">Poster Pelatihan</label>
                                        <div class="col-sm-10">
                                            <input type="file" class="form-control" name="poster" id="poster">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="link_grub" class="col-sm-2 col-form-label">Link WA Grub</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="link_grub" id="link_grub" placeholder="Masukkan link WA grub pelatihan ini">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="materi" class="col-sm-2 col-form-label">Materi</label>
                                        <div class="col-sm-10">
                                            <input type="file" id="materi" name="materi" class="form-control" accept="application/pdf">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-2">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Tambah</button>
                                            <a href="pelatihan.php" class="btn btn-light">Cancel</a>
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