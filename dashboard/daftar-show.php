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
$limit = 50;
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

// Menangkap ID dari halaman sebelumnya jika ada
$id_pelatihan = isset($_GET['id_pelatihan']) ? (int)$_GET['id_pelatihan'] : 0;

$nama_pelatihan = "";
$tgl_pelatihan = "";
$searchQuery = "";

// Mengambil detail pelatihan jika id_pelatihan tersedia
if ($id_pelatihan > 0) {
    $pelatihan_detail_query = "SELECT nama_pelatihan, tgl_pelatihan FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'";

    $pelatihan_detail_result = mysqli_query($conn, $pelatihan_detail_query);

    if ($pelatihan_detail_result && mysqli_num_rows($pelatihan_detail_result) > 0) {
        $pelatihan_detail = mysqli_fetch_assoc($pelatihan_detail_result);
        $nama_pelatihan = $pelatihan_detail['nama_pelatihan'];
        $tgl_pelatihan = $pelatihan_detail['tgl_pelatihan'];
    }
}

if (isset($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_pendaftaran JOIN tbl_peserta ON tbl_pendaftaran.id_peserta = tbl_peserta.id_peserta WHERE tbl_peserta.nama_peserta LIKE '%$searchQuery%' AND tbl_pendaftaran.id_pelatihan = '$id_pelatihan'");
    $total_records = mysqli_fetch_assoc($total_records_query)['total'];

    $result_daftar_query = "SELECT daftar.*, pelatihan.nama_pelatihan, peserta.nama_peserta
        FROM tbl_pendaftaran AS daftar
        JOIN tbl_pelatihan AS pelatihan ON daftar.id_pelatihan = pelatihan.id_pelatihan
        JOIN tbl_peserta AS peserta ON daftar.id_peserta = peserta.id_peserta
        WHERE peserta.nama_peserta LIKE '%$searchQuery%' AND daftar.id_pelatihan = '$id_pelatihan'
        LIMIT $mulai, $limit
    ";
    $result_daftar = mysqli_query($conn, $result_daftar_query);
} else {
    if ($id_pelatihan > 0) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                    FROM tbl_pendaftaran AS daftar
                                                    JOIN tbl_pelatihan AS pelatihan ON daftar.id_pelatihan = pelatihan.id_pelatihan
                                                    JOIN tbl_peserta AS peserta ON daftar.id_peserta = peserta.id_peserta
                                                    WHERE pelatihan.id_pelatihan = '$id_pelatihan'");

        $total_records = mysqli_fetch_assoc($total_records_query)['total'];

        $result_daftar_query = "SELECT daftar.*, pelatihan.nama_pelatihan, peserta.nama_peserta
                                FROM tbl_pendaftaran AS daftar
                                JOIN tbl_pelatihan AS pelatihan ON daftar.id_pelatihan = pelatihan.id_pelatihan
                                JOIN tbl_peserta AS peserta ON daftar.id_peserta = peserta.id_peserta
                                WHERE pelatihan.id_pelatihan = '$id_pelatihan'
                                ORDER BY daftar.tgl_daftar
                                LIMIT $mulai, $limit";

        $result_daftar = mysqli_query($conn, $result_daftar_query);
    } else {
        $total_records = 0;
        $result_daftar = false;
    }
}

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
    <title>Data Pendaftar - <?php echo htmlspecialchars($nama_pelatihan); ?></title>
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

        .table td,
        .table th {
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            padding: 15px;
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
                                        <h3 class="mt-4"><b>Data Pendaftar - <?php echo htmlspecialchars($nama_pelatihan); ?> (<?php echo date("d F Y", strtotime($tgl_pelatihan)); ?>)</b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="daftar-pelatihan-list.php">Pilih Pelatihan</a></li>
                                            <li class="breadcrumb-item active">Data Pendaftar - <?php echo htmlspecialchars($nama_pelatihan); ?></li>
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
                                                    <th>Waktu Pendaftaran</th>
                                                    <th>Metode Pembayaran</th>
                                                    <th>Jumlah Pembayaran</th>
                                                    <th>Bukti Pembayaran</th>
                                                    <th>Status Pembayaran</th>
                                                    <th>Kwitansi</th>
                                                    <th>Action</th>
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
                                                            if (isset($row_daftar["tgl_daftar"])) {
                                                                $tgl_daftar = $row_daftar["tgl_daftar"];
                                                                $timestamp = strtotime($tgl_daftar);
                                                                $bulan = date("n", $timestamp);
                                                                $tahun = date("Y", $timestamp);
                                                                $tanggal = date("j", $timestamp);
                                                                $jam = date("H:i:s", $timestamp);
                                                                echo sprintf("%02d %s %d %s", $tanggal, getBulanIndonesia($bulan), $tahun, $jam);
                                                            } else {
                                                                echo "Tanggal tidak tersedia";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($row_daftar["metode_pembayaran"] == "tf") { //1 (transfer)
                                                                echo "<div class='btn btn-sm btn-info'>Transfer (Mandiri an. YHC)</div>";
                                                            } else if ($row_daftar["metode_pembayaran"] == "cash") { //2 (cash)
                                                                echo "<div class='btn btn-sm btn-primary'>Cash</div>";
                                                            }
                                                            ?>
                                                        </td>
                                                        <td><?php echo 'Rp.' . number_format($row_daftar["jml_pembayaran"], 0, ',', '.'); ?></td>
                                                        <td>
                                                            <img src="../bukpem/<?php echo $row_daftar["bukpem"]; ?>" class="img-kotak" alt="bukpem" width="100" height="100">
                                                        </td>
                                                        <td>
                                                            <?php if ($row_daftar["status_pembayaran"] == "confirmed") { ?>
                                                                <span class="btn btn-sm btn-success">Confirmed</span>
                                                            <?php } elseif ($row_daftar["status_pembayaran"] == "failed") { ?>
                                                                <button class="btn btn-sm btn-outline-success btn-fw confirm-btn" data-id_pendaftaran="<?php echo $row_daftar['id_pendaftaran']; ?>" data-id_pelatihan="<?php echo $id_pelatihan; ?>">Konfirmasi Sukses</button>
                                                                <button class="btn btn-sm btn-outline-danger btn-fw fail-btn" data-id_pendaftaran="<?php echo $row_daftar['id_pendaftaran']; ?>" data-id_pelatihan="<?php echo $id_pelatihan; ?>">Konfirmasi Gagal</button>
                                                            <?php } else { ?>
                                                                <button class="btn btn-sm btn-outline-success btn-fw confirm-btn" data-id_pendaftaran="<?php echo $row_daftar['id_pendaftaran']; ?>" data-id_pelatihan="<?php echo $id_pelatihan; ?>">Konfirmasi Sukses</button>
                                                                <button class="btn btn-sm btn-outline-danger btn-fw fail-btn" data-id_pendaftaran="<?php echo $row_daftar['id_pendaftaran']; ?>" data-id_pelatihan="<?php echo $id_pelatihan; ?>">Konfirmasi Gagal</button>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($row_daftar["status_pembayaran"] == "confirmed") { ?>
                                                                <a href="print-kwitansi.php?id_pendaftaran=<?php echo $row_daftar['id_pendaftaran']; ?>" target="_blank">Lihat Kwitansi</a>
                                                            <?php } else { ?>
                                                                <span class="btn btn-sm btn-warning">Belum tersedia</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <a href="daftar-edit.php?id=<?php echo $row_daftar["id_pendaftaran"]; ?>" class="btn btn-sm btn-outline-warning btn-fw">Edit</a>
                                                            <a class="btn btn-sm btn-outline-danger btn-fw delete-btn" data-id_pendaftaran="<?php echo $row_daftar["id_pendaftaran"]; ?>" data-id_pelatihan="<?php echo $id_pelatihan; ?>">Hapus</a>
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
            // SweetAlert Confirm Payment Success
            $('.confirm-btn').click(function(e) {
                e.preventDefault();
                var id_pendaftaran = $(this).data('id_pendaftaran');
                var id_pelatihan = $(this).data('id_pelatihan');

                Swal.fire({
                    title: 'Anda yakin ingin mengkonfirmasi pembayaran ini?',
                    text: "Pembayaran akan dikonfirmasi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Konfirmasi!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = `daftar-konfirmasi-pembayaran.php?id_pendaftaran=${id_pendaftaran}&id_pelatihan=${id_pelatihan}&status_pembayaran=confirmed`;
                    }
                });
            });

            // SweetAlert Confirm Payment Failure
            $('.fail-btn').click(function(e) {
                e.preventDefault();
                var id_pendaftaran = $(this).data('id_pendaftaran');
                var id_pelatihan = $(this).data('id_pelatihan');

                Swal.fire({
                    title: 'Masukkan alasan kenapa pembayaran gagal',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'on'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    showLoaderOnConfirm: true,
                    preConfirm: (keterangan) => {
                        if (!keterangan) {
                            Swal.showValidationMessage(`Alasan tidak boleh kosong`)
                        } else {
                            return keterangan;
                        }
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = `daftar-konfirmasi-pembayaran.php?id_pendaftaran=${id_pendaftaran}&id_pelatihan=${id_pelatihan}&status_pembayaran=failed&keterangan=${encodeURIComponent(result.value)}`;
                    }
                });
            });

            // SweetAlert Delete Confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var id_pendaftaran = $(this).data('id_pendaftaran');
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
                        window.location = `daftar-hapus.php?id_pendaftaran=${id_pendaftaran}&id_pelatihan=${id_pelatihan}`;
                    }
                });
            });
        });
    </script>

</body>

</html>