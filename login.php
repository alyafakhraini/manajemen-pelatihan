<?php
session_start(); // Memulai session
include "koneksi.php"; // Memanggil file koneksi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan data pengguna berdasarkan username dan password
    $sql_login = "SELECT user.*, peserta.id_peserta, trainer.id_trainer
                    FROM tbl_user AS user
                    LEFT JOIN tbl_peserta AS peserta ON user.id_user = peserta.id_user
                    LEFT JOIN tbl_trainer AS trainer ON user.id_user = trainer.id_user
                    WHERE user.username = '$username' AND user.password = '$password'";
    $result_login = $conn->query($sql_login);

    if ($result_login->num_rows > 0) {
        $row_login = $result_login->fetch_assoc();

        // Cek status pengguna
        if ($row_login['status'] == 'aktif') {
            // Set session untuk pengguna yang aktif
            $_SESSION['id_user'] = $row_login['id_user'];
            $_SESSION['username'] = $row_login['username'];
            $_SESSION['level'] = $row_login['level'];

            if ($row_login["level"] == 'peserta') {
                $_SESSION["id_peserta"] = $row_login["id_peserta"]; // Menyimpan id_peserta ke dalam sesi
            }

            if ($row_login["level"] == 'trainer') {
                $_SESSION["id_trainer"] = $row_login["id_trainer"]; // Menyimpan id_peserta ke dalam sesi
            }

            // Redirect ke halaman sesuai level pengguna
            if ($row_login['level'] == 'admin' || $row_login['level'] == 'panitia' || $row_login['level'] == 'peserta' || $row_login['level'] == 'trainer') {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Akun Anda belum aktif. Silahkan hubungi administrator.";
        }
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<link rel="icon" href="image/bcti_logo.png">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BCTI - Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- endinject -->
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo">
                                <img src="image/bcti_logo.png" alt="logo">
                            </div>
                            <h4>Selamat Datang!</h4>
                            <h6 class="fw-light">Silahkan login untuk melanjutkan.</h6>
                            <?php if (isset($error)) {
                                echo '<p style="color:red;">' . $error . '</p>';
                            } ?>
                            <form class="pt-3" method="POST" action="">
                                <div class="form-group">
                                    <label>Username</label><br>
                                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label><br>
                                    <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
                                </div>
                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">LOGIN</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <a href="#" class="auth-link text-black">Lupa password?</a>
                                </div>
                                <div class="text-center mt-4 fw-light"> Belum memiliki akun? <a href="register.php" class="text-primary">Daftar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
</body>

</html>