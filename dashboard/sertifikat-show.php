<?php
session_start();
include "../koneksi.php";

// Inisialisasi variabel
$limit = 50;
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$mulai = ($page > 1) ? ($page * $limit) - $limit : 0;

$id_pelatihan = isset($_GET['id_pelatihan']) ? (int)$_GET['id_pelatihan'] : 0;

$nama_pelatihan = "";
$tgl_pelatihan = "";
$searchQuery = "";

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

// Mengambil detail pelatihan jika id_pelatihan tersedia
if ($id_pelatihan > 0) {
    $pelatihan_detail_query = "SELECT nama_pelatihan, tgl_pelatihan FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'";
    $pelatihan_detail_result = mysqli_query($conn, $pelatihan_detail_query);

    if ($pelatihan_detail_result && mysqli_num_rows($pelatihan_detail_result) > 0) {
        $pelatihan_detail = mysqli_fetch_assoc($pelatihan_detail_result);
        $nama_pelatihan = $pelatihan_detail['nama_pelatihan'];
        $tgl_pelatihan = $pelatihan_detail['tgl_pelatihan'];

        // Format tanggal pelatihan
        $timestamp = strtotime($tgl_pelatihan);
        $day = date("d", $timestamp);
        $month = getBulanIndonesia(date("n", $timestamp));
        $year = date("Y", $timestamp);
        $formatted_tgl_pelatihan = "$day $month $year";
    }
}

if (isset($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                FROM tbl_sertifikat AS sertif
                                                JOIN tbl_kehadiran AS hadir ON sertif.id_kehadiran = hadir.id_kehadiran
                                                JOIN tbl_pelatihan AS pelatihan ON sertif.id_pelatihan = pelatihan.id_pelatihan
                                                JOIN tbl_peserta AS peserta ON sertif.id_peserta = peserta.id_peserta
                                                WHERE peserta.nama_peserta LIKE '%$searchQuery%'
                                                AND pelatihan.id_pelatihan = '$id_pelatihan'
                                                AND hadir.status_kehadiran = 'hadir'");
    $total_records = mysqli_fetch_assoc($total_records_query)['total'];

    $result_sertifikat_query = "SELECT sertif.*, pelatihan.nama_pelatihan, peserta.nama_peserta, hadir.status_kehadiran
                                FROM tbl_sertifikat AS sertif
                                JOIN tbl_kehadiran AS hadir ON sertif.id_kehadiran = hadir.id_kehadiran
                                JOIN tbl_pelatihan AS pelatihan ON sertif.id_pelatihan = pelatihan.id_pelatihan
                                JOIN tbl_peserta AS peserta ON sertif.id_peserta = peserta.id_peserta
                                WHERE peserta.nama_peserta LIKE '%$searchQuery%'
                                AND pelatihan.id_pelatihan = '$id_pelatihan'
                                AND hadir.status_kehadiran = 'hadir'
                                LIMIT $mulai, $limit";
    $result_sertifikat = mysqli_query($conn, $result_sertifikat_query);
} else {
    if ($id_pelatihan > 0) {
        $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total
                                                    FROM tbl_sertifikat AS sertif
                                                    JOIN tbl_kehadiran AS hadir ON sertif.id_kehadiran = hadir.id_kehadiran
                                                    JOIN tbl_pelatihan AS pelatihan ON sertif.id_pelatihan = pelatihan.id_pelatihan
                                                    JOIN tbl_peserta AS peserta ON sertif.id_peserta = peserta.id_peserta
                                                    WHERE pelatihan.id_pelatihan = '$id_pelatihan'
                                                    AND hadir.status_kehadiran = 'hadir'");
        $total_records = mysqli_fetch_assoc($total_records_query)['total'];

        $result_sertifikat_query = "SELECT sertif.*, pelatihan.nama_pelatihan, peserta.nama_peserta, hadir.status_kehadiran
                                    FROM tbl_sertifikat AS sertif
                                    JOIN tbl_kehadiran AS hadir ON sertif.id_kehadiran = hadir.id_kehadiran
                                    JOIN tbl_pelatihan AS pelatihan ON sertif.id_pelatihan = pelatihan.id_pelatihan
                                    JOIN tbl_peserta AS peserta ON sertif.id_peserta = peserta.id_peserta
                                    WHERE pelatihan.id_pelatihan = '$id_pelatihan'
                                    AND hadir.status_kehadiran = 'hadir'
                                    LIMIT $mulai, $limit";
        $result_sertifikat = mysqli_query($conn, $result_sertifikat_query);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title>Data Sertifikat Peserta</title>
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
                                        <h3 class="mt-4"><b>Data Sertifikat Peserta - <?php echo htmlspecialchars($nama_pelatihan); ?> (<?php echo $formatted_tgl_pelatihan; ?>)</b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="sertifikat-pelatihan-list.php">Pilih Pelatihan</a></li>
                                            <li class="breadcrumb-item active">Data Sertifikat Peserta - <?php echo htmlspecialchars($nama_pelatihan); ?> (<?php echo $formatted_tgl_pelatihan; ?>)</li>
                                        </ol>
                                    </div>

                                    <?php

                                    // Inisialisasi variabel
                                    $id_pelatihan = isset($_GET['id_pelatihan']) ? (int)$_GET['id_pelatihan'] : 0;

                                    // Default values
                                    $nomor_sertifikat_mulai = "";
                                    $format_sertifikat = "";
                                    $tgl_terbit_sertif = "";

                                    // Fetch data for form fields
                                    $sertifikat_query = "SELECT no_sertif, tgl_terbit_sertif
                                                        FROM tbl_sertifikat
                                                        WHERE id_pelatihan = '$id_pelatihan'
                                                        LIMIT 1";
                                    $sertifikat_result = mysqli_query($conn, $sertifikat_query);

                                    if ($sertifikat_result && mysqli_num_rows($sertifikat_result) > 0) {
                                        $row_sertif = mysqli_fetch_assoc($sertifikat_result);
                                        $nomor_sertifikat_full = $row_sertif['no_sertif'];
                                        $tgl_terbit_sertif = $row_sertif['tgl_terbit_sertif'];

                                        // Split nomor_sertifikat and format_sertifikat
                                        $nomor_sertifikat_parts = explode('/', $nomor_sertifikat_full);
                                        $nomor_sertifikat_mulai = $nomor_sertifikat_parts[0];
                                        unset($nomor_sertifikat_parts[0]);
                                        $format_sertifikat = implode('/', $nomor_sertifikat_parts);
                                    }

                                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_nomor_sertifikat'])) {
                                        $nomor_sertifikat_mulai = $_POST['nomor_sertifikat'];
                                        $format_sertifikat = $_POST['format_sertifikat'];
                                        $tgl_terbit_sertif = $_POST['tgl_terbit_sertif'];

                                        $no_sertif_query = "SELECT s.id_peserta, s.id_pelatihan
                                                            FROM tbl_sertifikat s
                                                            WHERE s.id_pelatihan = '$id_pelatihan'";
                                        $no_sertif_result = mysqli_query($conn, $no_sertif_query);

                                        if ($no_sertif_result && mysqli_num_rows($no_sertif_result) > 0) {
                                            $no = $nomor_sertifikat_mulai;

                                            while ($row = mysqli_fetch_assoc($no_sertif_result)) {
                                                $id_peserta = $row['id_peserta'];

                                                $nomor_sertifikat_lengkap = sprintf("%03d/%s", $no, $format_sertifikat);

                                                $update_sertifikat_query = "UPDATE tbl_sertifikat SET no_sertif = '$nomor_sertifikat_lengkap', tgl_terbit_sertif = '$tgl_terbit_sertif' WHERE id_peserta = '$id_peserta' AND id_pelatihan = '$id_pelatihan'";
                                                mysqli_query($conn, $update_sertifikat_query);

                                                $no++;
                                            }

                                            // Redirect to certificate show page after successful update
                                            echo '<script>
                                                    Swal.fire({
                                                        icon: "success",
                                                        title: "Sukses!",
                                                        text: "Nomor sertifikat berhasil di-update.",
                                                    }).then(function() {
                                                        window.location.href = "sertifikat-show.php?id_pelatihan=' . $id_pelatihan . '";
                                                    });
                                                </script>';
                                        } else {
                                            echo '<script>
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "Oops...",
                                                        text: "Error retrieving participants: ' . mysqli_error($conn) . '",
                                                    });
                                                </script>';
                                        }
                                    }
                                    ?>

                                    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST" class="mb-3">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nomor Sertifikat Awal</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nomor_sertifikat" value="<?php echo htmlspecialchars($nomor_sertifikat_mulai); ?>" placeholder="Masukkan nomor sertifikat awal" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Format Sertifikat</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="format_sertifikat" value="<?php echo htmlspecialchars($format_sertifikat); ?>" placeholder="Masukkan format nomor sertifikat" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Tanggal Terbit Sertifikat</label>
                                            <div class="col-sm-10">
                                                <input type="date" class="form-control" name="tgl_terbit_sertif" value="<?php echo htmlspecialchars($tgl_terbit_sertif); ?>" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10 offset-sm-2">
                                                <button type="submit" class="btn btn-primary" name="submit_nomor_sertifikat">Tambah</button>
                                            </div>
                                        </div>
                                    </form>

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
                                                    <th>Nomor Sertifikat</th>
                                                    <th>Tanggal Terbit Sertifikat</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = $mulai + 1;
                                                while ($row_sertifikat = mysqli_fetch_assoc($result_sertifikat)) { ?>
                                                    <tr>
                                                        <td><?php echo $no++; ?></td>
                                                        <td><?php echo $row_sertifikat["nama_peserta"]; ?></td>
                                                        <td><?php echo $row_sertifikat["no_sertif"]; ?></td>
                                                        <td>
                                                            <?php
                                                            if (isset($row_sertifikat["tgl_terbit_sertif"]) && $row_sertifikat["tgl_terbit_sertif"] != "0000-00-00") {
                                                                $tgl_terbit_sertif = $row_sertifikat["tgl_terbit_sertif"];
                                                                $timestamp = strtotime($tgl_terbit_sertif);
                                                                $bulan = date("n", $timestamp);
                                                                $tahun = date("Y", $timestamp);
                                                                $tanggal = date("j", $timestamp);
                                                                echo sprintf("%02d %s %d", $tanggal, getBulanIndonesia($bulan), $tahun);
                                                            } else {
                                                                echo "Tanggal tidak tersedia";
                                                            }
                                                            ?>
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
            // SweetAlert Delete Confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                var id_sertifikat = $(this).data('id_sertifikat');
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
                        window.location = `sertifikat-hapus.php?id_sertifikat=${id_sertifikat}&id_pelatihan=${id_pelatihan}`;
                    }
                });
            });
        });
    </script>

</body>

</html>