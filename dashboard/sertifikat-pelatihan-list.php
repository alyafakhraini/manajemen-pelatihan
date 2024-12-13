<?php
session_start();
include "../koneksi.php";

// Inisialisasi variabel
$searchQuery = '';

// Jika ada pencarian
if (isset($_GET['search_query'])) {
    $searchQuery = $_GET['search_query'];
    $result_pelatihan = mysqli_query($conn, "SELECT * FROM tbl_pelatihan WHERE nama_pelatihan LIKE '%$searchQuery%'");
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_pelatihan WHERE nama_pelatihan LIKE '%$searchQuery%'");
} else {
    // Query default
    $result_pelatihan = mysqli_query($conn, "SELECT * FROM tbl_pelatihan ORDER BY tgl_pelatihan DESC");
    $total_records_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM tbl_pelatihan");
}

$total_records = mysqli_fetch_assoc($total_records_query)['total'];

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
    <title> Pilih Pelatihan</title>
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
    <link rel="stylesheet" href="../assets/css/pelatihan-list.css">
    <!-- endinject -->
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
                                        <h3 class="mt-4"><b>Pilih Pelatihan</b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Pilih Pelatihan</li>
                                        </ol>
                                    </div>
                                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="search_query" class="form-control" placeholder="Search..." value="<?php if (isset($_GET['search_query'])) echo $_GET['search_query']; ?>">
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <?php
                                        while ($row_pelatihan = mysqli_fetch_assoc($result_pelatihan)) {

                                            if ($row_pelatihan['status_kegiatan'] == 'postponed') {
                                                continue; // Jangan tampilkan jika statusnya postponed
                                            }

                                            $kategori_program = '';
                                            switch ($row_pelatihan['kategori_program']) {
                                                case 'level up':
                                                    $kategori_program = 'card-level-up';
                                                    break;
                                                case 'psc':
                                                    $kategori_program = 'card-psc';
                                                    break;
                                                case 'ap':
                                                    $kategori_program = 'card-ap';
                                                    break;
                                                case 'bootcamp':
                                                    $kategori_program = 'card-bootcamp';
                                                    break;
                                                default:
                                                    $kategori_program = '';
                                            }

                                            // Query untuk mendapatkan jumlah peserta hadir
                                            $id_pelatihan = $row_pelatihan['id_pelatihan'];
                                            $query_peserta_hadir = "SELECT COUNT(*) AS jumlah_hadir
                                                                    FROM tbl_kehadiran H, tbl_pendaftaran D, tbl_pelatihan P, tbl_peserta C
                                                                    WHERE H.id_pendaftaran = D.id_pendaftaran
                                                                    AND D.id_pelatihan = P.id_pelatihan
                                                                    AND D.id_peserta = C.id_peserta
                                                                    AND P.id_pelatihan = $id_pelatihan
                                                                    AND H.status_kehadiran = 'Hadir'";
                                            $result_peserta_hadir = mysqli_query($conn, $query_peserta_hadir);
                                            if ($result_peserta_hadir) {
                                                $jumlah_peserta_hadir = mysqli_fetch_assoc($result_peserta_hadir)['jumlah_hadir'];
                                            } else {
                                                $jumlah_peserta_hadir = 0;
                                            }

                                            // Query untuk mendapatkan nomor sertifikat peserta pertama dan terakhir
                                            $query_sertifikat = "SELECT MIN(S.no_sertif) AS no_sertif_awal, MAX(S.no_sertif) AS no_sertif_akhir
                                                                FROM tbl_sertifikat S, tbl_kehadiran H, tbl_pelatihan P
                                                                WHERE S.id_kehadiran = H.id_kehadiran
                                                                AND S.id_pelatihan = P.id_pelatihan
                                                                AND P.id_pelatihan = $id_pelatihan";
                                            $result_sertifikat = mysqli_query($conn, $query_sertifikat);

                                            if ($result_sertifikat) {
                                                $row_sertifikat = mysqli_fetch_assoc($result_sertifikat);
                                                $no_sertif_awal = $row_sertifikat['no_sertif_awal'];
                                                $no_sertif_akhir = $row_sertifikat['no_sertif_akhir'];
                                            } else {
                                                $no_sertif_awal = 0;
                                                $no_sertif_akhir = 0;
                                            }
                                        ?>

                                            <div class="col-md-3" style="margin-left: 25px;">
                                                <div class="card mb-4 <?php echo $kategori_program; ?>">
                                                    <a href="sertifikat-show.php?id_pelatihan=<?php echo $row_pelatihan['id_pelatihan']; ?>">
                                                        <img src="../poster/<?php echo $row_pelatihan['poster'] ?>" class="card-img-top" alt="Poster Pelatihan">
                                                    </a>
                                                    <div class="card-body">
                                                        <h5 class="card-title">
                                                            <b>
                                                                <?php
                                                                // Menentukan teks kategori program
                                                                switch ($row_pelatihan['kategori_program']) {
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
                                                                        $kategori_program_text = ucfirst($row_pelatihan['kategori_program']);
                                                                }
                                                                echo $kategori_program_text . ": " . $row_pelatihan["nama_pelatihan"];
                                                                ?>
                                                                (<?php
                                                                    if (isset($row_pelatihan["tgl_pelatihan"])) {
                                                                        $tgl_pelatihan = $row_pelatihan["tgl_pelatihan"];
                                                                        $timestamp = strtotime($tgl_pelatihan);
                                                                        $bulan = date("n", $timestamp);
                                                                        $tahun = date("Y", $timestamp);
                                                                        $tanggal = date("j", $timestamp);
                                                                        echo sprintf("%02d %s %d", $tanggal, getBulanIndonesia($bulan), $tahun);
                                                                    } else {
                                                                        echo "Tanggal tidak tersedia";
                                                                    }
                                                                    ?>)
                                                            </b>
                                                        </h5>
                                                        <h5><span class="fa fa-check-square"></span> Peserta Hadir = <a><?php echo $jumlah_peserta_hadir ?></a></h5>
                                                        <h5><span class="fa fa-certificate"></span> Nomor Sertifikat = <a><?php echo "$no_sertif_awal - $no_sertif_akhir"; ?></a></h5>
                                                    </div>
                                                </div>
                                            </div>

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