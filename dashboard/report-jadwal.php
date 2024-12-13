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

$total_records = 0;
$result_pelatihan = false;
$result_agenda = false;

if (isset($_GET["bulan"]) && isset($_GET["tahun"])) {

    $bulan = $_GET["bulan"];
    $tahun = $_GET["tahun"];
    $bulanan = $tahun . '-' . str_pad($bulan, 2, '0', STR_PAD_LEFT) . '%';

    $result_total_pelatihan = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                   FROM tbl_pelatihan
                                                   WHERE tgl_pelatihan LIKE '$bulanan'");
    $result_total_agenda = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                FROM tbl_agenda
                                                WHERE tgl_agenda LIKE '$bulanan'");

    $total_pelatihan = mysqli_fetch_assoc($result_total_pelatihan)['total'];
    $total_agenda = mysqli_fetch_assoc($result_total_agenda)['total'];
    $total_records = $total_pelatihan + $total_agenda;

    $result_pelatihan = mysqli_query($conn, "SELECT *, 'pelatihan' AS tipe
                                             FROM tbl_pelatihan
                                             WHERE tgl_pelatihan LIKE '$bulanan'
                                             LIMIT $mulai, $limit");
    $result_agenda = mysqli_query($conn, "SELECT *, 'agenda' AS tipe
                                          FROM tbl_agenda
                                          WHERE tgl_agenda LIKE '$bulanan'
                                          LIMIT $mulai, $limit");
}

$rows_pelatihan = [];
$rows_agenda = [];
if ($result_pelatihan) $rows_pelatihan = mysqli_fetch_all($result_pelatihan, MYSQLI_ASSOC);
if ($result_agenda) $rows_agenda = mysqli_fetch_all($result_agenda, MYSQLI_ASSOC);

$rows = array_merge($rows_pelatihan, $rows_agenda);
usort($rows, function ($a, $b) {
    return strtotime($a['tgl_pelatihan'] ?? $a['tgl_agenda']) <=> strtotime($b['tgl_pelatihan'] ?? $b['tgl_agenda']);
});

function getBulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
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
    <title> Laporan Jadwal Pelatihan & Agenda BCTI Per Bulan</title>
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
            max-width: 300px;
            white-space: normal;
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
                                        <h3 class="mt-4"><b>Laporan Jadwal Pelatihan & Agenda BCTI Per Bulan</b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Laporan Jadwal Pelatihan & Agenda BCTI Per Bulan</li>
                                        </ol>
                                    </div>
                                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3 form-inline">
                                        <div class="form-group row align-items-center">
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <select name="bulan" id="bulan" class="form-control" required>
                                                        <option value="">-- Pilih Bulan --</option>
                                                        <?php for ($i = 1; $i <= 12; $i++) : ?>
                                                            <option value="<?php echo $i; ?>" <?php if (isset($bulan) && $bulan == $i) echo "SELECTED"; ?>>
                                                                <?php echo getBulanIndonesia($i); ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="input-group">
                                                    <select name="tahun" id="tahun" class="form-control" required>
                                                        <option value="">-- Pilih Tahun --</option>
                                                        <?php
                                                        $start_year = 2023;
                                                        $end_year = date("Y"); // Tahun saat ini
                                                        for ($i = $start_year; $i <= $end_year; $i++) : ?>
                                                            <option value="<?php echo $i; ?>" <?php if (isset($tahun) && $tahun == $i) echo "SELECTED"; ?>>
                                                                <?php echo $i; ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                    <span class="input-group-text">
                                                        <i class="fas fa-caret-down"></i>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-sm btn-primary">Cari Data</button>
                                                <a href="report-jadwal.php" class="btn btn-sm btn-secondary ml-2">Reset</a>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <?php if (isset($bulan)) : ?>
                                            <?php if ($total_records > 0) : ?>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th> No </th>
                                                            <th> Tanggal </th>
                                                            <th> Nama Acara </th>
                                                            <th> Deskripsi </th>
                                                            <th> Tempat </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $no = $mulai + 1;
                                                        foreach ($rows as $row) {
                                                            $tanggal = date("d", strtotime($row["tgl_pelatihan"] ?? $row["tgl_agenda"])) . " " . getBulanIndonesia(date("n", strtotime($row["tgl_pelatihan"] ?? $row["tgl_agenda"]))) . " " . date("Y", strtotime($row["tgl_pelatihan"] ?? $row["tgl_agenda"]));
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $no++; ?></td>
                                                                <td><?php echo $tanggal; ?></td>
                                                                <td><?php echo $row["nama_pelatihan"] ?? $row["nama_agenda"]; ?></td>
                                                                <td><?php echo $row["deskripsi"] ?? "-"; ?></td>
                                                                <td><?php echo $row["tempat"] ?? $row["tujuan_tempat"]; ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>

                                                <p>Jumlah Data: <?php echo $total_records; ?></p>
                                                <nav class="mb-5">
                                                    <ul class="pagination justify-content-end">
                                                        <?php
                                                        $jumlah_page = ceil($total_records / $limit);
                                                        $jumlah_number = 1;
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
                                                <a href="print-jadwal.php?bulan=<?= $bulan ?>&tahun=<?= $tahun ?>" class="btn btn-primary btn-icon-text" target="_blank">Print PDF<i class="ti-printer btn-icon-append"></i></a>
                                            <?php else : ?>
                                                <br>
                                                <h5 style="color: #ec4c3b; font-weight: bold; text-align: center; margin-top: 20px;">
                                                    <i class="fas fa-info-circle"></i> Belum ada jadwal!
                                                </h5>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <br>
                                            <h5 style="color: #007bff; font-weight: bold; text-align: center; margin-top: 20px;">
                                                <i class="fas fa-info-circle"></i> Silahkan pilih bulan untuk melihat data!
                                            </h5>
                                        <?php endif; ?>
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