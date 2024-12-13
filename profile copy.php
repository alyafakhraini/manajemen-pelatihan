<?php
session_start();
include "koneksi.php";

// Cek level user yang login
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;

$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;

if ($id_user) {
    $query = "SELECT * FROM tbl_user WHERE id_user = $id_user";
    $result_profile = mysqli_query($conn, $query);

    if (!$result_profile) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }

    $row_profile = mysqli_fetch_assoc($result_profile);

    $username = $row_profile["username"];
    $password = $row_profile["password"];
    $profile_lama = $row_profile["profile"];

    if (isset($_POST["submit"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Mengelola file upload
        if ($_FILES['profile']['error'] === 4) {
            $profile = $profile_lama; // Gunakan bukti pembayaran lama jika tidak ada file baru
        } else {
            $profile = $_FILES["profile"]["name"];
            $target_file = 'profile/' . $profile;
            if (move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
                // Berhasil mengupload file
            } else {
                // Gagal mengupload file
                echo "Gagal mengunggah foto profile.";
                exit;
            }
        }

        $query = "UPDATE tbl_user SET 
                    username = '$username',
                    password = '$password',
                    profile = '$profile',
                  WHERE id_user = $id_user";

        $simpan = mysqli_query($conn, $query);

        if ($simpan) {
            // Redirect ke halaman my-course.php jika berhasil
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
} else {
    echo "ID user valid.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" href="image/bcti_logo.png" type="image/png" />
    <title>Profile Saya</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/flaticon.css" />
    <link rel="stylesheet" href="css/themify-icons.css" />
    <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
    <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <!--================ Start Header Menu Area =================-->
    <?php include "header.php"; ?>
    <!--================ End Header Menu Area =================-->

    <!--================Home Banner Area =================-->
    <section class="banner_area">
        <div class="banner_inner d-flex align-items-center">
            <div class="overlay"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="banner_content text-center">
                            <h2> Profile</h2>
                            <div class="page_link">
                                <a href="index.php">Home</a>
                                <a href="profile.php">Profile Saya</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================End Home Banner Area =================-->

    <!--================ Start Course Details Area =================-->
    <section class="course_details_area section_gap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3"> Profile Saya</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="title"> Profile Saya</h2>

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id_user=$id_user"; ?>" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profile" class="col-sm-3 col-form-label">Foto Profile Lama</label>
                                    <div class="col-sm-9">
                                        <img src="profile/<?php echo $profile_lama; ?>" alt="profile" class="img-thumbnail" width="200">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profile" class="col-sm-3 col-form-label">Upload Foto Profile Baru</label>
                                    <div class="col-sm-9">
                                        <input type="file" class="form-control" name="profile" id="profile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================ End Course Details Area =================-->

    <!--================ Start Footer Area =================-->
    <?php include "footer.php"; ?>
    <!--================ End Footer Area =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>