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

// Inisialisasi variabel
$limit = 50;
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

$id_pelatihan = isset($_GET['id_pelatihan']) ? (int)$_GET['id_pelatihan'] : 0;

$nama_pelatihan = "";
$tgl_pelatihan = "";
$searchQuery = "";

// Mengambil detail pelatihan jika id_pelatihan tersedia
if ($id_pelatihan > 0) {
    $pelatihan_detail_query = "SELECT nama_pelatihan, tgl_pelatihan
                                FROM tbl_pelatihan
                                WHERE id_pelatihan = '$id_pelatihan'";

    $pelatihan_detail_result = mysqli_query($conn, $pelatihan_detail_query);

    if ($pelatihan_detail_result && mysqli_num_rows($pelatihan_detail_result) > 0) {
        $pelatihan_detail = mysqli_fetch_assoc($pelatihan_detail_result);
        $nama_pelatihan = $pelatihan_detail['nama_pelatihan'];
        $tgl_pelatihan = $pelatihan_detail['tgl_pelatihan'];
    }
}

if (isset($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total
                                            FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_peserta C, tbl_pelatihan P
                                            WHERE H.id_pendaftaran = D.id_pendaftaran
                                            AND D.id_pelatihan = P.id_pelatihan
                                            AND D.id_peserta = C.id_peserta
                                            AND C.nama_peserta LIKE '%$searchQuery%'
                                            AND P.id_pelatihan = '$id_pelatihan'
                                            AND D.status_pembayaran = 'confirmed'");
    $total_records = mysqli_fetch_assoc($total_records_query)['total'];

    $result_kehadiran_query = "SELECT H.id_kehadiran, P.nama_pelatihan, C.nama_peserta, D.status_pembayaran, H.status_kehadiran
                            FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                            WHERE H.id_pendaftaran = D.id_pendaftaran
                            AND D.id_pelatihan = P.id_pelatihan
                            AND D.id_peserta = C.id_peserta
                            AND C.nama_peserta LIKE '%$searchQuery%'
                            AND P.id_pelatihan = '$id_pelatihan'
                            AND D.status_pembayaran = 'confirmed'
                            LIMIT $mulai, $limit";
    $result_kehadiran = mysqli_query($conn, $result_kehadiran_query);
} else {
    if ($id_pelatihan > 0) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                    FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                                                    WHERE H.id_pendaftaran = D.id_pendaftaran
                                                    AND D.id_pelatihan = P.id_pelatihan
                                                    AND D.id_peserta = C.id_peserta
                                                    AND P.id_pelatihan = '$id_pelatihan'
                                                    AND D.status_pembayaran = 'confirmed'");

        $total_records = mysqli_fetch_assoc($total_records_query)['total'];

        $result_kehadiran_query = "SELECT H.id_kehadiran, P.nama_pelatihan, C.nama_peserta, D.status_pembayaran,
                                            H.status_kehadiran, H.nilai, H.saran, D.id_pelatihan, D.id_peserta
                                    FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                                    WHERE H.id_pendaftaran = D.id_pendaftaran
                                    AND D.id_pelatihan = P.id_pelatihan
                                    AND D.id_peserta = C.id_peserta
                                    AND P.id_pelatihan = '$id_pelatihan'
                                    AND D.status_pembayaran = 'confirmed'
                                    LIMIT $mulai, $limit";
        $result_kehadiran = mysqli_query($conn, $result_kehadiran_query);
    } else {
        $total_records = 0;
        $result_kehadiran = false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title> Data kehadiran Peserta</title>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
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
                    <div class="row">

                        <div class="col-lg-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="breadcrumb-container">
                                        <h3 class="mt-4"><b>Data Performa Peserta - <?php echo htmlspecialchars($nama_pelatihan); ?> (<?php echo date("d F Y", strtotime($tgl_pelatihan)); ?>)</b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="kehadiran-pelatihan-list.php">Pilih Pelatihan</a></li>
                                            <li class="breadcrumb-item active">Data Performa Peserta - <?php echo htmlspecialchars($nama_pelatihan); ?> (<?php echo date("d F Y", strtotime($tgl_pelatihan)); ?>)</li>
                                        </ol>
                                    </div>
                                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3">
                                        <input type="hidden" name="id_pelatihan" value="<?php echo $id_pelatihan; ?>">
                                        <div class="input-group">
                                            <input type="text" name="search_query" class="form-control" placeholder="Search..." value="<?php if (isset($_GET['search_query'])) echo $_GET['search_query']; ?>">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </form>
                                    <div class="table-responsive">
                                        <table class="table table-striped" height="auto">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Peserta</th>
                                                    <th>Status Kehadiran</th>
                                                    <th>Nilai</th>
                                                    <th>Saran</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = $mulai + 1;
                                                while ($row_kehadiran = mysqli_fetch_assoc($result_kehadiran)) { ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $row_kehadiran["nama_peserta"]; ?></td>
                                                        <td>
                                                            <?php if ($row_kehadiran["status_kehadiran"] == "hadir") { ?>
                                                                <span class="btn btn-sm btn-success">Hadir</span>
                                                            <?php } elseif ($row_kehadiran["status_kehadiran"] == "tidak hadir") { ?>
                                                                <span class="btn btn-sm btn-danger">Tidak Hadir</span>
                                                            <?php } else { ?>
                                                                <button class="btn btn-sm btn-outline-primary btn-fw hadir-btn" data-id_kehadiran="<?php echo $row_kehadiran['id_kehadiran']; ?>" data-id_pelatihan="<?php echo $id_pelatihan; ?>" data-id_peserta="<?php echo $row_kehadiran['id_peserta']; ?>">Konfirmasi Kehadiran</button>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo $row_kehadiran["nilai"]; ?></td>
                                                        <td><?php echo $row_kehadiran["saran"]; ?></td>
                                                        <td>
                                                            <a href="kehadiran-edit.php?id=<?php echo $row_kehadiran["id_kehadiran"]; ?>" class="btn btn-sm btn-outline-warning btn-fw">Edit</a>
                                                            <a class="btn btn-sm btn-outline-danger btn-fw delete-btn" data-id_kehadiran="<?php echo $row_kehadiran["id_kehadiran"]; ?>" data-id_pelatihan="<?php echo $id_pelatihan; ?>">Hapus</a>
                                                        </td>
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

                                    </div>
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
    <script>
        $(document).ready(function() {
            // SweetAlert Confirm Payment
            $('.hadir-btn').click(function(e) {
                e.preventDefault();
                var id_kehadiran = $(this).data('id_kehadiran');
                var id_pelatihan = $(this).data('id_pelatihan');
                var id_peserta = $(this).data('id_peserta');

                Swal.fire({
                    title: 'Anda yakin ingin mengkonfirmasi kehadiran peserta ini?',
                    text: "Kehadiran peserta akan dikonfirmasi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Konfirmasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = `kehadiran-konfirmasi.php?id_kehadiran=${id_kehadiran}&id_pelatihan=${id_pelatihan}&id_peserta=${id_peserta}`;
                    }
                });
            });

            // SweetAlert Delete Confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var id_kehadiran = $(this).data('id_kehadiran');
                var id_pelatihan = $(this).data('id_pelatihan');

                Swal.fire({
                    title: 'Anda yakin ingin menghapus data ini?',
                    text: "Data yang dihapus tidak bisa dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = `kehadiran-hapus.php?id_kehadiran=${id_kehadiran}&id_pelatihan=${id_pelatihan}`;
                    }
                });
            });
        });
    </script>

</body>

</html>