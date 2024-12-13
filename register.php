<?php
session_start();
include "koneksi.php";

$error = ""; // Inisialisasi variabel error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // Cek apakah username sudah ada di database
    $sql_check_user = "SELECT * FROM tbl_user WHERE username = '$username'";
    $result_check_user = $conn->query($sql_check_user);

    if ($result_check_user->num_rows == 0) {
        // Tentukan status berdasarkan level pengguna
        $status = ($level == 'peserta') ? 'aktif' : 'pending';

        // Simpan pengguna baru dengan status yang telah ditentukan
        $sql_user = "INSERT INTO tbl_user (username, password, level, profile, status) VALUES ('$username', '$password', '$level', '', '$status')";
        if ($conn->query($sql_user) === TRUE) {
            $user_id = $conn->insert_id; // Mendapatkan id dari tbl_user yang baru saja dimasukkan

            if ($level == 'peserta') {
                $nama_peserta = $_POST['nama_peserta'];
                $email = $_POST['email'];
                $telp_peserta = $_POST['telp_peserta'];
                $gender = $_POST['gender'];
                $domisili = $_POST['domisili'];
                $status_peserta = $_POST['status_peserta'];
                $komunitas = $_POST['komunitas'];

                // Simpan data peserta
                $sql_peserta = "INSERT INTO tbl_peserta (id_user, nama_peserta, email, telp_peserta, gender, domisili, status_peserta, komunitas) VALUES ('$user_id', '$nama_peserta', '$email', '$telp_peserta', '$gender', '$domisili', '$status_peserta', '$komunitas')";
                if ($conn->query($sql_peserta) === TRUE) {
                    header("Location: login.php");
                    exit(); // Pastikan untuk keluar dari skrip setelah redirect
                } else {
                    $error = "Error: " . $sql_peserta . "<br>" . $conn->error;
                }
            } elseif ($level == 'trainer') {
                $nama_trainer = $_POST['nama_trainer'];
                $sertifikasi = $_POST['sertifikasi'];
                $npwp_trainer = intval($_POST['npwp_trainer']); // Konversi ke integer
                $bank = $_POST['bank'];
                $rekening = intval($_POST['rekening']);
                $kontak_trainer = intval($_POST['kontak_trainer']);

                // Simpan data trainer
                $sql_trainer = "INSERT INTO tbl_trainer (id_user, nama_trainer, keahlian, sertifikasi, npwp_trainer, fee_trainer, bank, rekening, kontak_trainer) VALUES ('$user_id', '$nama_trainer', '', '$sertifikasi', $npwp_trainer, '', '$bank', $rekening, '$kontak_trainer')";
                if ($conn->query($sql_trainer) === TRUE) {
                    header("Location: login.php");
                    exit(); // Pastikan untuk keluar dari skrip setelah redirect
                } else {
                    $error = "Error: " . $sql_trainer . "<br>" . $conn->error;
                }
            } else {
                header("Location: login.php");
                exit(); // Pastikan untuk keluar dari skrip setelah redirect
            }
        } else {
            $error = "Error: " . $sql_user . "<br>" . $conn->error;
        }
    } else {
        $error = "Username sudah ada. Silakan pilih username lain.";
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
    <title>BCTI - Registrasi</title>
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
                            <h6 class="fw-light">Silahkan isi data dibawah ini untuk membuat akun baru.</h6>
                            <?php if (!empty($error)) { ?>
                                <p style="color:red;"><?php echo $error; ?></p>
                            <?php } ?>
                            <form id="registrationForm" class="pt-3" method="POST" action="">
                                <div class="form-group">
                                    <label>Username</label><br>
                                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <label>Password</label><br>
                                    <input type="password" class="form-control form-control-lg" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group">
                                    <label>Anda mendaftar sebagai?</label><br>
                                    <select class="form-control form-control-lg" name="level" id="levelSelect" onchange="showForm()" required>
                                        <option value="">-- Pilih Level --</option>
                                        <option value="peserta">Peserta</option>
                                        <option value="trainer">Trainer</option>
                                        <option value="panitia">Panitia</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>

                                <div id="trainerForm" style="display: none;">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label><br>
                                        <input type="text" class="form-control form-control-lg" name="nama_trainer" placeholder="contoh: Anies Baswedan">
                                    </div>
                                    <div class="form-group">
                                        <label>Sertifikasi & Pengalaman</label>
                                        <input type="text" class="form-control form-control-lg" name="sertifikasi" placeholder="Masukkan sertifikasi">
                                    </div>
                                    <div class="form-group">
                                        <label>NPWP</label>
                                        <input type="number" class="form-control form-control-lg" name="npwp_trainer" placeholder="Masukkan Nomor NPWP Trainer">
                                    </div>
                                    <div class="form-group">
                                        <label>Bank</label>
                                        <input type="text" class="form-control form-control-lg" name="bank" placeholder="Masukkan nama bank yang terhubung dengan rekening trainer">
                                    </div>
                                    <div class="form-group">
                                        <label>Rekening</label>
                                        <input type="number" class="form-control form-control-lg" name="rekening" placeholder="Masukkan Nomor Rekening Trainer">
                                    </div>
                                    <div class="form-group">
                                        <label>Kontak</label>
                                        <input type="number" class="form-control form-control-lg" name="kontak_trainer" placeholder="Masukkan Nomor Kontak Trainer">
                                    </div>
                                </div>

                                <div id="pesertaForm" style="display: none;">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label><br>
                                        <input type="text" class="form-control form-control-lg" name="nama_peserta" placeholder="contoh: Anies Baswedan">
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label><br>
                                        <input type="email" class="form-control form-control-lg" name="email" placeholder="contoh: email@example.com">
                                    </div>
                                    <div class="form-group">
                                        <label>Telepon</label><br>
                                        <input type="text" class="form-control form-control-lg" name="telp_peserta" placeholder="contoh: 08123456789">
                                    </div>
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label><br>
                                        <select class="form-control form-control-lg" name="gender">
                                            <option value="">-- Pilih Jenis Kelamin --</option>
                                            <option value="lk">Laki-laki</option>
                                            <option value="pr">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Domisili</label><br>
                                        <input type="text" class="form-control form-control-lg" name="domisili" placeholder="contoh: Jakarta">
                                    </div>
                                    <div class="form-group">
                                        <label>Status Peserta</label><br>
                                        <input type="text" class="form-control form-control-lg" name="status_peserta" placeholder="contoh: Mahasiswa">
                                    </div>
                                    <div class="form-group">
                                        <label>Komunitas</label><br>
                                        <input type="text" class="form-control form-control-lg" name="komunitas" placeholder="contoh: Komunitas Teknologi">
                                    </div>
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg fw-medium auth-form-btn">REGISTER</button>
                                </div>
                                <div class="text-center mt-4 fw-light"> Sudah memiliki akun? <a href="login.php" class="text-primary">Login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->

    <script>
        function showForm() {
            var level = document.getElementById('levelSelect').value;
            document.getElementById('trainerForm').style.display = (level === 'trainer') ? 'block' : 'none';
            document.getElementById('pesertaForm').style.display = (level === 'peserta') ? 'block' : 'none';
        }

        // Tambahkan validasi manual
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            var level = document.getElementById('levelSelect').value;
            var valid = true;
            var errorMessage = '';

            function isVisible(element) {
                return element.offsetWidth > 0 && element.offsetHeight > 0;
            }

            var requiredFields = [];

            if (level === 'peserta') {
                requiredFields = [{
                        selector: 'input[name="nama_peserta"]',
                        name: 'Nama Peserta'
                    },
                    {
                        selector: 'input[name="email"]',
                        name: 'Email'
                    },
                    {
                        selector: 'input[name="telp_peserta"]',
                        name: 'Telepon Peserta'
                    },
                    {
                        selector: 'select[name="gender"]',
                        name: 'Gender'
                    },
                    {
                        selector: 'input[name="domisili"]',
                        name: 'Domisili'
                    },
                    {
                        selector: 'input[name="status_peserta"]',
                        name: 'Status Peserta'
                    },
                    {
                        selector: 'input[name="komunitas"]',
                        name: 'Komunitas'
                    }
                ];
            } else if (level === 'trainer') {
                requiredFields = [{
                        selector: 'input[name="nama_trainer"]',
                        name: 'Nama Trainer'
                    },
                    {
                        selector: 'input[name="sertifikasi"]',
                        name: 'Sertifikasi'
                    },
                    {
                        selector: 'input[name="npwp_trainer"]',
                        name: 'NPWP Trainer'
                    },
                    {
                        selector: 'input[name="bank"]',
                        name: 'Bank'
                    },
                    {
                        selector: 'input[name="rekening"]',
                        name: 'Rekening'
                    },
                    {
                        selector: 'input[name="kontak_trainer"]',
                        name: 'Kontak Trainer'
                    }
                ];
            }

            requiredFields.forEach(function(field) {
                var element = document.querySelector(field.selector);
                if (!isVisible(element) || !element.value.trim()) {
                    valid = false;
                    errorMessage += `${field.name} harus diisi.\n`;
                }
            });

            if (!valid) {
                alert(errorMessage);
                event.preventDefault(); // Mencegah form dikirim
            }
        });
    </script>
</body>

</html>