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

$id_user = $_GET["id_user"];
$result_user = mysqli_query($conn, "SELECT * FROM tbl_user WHERE id_user = '$id_user'");
$row_user = mysqli_fetch_assoc($result_user);
$profile_lama = $row_user["profile"];

if (isset($_POST["submit"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];
    $level = $_POST["level"];
    if ($_FILES['profile']['error'] === 4) {
        $profile = $profile_lama;
    } else {
        $profile = $_FILES["profile"]["name"];
    }
    $status = $_POST["status"];

    $upload = move_uploaded_file($_FILES['profile']['tmp_name'], '../profile/' . $profile);
    $simpan = mysqli_query($conn, "UPDATE tbl_user SET username = '$username', password = '$password', level = '$level', profile ='$profile', status = '$status' WHERE id_user = '$id_user'");

    if ($simpan) {
        header("Location: manage-user.php");
    } else {
        header("Location: manage-user-edit.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../image/bcti_logo.png" type="image/png">
    <title> Edit Pengguna</title>
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
            /* Warna latar belakang */
            padding: 0.2rem 1rem 0.2rem 1rem;
            /* Padding sesuai keinginan */
            border-radius: 0.375rem;
            /* Membuat sudut kartu menjadi bulat */
            margin-bottom: 1rem;
            /* Jarak bawah */
        }

        .breadcrumb-container h4 {
            margin-bottom: 0.5rem;
            /* Jarak bawah untuk heading */
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

                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="breadcrumb-container">
                                    <h3 class="mt-4"><b>Edit Pengguna</b></h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="manage-user.php">Manajemen Pengguna</a></li>
                                        <li class="breadcrumb-item active">Edit Pengguna</li>
                                    </ol>
                                </div>
                                <form action="" method="post" enctype="multipart/form-data" class="forms-sample">
                                    <div class="form-group row">
                                        <label for="username" class="col-sm-1 col-form-label">Username</label>
                                        <div class="col-sm-11">
                                            <input type="text" class="form-control" name="username" id="username" value="<?php echo $row_user["username"] ?>" placeholder="Masukkan username baru" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-1 col-form-label">Password</label>
                                        <div class="col-sm-11">
                                            <input type="text" class="form-control" name="password" id="password" value="<?php echo $row_user["password"] ?>" placeholder="Masukkan password baru" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="level" class="col-sm-1 col-form-label">Level User</label>
                                        <div class="col-sm-11">
                                            <div class="input-group">
                                                <select name="level" id="level" class="form-control">
                                                    <option value="admin" <?php if ($row_user["level"] == 'admin') echo "SELECTED"; ?>>Admin</option>
                                                    <option value="panitia" <?php if ($row_user["level"] == 'panitia') echo "SELECTED"; ?>>Panitia</option>
                                                    <option value="peserta" <?php if ($row_user["level"] == 'peserta') echo "SELECTED"; ?>>Peserta</option>
                                                </select>
                                                <span class="input-group-text">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <p>Photo Profile Lama : <img src="../profile/<?php echo $row_user["profile"] ?>" alt="photo profile" class="img-thumnail" width="100"></p>
                                        <label for="profile" class="col-sm-1 col-form-label">Photo Profile</label>
                                        <div class="col-sm-11">
                                            <input type="file" class="form-control" name="profile" id="profile">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group row">
                                            <label class="col-sm-1 col-form-label">Status</label>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status" id="status1" value="aktif" <?php if ($row_user["status"] == 'aktif') echo "checked"; ?>> Aktif </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="status" id="status2" value="pending" <?php if ($row_user["status"] == 'pending') echo "checked"; ?>> Pending </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10 offset-sm-1">
                                            <button type="submit" name="submit" class="btn btn-primary me-2">Edit</button>
                                            <a href="manage-user.php" class="btn btn-light">Cancel</a>
                                        </div>
                                    </div>
                                </form>
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
</body>

</html>