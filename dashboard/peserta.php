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

// Inisialisasi variabel
$searchQuery = '';
$limit = 50;
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

// Jika ada pencarian
if (isset($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    $result_peserta = mysqli_query($conn, "SELECT * FROM tbl_peserta WHERE nama_peserta LIKE '%$searchQuery%' LIMIT $mulai, $limit");
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_peserta WHERE nama_peserta LIKE '%$searchQuery%'");
} else {
    // Query default
    $result_peserta = mysqli_query($conn, "SELECT U.username, C.id_peserta, C.nama_peserta, C.email, C.telp_peserta, C.gender, C.domisili, C.status_peserta, C.komunitas
                                           FROM tbl_peserta C, tbl_user U
                                           WHERE C.id_user = U.id_user
                                           LIMIT $mulai, $limit");
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_peserta");
}

$total_records = mysqli_fetch_assoc($total_records_query)['total'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title>Data Peserta</title>
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

        .img-kotak {
            border-radius: 0 !important;
            max-width: 100%;
            max-height: 100px;
            object-fit: contain;
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
                                        <h3 class="mt-4"><b>Data Peserta</b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Data Peserta</li>
                                        </ol>
                                    </div>
                                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3">
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
                                                    <th>Username Akun</th>
                                                    <th>Nama Peserta</th>
                                                    <th>Email</th>
                                                    <th>Nomor Telepon</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Domisili</th>
                                                    <th>Status</th>
                                                    <th>Komunitas</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tbody>
                                                <?php
                                                $no = $mulai + 1;
                                                while ($row_peserta = mysqli_fetch_assoc($result_peserta)) { ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $row_peserta["username"] ?></td>
                                                        <td><?php echo $row_peserta["nama_peserta"] ?></td>
                                                        <td><?php echo $row_peserta["email"] ?></td>
                                                        <td><?php echo $row_peserta["telp_peserta"] ?></td>
                                                        <td>
                                                            <?php
                                                            if ($row_peserta["gender"] == "lk") { // 1 (laki-laki)
                                                                echo "<div class='btn btn-sm btn-secondary'>Laki-laki</div>";
                                                            } else if ($row_peserta["gender"] == "pr") { //2 (perempuan)
                                                                echo "<div class='btn btn-sm btn-success'>Perempuan</div>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row_peserta["domisili"] ?></td>
                                                        <td><?php echo $row_peserta["status_peserta"] ?></td>
                                                        <td><?php echo $row_peserta["komunitas"] ?></td>
                                                        <td>
                                                            <a href="peserta-edit.php?id_peserta=<?php echo $row_peserta["id_peserta"]; ?>" class="btn btn-sm btn-outline-warning btn-fw">Edit</a>
                                                            <a href="#" class="btn btn-sm btn-outline-danger btn-fw delete-btn" data-id_peserta="<?php echo $row_peserta["id_peserta"]; ?>">Hapus</a>
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
    <script>
        $(document).ready(function() {
            // SweetAlert Delete Confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var id_peserta = $(this).data('id_peserta');

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
                        // Redirect to pelatihan-hapus.php with id parameter
                        window.location = `peserta-hapus.php?id_peserta=${id_peserta}`;
                    }
                });
            });
        });
    </script>
</body>

</html>