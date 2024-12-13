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
    $result_pelatihan = mysqli_query($conn, "SELECT pelatihan.*, trainer.nama_trainer
                                                FROM tbl_pelatihan AS pelatihan
                                                JOIN tbl_trainer AS trainer ON pelatihan.id_trainer = trainer.id_trainer
                                                WHERE pelatihan.nama_pelatihan LIKE '%$searchQuery%'
                                                ORDER BY pelatihan.tgl_pelatihan
                                                LIMIT $mulai, $limit");
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                    FROM tbl_pelatihan AS pelatihan
                                                    JOIN tbl_trainer AS trainer ON pelatihan.id_trainer = trainer.id_trainer
                                                    WHERE pelatihan.nama_pelatihan LIKE '%$searchQuery%'");
} else {
    // Query default
    $result_pelatihan = mysqli_query($conn, "SELECT pelatihan.*, trainer.nama_trainer
                                                FROM tbl_pelatihan AS pelatihan
                                                JOIN tbl_trainer AS trainer ON pelatihan.id_trainer = trainer.id_trainer
                                                ORDER BY pelatihan.tgl_pelatihan
                                                LIMIT $mulai, $limit");
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                    FROM tbl_pelatihan AS pelatihan
                                                    JOIN tbl_trainer AS trainer ON pelatihan.id_trainer = trainer.id_trainer");
}

$total_records = mysqli_fetch_assoc($total_records_query)['total'];

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
    <title>Data Pelatihan</title>
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

        .img-kotak {
            border-radius: 0 !important;
            max-width: 100%;
            max-height: 100px;
            object-fit: contain;
        }

        .table {
            width: auto;
            table-layout: fixed;
        }

        .table td,
        .table th {
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            padding: 15px;
            min-width: 250px;
            /* Lebar minimal kolom */
            max-width: 300px;
            /* Lebar maksimal kolom */
            white-space: normal;
        }

        .table td img {
            max-width: 150px;
            max-height: 150px;
            width: auto;
            height: auto;
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
                                        <h3 class="mt-4"><b>Data Pelatihan</b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Data Pelatihan</li>
                                        </ol>
                                    </div>
                                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="search_query" class="form-control" placeholder="Search..." value="<?php if (isset($_GET['search_query'])) echo $_GET['search_query']; ?>">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </form>
                                    <a href="pelatihan-tambah.php" class="btn btn-outline-primary btn-fw">Tambah Data</a>
                                    <div class="table-responsive">
                                        <table class="table table-striped" height="auto">
                                            <thead>
                                                <tr>
                                                    <th> No </th>
                                                    <th> Tanggal & Waktu </th>
                                                    <th> Kategori Program </th>
                                                    <th> Nama Pelatihan </th>
                                                    <th> Nama Trainer </th>
                                                    <th> Deskripsi </th>
                                                    <th> Tempat </th>
                                                    <th> Harga </th>
                                                    <th> Jumlah Peserta </th>
                                                    <th> Mitra </th>
                                                    <th> Tipe Kegiatan </th>
                                                    <th> Status Kegiatan </th>
                                                    <th> Pelaksanaan </th>
                                                    <th> Poster </th>
                                                    <th> Link WA Grub </th>
                                                    <th> Materi </th>
                                                    <th> Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = $mulai + 1;
                                                while ($row_pelatihan = mysqli_fetch_assoc($result_pelatihan)) { ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td>
                                                            <?php
                                                            if (isset($row_pelatihan["tgl_pelatihan"]) && isset($row_pelatihan["waktu"])) {
                                                                $timestamp = strtotime($row_pelatihan["tgl_pelatihan"]);
                                                                $tanggal = date("j", $timestamp);
                                                                $bulan = date("n", $timestamp);
                                                                $tahun = date("Y", $timestamp);
                                                                $waktu = htmlspecialchars($row_pelatihan["waktu"]);
                                                                echo sprintf("%02d %s %d (%s)", $tanggal, getBulanIndonesia($bulan), $tahun, $waktu);
                                                            } else {
                                                                echo "Tanggal dan waktu tidak tersedia";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($row_pelatihan["kategori_program"] == "level up") { //kategori 1 (Level Up)
                                                                echo "<div class='btn btn-sm btn-danger'>Level Up</div>";
                                                            } else if ($row_pelatihan["kategori_program"] == "psc") { //kategori 2 (PSC)
                                                                echo "<div class='btn btn-sm btn-warning'>Professional Skill Certificate</div>";
                                                            } else if ($row_pelatihan["kategori_program"] == "ap") { //kategori 3 (AP)
                                                                echo "<div class='btn btn-sm btn-secondary'>Acceleration Program</div>";
                                                            } else if ($row_pelatihan["kategori_program"] == "bootcamp") { //kategori 4 (Bootcamp)
                                                                echo "<div class='btn btn-sm btn-success'>Bootcamp</div>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row_pelatihan["nama_pelatihan"] ?></td>
                                                        <td><?php echo $row_pelatihan["nama_trainer"] ?></td>
                                                        <td><?php echo $row_pelatihan["deskripsi"] ?></td>
                                                        <td><?php echo $row_pelatihan["tempat"] ?></td>
                                                        <td><?php echo 'Rp.' . number_format($row_pelatihan["harga"], 0, ',', '.'); ?></td>
                                                        <td><?php echo $row_pelatihan["jml_peserta"] ?></td>
                                                        <td><?php echo $row_pelatihan["mitra"] ?></td>
                                                        <td>
                                                            <?php
                                                            if ($row_pelatihan["tipe_kegiatan"] == "internal") { //tipe 1 (internal)
                                                                echo "<div class='btn btn-sm btn-secondary'>Internal</div>";
                                                            } else if ($row_pelatihan["tipe_kegiatan"] == "eksternal") { //tipe 2 (eksternal)
                                                                echo "<div class='btn btn-sm btn-warning'>Eksternal</div>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($row_pelatihan["status_kegiatan"] == "on going") { //status 1 (on going)
                                                                echo "<div class='btn btn-sm btn-secondary'>On Going</div>";
                                                            } else if ($row_pelatihan["status_kegiatan"] == "done") { //status 2 (done)
                                                                echo "<div class='btn btn-sm btn-success'>Done</div>";
                                                            } else if ($row_pelatihan["status_kegiatan"] == "postponed") { //status 3 (postponed)
                                                                echo "<div class='btn btn-sm btn-dark'>Postponed</div>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($row_pelatihan["pelaksanaan"] == "offline") { // 1 (offline)
                                                                echo "<div class='btn btn-sm btn-primary'>Offline</div>";
                                                            } else if ($row_pelatihan["pelaksanaan"] == "online") { //2 (online)
                                                                echo "<div class='btn btn-sm btn-secondary'>Online</div>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <img src="../poster/<?php echo $row_pelatihan["poster"] ?>" class="img-kotak" alt="Poster" width="100" height="100">
                                                        </td>
                                                        <td>
                                                            <?php if ($row_pelatihan['link_grub']) { ?>
                                                                <a href="<?php echo $row_pelatihan['link_grub']; ?>" target="_blank">Grub WA</a>
                                                            <?php } else { ?>
                                                                <span>No Link</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row_pelatihan['materi']) { ?>
                                                                <a href="../materi/<?php echo $row_pelatihan['materi']; ?>" target="_blank">Lihat</a>
                                                            <?php } else { ?>
                                                                <span>No File</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <a href="pelatihan-edit.php?id_pelatihan=<?php echo $row_pelatihan["id_pelatihan"]; ?>" class="btn btn-sm btn-outline-warning btn-fw">Edit</a>
                                                            <a href="#" class="btn btn-sm btn-outline-danger btn-fw delete-btn" data-id_pelatihan="<?php echo $row_pelatihan["id_pelatihan"]; ?>">Hapus</a>
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
                        // Redirect to pelatihan-hapus.php with id parameter
                        window.location = `pelatihan-hapus.php?id_pelatihan=${id_pelatihan}`;
                    }
                });
            });
        });
    </script>

</body>

</html>