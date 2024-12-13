<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'admin' && $level != 'panitia') {
    header("Location: access-denied.php");
    exit;
}

$id_pelatihan = isset($_GET['id_pelatihan']) ? (int)$_GET['id_pelatihan'] : 0;

$nama_pelatihan = "";
$tgl_pelatihan = "";

// Mengambil detail pelatihan jika id_pelatihan tersedia
if ($id_pelatihan > 0) {
    $pelatihan_detail_query = "SELECT nama_pelatihan, tgl_pelatihan FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'";
    $pelatihan_detail_result = mysqli_query($conn, $pelatihan_detail_query);

    if ($pelatihan_detail_result && mysqli_num_rows($pelatihan_detail_result) > 0) {
        $pelatihan_detail = mysqli_fetch_assoc($pelatihan_detail_result);
        $nama_pelatihan = $pelatihan_detail['nama_pelatihan'];
        $tgl_pelatihan = $pelatihan_detail['tgl_pelatihan'];
    } else {
        die("Error: Detail pelatihan tidak ditemukan.");
    }
}

$stats = [
    'pertanyaan1' => array_fill(1, 5, 0),
    'pertanyaan2' => array_fill(1, 5, 0),
    'pertanyaan3' => array_fill(1, 5, 0),
    'pertanyaan4' => array_fill(1, 5, 0),
    'pertanyaan5' => array_fill(1, 5, 0)
];

$participants = [];

if ($id_pelatihan > 0) {
    // Mengambil daftar peserta dan jawaban pre-test
    $result_pre_query = "SELECT A.id_peserta, A.jawaban1, A.jawaban2, A.jawaban3, A.jawaban4, A.jawaban5, P.nama_peserta
                         FROM tbl_posttest A
                         JOIN tbl_peserta P ON A.id_peserta = P.id_peserta
                         WHERE A.id_pelatihan = '$id_pelatihan'";
    $result_pre = mysqli_query($conn, $result_pre_query);

    if (!$result_pre) {
        die("Error: Gagal mengambil data post-test. " . mysqli_error($conn));
    }

    // Mengambil pertanyaan dari tbl_test
    $sql_test = "SELECT pertanyaan1, pertanyaan2, pertanyaan3, pertanyaan4, pertanyaan5 FROM tbl_test WHERE id_pelatihan = $id_pelatihan";
    $result_test = mysqli_query($conn, $sql_test);
    $row_test = mysqli_fetch_assoc($result_test);

    while ($row_pre = mysqli_fetch_assoc($result_pre)) {
        $id_peserta = $row_pre['id_peserta'];
        $nama_peserta = $row_pre['nama_peserta'];
        for ($i = 1; $i <= 5; $i++) {
            $jawaban = $row_pre["jawaban$i"];
            if (isset($stats["pertanyaan$i"][$jawaban])) {
                $stats["pertanyaan$i"][$jawaban]++;
            }
            if (!isset($participants["pertanyaan$i"][$jawaban])) {
                $participants["pertanyaan$i"][$jawaban] = [];
            }
            $participants["pertanyaan$i"][$jawaban][] = $nama_peserta;
        }
    }
} else {
    $result_pre = false;
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
    <title>Jawaban Post-Test Peserta</title>
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        .chart-container {
            width: 50%;
            margin: 0 auto;
        }

        .chart-container canvas {
            width: 100% !important;
            height: auto !important;
        }

        .question {
            margin-top: 30px;
        }

        .legend {
            text-align: center;
            margin-top: 10px;
        }

        .legend span {
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 5px;
            vertical-align: middle;
            border-radius: 3px;
        }

        .legend .label-1 {
            background-color: rgba(255, 99, 132, 0.2);
        }

        .legend .label-2 {
            background-color: rgba(54, 162, 235, 0.2);
        }

        .legend .label-3 {
            background-color: rgba(255, 206, 86, 0.2);
        }

        .legend .label-4 {
            background-color: rgba(75, 192, 192, 0.2);
        }

        .legend .label-5 {
            background-color: rgba(153, 102, 255, 0.2);
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
                                        <h3 class="mt-4"><b>Jawaban Post-Test Peserta - <?php echo htmlspecialchars($nama_pelatihan); ?> (<?php echo date("d F Y", strtotime($tgl_pelatihan)); ?>)</b></h3>
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="post-pelatihan-list.php">Pilih Pelatihan</a></li>
                                            <li class="breadcrumb-item active">Jawaban Post-Test Peserta - <?php echo htmlspecialchars($nama_pelatihan); ?></li>
                                        </ol>
                                    </div>

                                    <?php if ($result_pre && mysqli_num_rows($result_pre) > 0) { ?>
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <div class="question mb-5">
                                                <h4 class="mt-5">Pertanyaan <?php echo $i; ?>: <?php echo htmlspecialchars($row_test["pertanyaan$i"]); ?></h4>
                                                <div class="chart-container">
                                                    <canvas id="chart<?php echo $i; ?>"></canvas>
                                                    <div class="legend">
                                                        <span class="label-1"></span> Sangat Kurang
                                                        <span class="label-2"></span> Kurang
                                                        <span class="label-3"></span> Cukup
                                                        <span class="label-4"></span> Baik
                                                        <span class="label-5"></span> Sangat Baik
                                                    </div>
                                                </div>
                                                <script>
                                                    const ctx<?php echo $i; ?> = document.getElementById('chart<?php echo $i; ?>').getContext('2d');
                                                    new Chart(ctx<?php echo $i; ?>, {
                                                        type: 'bar',
                                                        data: {
                                                            labels: ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'],
                                                            datasets: [{
                                                                label: 'Jumlah Responden',
                                                                data: [
                                                                    <?php echo isset($stats["pertanyaan$i"][1]) ? $stats["pertanyaan$i"][1] : 0; ?>,
                                                                    <?php echo isset($stats["pertanyaan$i"][2]) ? $stats["pertanyaan$i"][2] : 0; ?>,
                                                                    <?php echo isset($stats["pertanyaan$i"][3]) ? $stats["pertanyaan$i"][3] : 0; ?>,
                                                                    <?php echo isset($stats["pertanyaan$i"][4]) ? $stats["pertanyaan$i"][4] : 0; ?>,
                                                                    <?php echo isset($stats["pertanyaan$i"][5]) ? $stats["pertanyaan$i"][5] : 0; ?>
                                                                ],
                                                                backgroundColor: [
                                                                    'rgba(255, 99, 132, 0.2)',
                                                                    'rgba(54, 162, 235, 0.2)',
                                                                    'rgba(255, 206, 86, 0.2)',
                                                                    'rgba(75, 192, 192, 0.2)',
                                                                    'rgba(153, 102, 255, 0.2)'
                                                                ],
                                                                borderColor: [
                                                                    'rgba(255, 99, 132, 1)',
                                                                    'rgba(54, 162, 235, 1)',
                                                                    'rgba(255, 206, 86, 1)',
                                                                    'rgba(75, 192, 192, 1)',
                                                                    'rgba(153, 102, 255, 1)'
                                                                ],
                                                                borderWidth: 1
                                                            }]
                                                        },
                                                        options: {
                                                            responsive: true,
                                                            scales: {
                                                                x: {
                                                                    beginAtZero: true
                                                                }
                                                            },
                                                            onClick: function(evt, item) {
                                                                const index = item[0]?.index;
                                                                if (index !== undefined) {
                                                                    const value = item[0].element.$context.raw;
                                                                    const jawabanIndex = index + 1;
                                                                    const deskripsiJawaban = ['Sangat Kurang', 'Kurang', 'Cukup', 'Baik', 'Sangat Baik'][index];
                                                                    const peserta = <?php echo json_encode($participants["pertanyaan$i"]); ?>;
                                                                    const namaPeserta = peserta[jawabanIndex] || [];

                                                                    // Format daftar peserta dengan nomor
                                                                    const formattedPeserta = namaPeserta.map((nama, idx) => `${idx + 1}. ${nama}`).join('<br>');

                                                                    Swal.fire({
                                                                        title: `Peserta yang menjawab ${deskripsiJawaban}`,
                                                                        html: namaPeserta.length > 0 ? formattedPeserta : 'Tidak ada peserta',
                                                                        icon: 'info',
                                                                        width: 600
                                                                    });
                                                                }
                                                            }
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <p>Tidak ada data pre-test untuk pelatihan ini.</p>
                                    <?php } ?>

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
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/hoverable-collapse.js"></script>
    <script src="../assets/js/template.js"></script>
    <script src="../assets/js/dashboard.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
</body>

</html>