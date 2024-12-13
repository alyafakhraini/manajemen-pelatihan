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

$limit = 50;
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

if (isset($_GET["id_pelatihan"])) {
    $id_pelatihan = $_GET["id_pelatihan"];

    $query_nama_pelatihan = mysqli_query($conn, "SELECT nama_pelatihan FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'");
    $nama_pelatihan = mysqli_fetch_assoc($query_nama_pelatihan)['nama_pelatihan'];

    $result_total = mysqli_query($conn, "SELECT COUNT(*) AS total
                                         FROM tbl_pendaftaran
                                         WHERE id_pelatihan = '$id_pelatihan'
                                         AND status_pembayaran = 'confirmed'");
    $total_records = mysqli_fetch_assoc($result_total)['total'];

    $result_daftar = mysqli_query($conn, "SELECT C.nama_peserta, C.telp_peserta, C.domisili, C.status_peserta, C.gender 
                                           FROM tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                                           WHERE D.id_pelatihan = P.id_pelatihan 
                                           AND D.id_peserta = C.id_peserta
                                           AND D.id_pelatihan = '$id_pelatihan' 
                                           AND D.status_pembayaran = 'confirmed'  
                                           LIMIT $mulai, $limit");
} else {
    $total_records = 0;
    $result_daftar = false;
    $nama_pelatihan = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title> Laporan Data Pendaftar</title>
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

        .table td,
        .table th {
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            padding: 15px;
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
                    <div class=row>

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="breadcrumb-container">
                                        <h3 class="mt-4"><b>Laporan Data Pendaftar <?php echo isset($_GET['id_pelatihan']) ? ' - ' . $nama_pelatihan : ''; ?></b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Laporan Data Pendaftar</li>
                                        </ol>
                                    </div>
                                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3 form-inline">
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-10">
                                                <div class="input-group">
                                                    <select name="id_pelatihan" id="id_pelatihan" class="form-control" required>
                                                        <option value="">-- Pilih Pelatihan --</option>
                                                        <?php
                                                        $query_pelatihan = mysqli_query($conn, "SELECT id_pelatihan, nama_pelatihan, kategori_program FROM tbl_pelatihan ORDER BY tgl_pelatihan DESC");
                                                        while ($row_pelatihan = mysqli_fetch_assoc($query_pelatihan)) {
                                                            // Menentukan teks kategori program
                                                            switch ($row_pelatihan["kategori_program"]) {
                                                                case 'level up':
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

                                                            // Menentukan opsi yang dipilih
                                                            $selected = ($row_pelatihan['id_pelatihan'] == $id_pelatihan) ? 'selected' : '';

                                                            // Menampilkan opsi dropdown
                                                            echo '<option value="' . $row_pelatihan['id_pelatihan'] . '" ' . $selected . '>' . $nama_pelatihan . '</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-sm btn-primary">Cari Data</button>
                                                <a href="report-pendaftar.php" class="btn btn-sm btn-secondary ml-2">Reset</a>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <?php if (isset($_GET["id_pelatihan"]) && $result_daftar && mysqli_num_rows($result_daftar) > 0) { ?>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th> No </th>
                                                        <th> Nama Peserta </th>
                                                        <th> Gender </th>
                                                        <th> Domisili </th>
                                                        <th> Status </th>
                                                        <th> Kontak </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $no = $mulai + 1;
                                                    while ($row_daftar = mysqli_fetch_assoc($result_daftar)) { ?>
                                                        <tr>
                                                            <td><?php echo $no++; ?></td>
                                                            <td><?php echo $row_daftar["nama_peserta"]; ?></td>
                                                            <td>
                                                                <?php
                                                                if ($row_daftar["gender"] == "lk") { // 1 (laki-laki)
                                                                    echo "<div class='btn btn-sm btn-secondary'>Laki-laki</div>";
                                                                } else if ($row_daftar["gender"] == "pr") { //2 (perempuan)
                                                                    echo "<div class='btn btn-sm btn-success'>Perempuan</div>";
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?php echo $row_daftar["domisili"]; ?></td>
                                                            <td><?php echo $row_daftar["status_peserta"]; ?></td>
                                                            <td><?php echo $row_daftar["telp_peserta"]; ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>

                                            <p>Jumlah Data: <?php echo $total_records; ?></p>
                                            <nav class="mb-5">
                                                <ul class="pagination justify-content-end">
                                                    <?php
                                                    $jumlah_page = ceil($total_records / $limit);
                                                    $jumlah_number = 1; // jumlah halaman ke kanan dan ke kiri dari halaman yang aktif
                                                    $start_number = ($page > $jumlah_number) ? $page - $jumlah_number : 1;
                                                    $end_number = ($page < ($jumlah_page - $jumlah_number)) ? $page + $jumlah_number : $jumlah_page;

                                                    if ($page == 1) {
                                                        echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
                                                        echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
                                                    } else {
                                                        $link_prev = ($page > 1) ? $page - 1 : 1;
                                                        echo '<li class="page-item"><a class="page-link" href="?halaman=1">First</a></li>';
                                                        echo '<li class="page-item"><a class="page-link" href="?halaman=' . $link_prev . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                                                    }

                                                    for ($i = $start_number; $i <= $end_number; $i++) {
                                                        $link_active = ($page == $i) ? 'active' : '';
                                                        echo '<li class="page-item ' . $link_active . '"><a class="page-link" href="?halaman=' . $i . '">' . $i . '</a></li>';
                                                    }

                                                    if ($page == $jumlah_page) {
                                                        echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
                                                        echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
                                                    } else {
                                                        $link_next = ($page < $jumlah_page) ? $page + 1 : $jumlah_page;
                                                        echo '<li class="page-item"><a class="page-link" href="?halaman=' . $link_next . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
                                                        echo '<li class="page-item"><a class="page-link" href="?halaman=' . $jumlah_page . '">Last</a></li>';
                                                    }
                                                    ?>
                                                </ul>
                                            </nav>
                                            <a href="print-pendaftar.php?id_pelatihan=<?= $id_pelatihan ?>" class="btn btn-primary btn-icon-text" target="_blank">Print PDF <i class="ti-printer btn-icon-append"></i></a>
                                        <?php } elseif (isset($_GET["id_pelatihan"]) && mysqli_num_rows($result_presensi) == 0) { ?>
                                            <br>
                                            <h5 style="color: #ec4c3b; font-weight: bold; text-align: center; margin-top: 20px;">
                                                <i class="fas fa-info-circle"></i> Belum ada peserta terdaftar untuk pelatihan ini.
                                            </h5>
                                        <?php } else { ?>
                                            <br>
                                            <h5 style="color: #007bff; font-weight: bold; text-align: center; margin-top: 20px;">
                                                <i class="fas fa-info-circle"></i> Silahkan pilih pelatihan untuk melihat data!
                                            </h5>
                                        <?php } ?>
                                    </div>

                                </div>
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