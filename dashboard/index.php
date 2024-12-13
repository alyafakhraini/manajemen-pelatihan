<?php
session_start();
include "../koneksi.php";
include "data-dashboard.php";
$stats = get_statistics($conn); // Mengambil statistik menggunakan koneksi yang ada 

// Menampilkan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id_user'])) {
  header("Location: ../login.php");
  exit;
}

$id_user = $_SESSION['id_user'];

// Ambil username dan level dari database berdasarkan id_user
$query = "SELECT username, level FROM tbl_user WHERE id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $username = $row['username'];
  $level = $row['level'];

  if ($level != 'admin' && $level != 'panitia') {
    header("Location: ../login.php");
    exit;
  }
} else {
  header("Location: ../login.php");
  exit;
}
$stmt->close();

// Query untuk mengambil jumlah pendaftar untuk setiap kategori_program dari tbl_pendaftaran yang terkait dengan tbl_pelatihan
$query_pie = "SELECT pelatihan.kategori_program, COUNT(*) as total_pendaftar 
              FROM tbl_pendaftaran AS daftar 
              INNER JOIN tbl_pelatihan AS pelatihan ON daftar.id_pelatihan = pelatihan.id_pelatihan 
              GROUP BY pelatihan.kategori_program";
$result_pie = $conn->query($query_pie);


// Menginisialisasi array untuk menyimpan data pie chart
$labels = [];
$data = [];

while ($row_pie = $result_pie->fetch_assoc()) {
  switch ($row_pie['kategori_program']) {
    case 'level up':
      $labels[] = 'Level Up';
      break;
    case 'psc':
      $labels[] = 'Professional Skill Certificate';
      break;
    case 'ap':
      $labels[] = 'Acceleration Program';
      break;
    case 'bootcamp':
      $labels[] = 'Bootcamp';
      break;
  }
  $data[] = $row_pie['total_pendaftar'];
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="../image/bcti_logo.png" type="image/png">
  <title>Admin - Dashboard</title>
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
</head>

<body class="with-welcome-text">
  <div class="container-scroller">

    <?php include "navbar.php"; ?>

    <div class="container-fluid page-body-wrapper">

      <?php include "sidebar.php"; ?>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">

            <div class="col-xl-3 col-md-6">
              <div class="row">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card card-rounded bg-success text-white mb-4">
                    <div class="card-body text-center">
                      <h4 class="card-title card-title-dash" style="margin-bottom: 20px;">Jumlah Pelatihan Terlaksana</h4>
                      <h2><?php echo isset($stats['pelatihan_bcti']) ? $stats['pelatihan_bcti'] : 0; ?></h2>
                      <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="pelatihan.php">View Details</a>
                        <i class="fas fa-angle-right"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card card-rounded bg-secondary text-white mb-4">
                    <div class="card-body text-center">
                      <h4 class="card-title card-title-dash" style="margin-bottom: 20px;">Jumlah Peserta Terdaftar</h4>
                      <h2><?php echo isset($stats['peserta_terdaftar']) ? $stats['peserta_terdaftar'] : 0; ?></h2>
                      <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="peserta.php">View Details</a>
                        <i class="fas fa-angle-right"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-3 col-md-6">
              <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card card-rounded bg-warning text-white mb-4">
                    <div class="card-body text-center">
                      <h4 class="card-title card-title-dash" style="margin-bottom: 20px;">Jumlah Trainer Terdaftar</h4>
                      <h2><?php echo isset($stats['trainer_terdaftar']) ? $stats['trainer_terdaftar'] : 0; ?></h2>
                      <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="trainer.php">View Details</a>
                        <i class="fas fa-angle-right"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>

          <div class="row">
            <div class="col-lg-6 grid-margin grid-margin-lg-0 stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Jumlah Pendaftar per Program BCTI</h4>
                  <div class="doughnutjs-wrapper d-flex justify-content-center">
                    <canvas id="pieChart" style="height: 250px !important;"></canvas>
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
  <script>
    // Script untuk membuat pie chart
    var ctx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
          label: 'Jumlah Pendaftar',
          data: <?php echo json_encode($data); ?>,
          backgroundColor: [
            '#976ee2', // Hijau untuk Level Up
            '#fa8526', // Abu-abu untuk Professional Skill Certificate
            '#4c8adb', // Kuning untuk Acceleration Program
            '#35cb88' // Biru untuk Bootcamp
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        legend: {
          position: 'bottom',
          labels: {
            fontColor: '#333',
            fontSize: 12
          }
        },
        tooltips: {
          callbacks: {
            label: function(tooltipItem, data) {
              var dataset = data.datasets[tooltipItem.datasetIndex];
              var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                return previousValue + currentValue;
              });
              var currentValue = dataset.data[tooltipItem.index];
              var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
              return currentValue + ' (' + percentage + '%)';
            }
          }
        }
      }
    });
  </script>

  <script src="../assets/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>