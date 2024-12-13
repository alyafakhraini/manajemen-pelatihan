<?php
session_start();
include "koneksi.php";

// Cek level user yang login
$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
$error = '';

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

    // Get data based on user level
    if ($user_level === 'peserta') {
        $query_peserta = "SELECT * FROM tbl_peserta WHERE id_user = $id_user";
        $result_peserta = mysqli_query($conn, $query_peserta);
        if (!$result_peserta) {
            echo "Error: " . mysqli_error($conn);
            exit;
        }
        $row_peserta = mysqli_fetch_assoc($result_peserta);
    } elseif ($user_level === 'trainer') {
        $query_trainer = "SELECT * FROM tbl_trainer WHERE id_user = $id_user";
        $result_trainer = mysqli_query($conn, $query_trainer);
        if (!$result_trainer) {
            echo "Error: " . mysqli_error($conn);
            exit;
        }
        $row_trainer = mysqli_fetch_assoc($result_trainer);
    }

    if (isset($_POST["submit"])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Cek apakah username sudah ada
        $query_cek = "SELECT * FROM tbl_user WHERE username = '$username' AND id_user != $id_user";
        $result_cek = mysqli_query($conn, $query_cek);

        if (mysqli_num_rows($result_cek) > 0) {
            $error = "Username sudah ada, silahkan pakai username lain.";
        } else {
            // Mengelola file upload
            if ($_FILES['profile']['error'] === 4) {
                $profile = $profile_lama; // Gunakan foto profile lama jika tidak ada file baru
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

            // Update tbl_user
            $query = "UPDATE tbl_user SET 
                        username = '$username',
                        password = '$password',
                        profile = '$profile'
                      WHERE id_user = $id_user";
            $simpan_user = mysqli_query($conn, $query);

            // Update additional table based on user level
            if ($user_level === 'peserta') {
                $nama_peserta = $_POST['nama_peserta'];
                $email = $_POST['email'];
                $telp_peserta = $_POST['telp_peserta'];
                $gender = $_POST['gender'];
                $domisili = $_POST['domisili'];
                $status_peserta = $_POST['status_peserta'];
                $komunitas = $_POST['komunitas'];

                $query_peserta = "UPDATE tbl_peserta SET 
                                    nama_peserta = '$nama_peserta',
                                    email = '$email',
                                    telp_peserta = '$telp_peserta',
                                    gender = '$gender',
                                    domisili = '$domisili',
                                    status_peserta = '$status_peserta',
                                    komunitas = '$komunitas'
                                  WHERE id_user = $id_user";
                $simpan_peserta = mysqli_query($conn, $query_peserta);
            } elseif ($user_level === 'trainer') {
                $nama_trainer = $_POST['nama_trainer'];
                $sertifikasi = $_POST['sertifikasi'];
                $npwp_trainer = $_POST['npwp_trainer'];
                $bank = $_POST['bank'];
                $rekening = $_POST['rekening'];
                $kontak_trainer = $_POST['kontak_trainer'];

                $query_trainer = "UPDATE tbl_trainer SET 
                                    nama_trainer = '$nama_trainer',
                                    sertifikasi = '$sertifikasi',
                                    npwp_trainer = '$npwp_trainer',
                                    bank = '$bank',
                                    rekening = '$rekening',
                                    kontak_trainer = '$kontak_trainer'
                                  WHERE id_user = $id_user";
                $simpan_trainer = mysqli_query($conn, $query_trainer);
            }

            if ($simpan_user && ($user_level === 'peserta' ? $simpan_peserta : $simpan_trainer)) {
                // Update session username
                $_SESSION['username'] = $username;

                // Redirect ke halaman index.php jika berhasil
                header("Location: index.php");
                exit;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
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
                            <h2 class="title"> Profile Akun</h2>

                            <?php if ($error) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $error; ?>
                                </div>
                            <?php endif; ?>

                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">Username</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profile" class="col-sm-2 col-form-label">Foto Profile</label>
                                    <div class="col-sm-10">
                                        <img src="profile/<?php echo htmlspecialchars($profile_lama); ?>" alt="Foto Profile Lama" class="img-thumnail" width="100">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="profile" class="col-sm-2 col-form-label">Ganti Foto Profile</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="profile">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                                        <button class="btn btn-light">Cancel</button>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <?php if ($user_level === 'peserta') : ?>
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="title"> Profile Saya</h2>
                                <div class="form-group row">
                                    <label for="nama_peserta" class="col-sm-2 col-form-label">Nama Peserta</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_peserta" value="<?php echo htmlspecialchars($row_peserta['nama_peserta']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($row_peserta['email']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="telp_peserta" class="col-sm-2 col-form-label">Telepon</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="telp_peserta" value="<?php echo htmlspecialchars($row_peserta['telp_peserta']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <select name="gender" id="gender" class="form-control">
                                                <option value="lk" <?php if ($row_peserta["gender"] == 'lk') echo "SELECTED"; ?>>Laki-laki</option>
                                                <option value="pr" <?php if ($row_peserta["gender"] == 'pr') echo "SELECTED"; ?>>Perempuan</option>
                                            </select>
                                            <span class="input-group-text">
                                                <i class="fas fa-caret-down"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="domisili" class="col-sm-2 col-form-label">Domisili</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="domisili" value="<?php echo htmlspecialchars($row_peserta['domisili']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="status_peserta" class="col-sm-2 col-form-label">Status Peserta</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="status_peserta" value="<?php echo htmlspecialchars($row_peserta['status_peserta']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="komunitas" class="col-sm-2 col-form-label">Komunitas</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="komunitas" value="<?php echo htmlspecialchars($row_peserta['komunitas']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                                        <button class="btn btn-light">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php elseif ($user_level === 'trainer') : ?>
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="title"> Profile Saya</h2>
                                <div class="form-group row">
                                    <label for="nama_trainer" class="col-sm-2 col-form-label">Nama Trainer</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nama_trainer" value="<?php echo htmlspecialchars($row_trainer['nama_trainer']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sertifikasi" class="col-sm-2 col-form-label">Sertifikasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="sertifikasi" value="<?php echo htmlspecialchars($row_trainer['sertifikasi']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="npwp_trainer" class="col-sm-2 col-form-label">NPWP Trainer</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="npwp_trainer" value="<?php echo htmlspecialchars($row_trainer['npwp_trainer']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bank" class="col-sm-2 col-form-label">Bank</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="bank" value="<?php echo htmlspecialchars($row_trainer['bank']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="rekening" class="col-sm-2 col-form-label">Rekening</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="rekening" value="<?php echo htmlspecialchars($row_trainer['rekening']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="kontak_trainer" class="col-sm-2 col-form-label">Kontak Trainer</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="kontak_trainer" value="<?php echo htmlspecialchars($row_trainer['kontak_trainer']); ?>" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                                        <button class="btn btn-light">Cancel</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                            </form>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
    </section>
    <!--================ End Course Details Area =================-->

    <!--================ start footer Area  =================-->
    <?php include "footer.php"; ?>
    <!--================ End footer Area  =================-->

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/owl-carousel-thumb.min.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/mail-script.js"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=API_KEY"></script>
    <script src="js/gmaps.min.js"></script>
    <script src="js/theme.js"></script>
</body>

</html>