<?php

date_default_timezone_set('Asia/Makassar');

$redirect_to_login = !isset($_SESSION['id_user']);

if (!$redirect_to_login) {
    $id_pelatihan = isset($_GET['id_pelatihan']) ? (int)$_GET['id_pelatihan'] : 0;
    $nama_peserta = '';

    // Mengambil id_peserta dari sesi
    if (isset($_SESSION['id_peserta'])) {
        $id_peserta_selected = (int)$_SESSION['id_peserta'];
        $query = "SELECT nama_peserta FROM tbl_peserta WHERE id_peserta = $id_peserta_selected";
        $result = mysqli_query($conn, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $nama_peserta = $row['nama_peserta'];
        }
    }

    if ($id_pelatihan > 0) {
        $sql_pelatihan = "SELECT * FROM tbl_pelatihan WHERE id_pelatihan = $id_pelatihan";
        $result_pelatihan = mysqli_query($conn, $sql_pelatihan);
        if ($row_pelatihan = mysqli_fetch_assoc($result_pelatihan)) {
            $status_kegiatan = $row_pelatihan['status_kegiatan'];
            $harga = $row_pelatihan['harga'];

            // Cek apakah peserta sudah mendaftar di pelatihan ini
            $sql_check_pendaftaran = "SELECT * FROM tbl_pendaftaran WHERE id_pelatihan = $id_pelatihan AND id_peserta = $id_peserta_selected";
            $result_check_pendaftaran = mysqli_query($conn, $sql_check_pendaftaran);

            if (mysqli_num_rows($result_check_pendaftaran) > 0) {
                $sudah_mendaftar = true;
            } else {
                $sudah_mendaftar = false;
            }

            // Menghitung jumlah peserta di pelatihan ini
            $sql_count_peserta = "SELECT COUNT(*) as total_peserta FROM tbl_pendaftaran WHERE id_pelatihan = $id_pelatihan";
            $result_count_peserta = mysqli_query($conn, $sql_count_peserta);
            $row_count_peserta = mysqli_fetch_assoc($result_count_peserta);
            $total_peserta = (int)$row_count_peserta['total_peserta'];

            // Mendefinisikan label kelas
            $kelas_labels = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
            $kelas_index = floor($total_peserta / 10); // Hitung indeks kelas
            $kelas_index = min($kelas_index, count($kelas_labels) - 1); // Batasi agar tidak lebih dari jumlah kelas yang tersedia
            $kelas_label = 'Kelas ' . $kelas_labels[$kelas_index];
        } else {
            echo "Pelatihan tidak ditemukan.";
            exit;
        }

        // Mengecek apakah form telah disubmit
        if (isset($_POST["submit"])) {
            // Mengambil nilai input dari form
            $id_pelatihan = (int)$_POST['id_pelatihan'];
            $id_peserta = (int)$_POST['id_peserta'];
            $tgl_daftar = date('Y-m-d H:i:s');
            $metode_pembayaran = mysqli_real_escape_string($conn, $_POST['metode_pembayaran']);
            $jml_pembayaran = mysqli_real_escape_string($conn, $_POST['jml_pembayaran']);
            $bukpem = $_FILES["bukpem"]["name"];

            // Upload bukti pembayaran
            $upload_dir = 'bukpem/';
            $upload_file = $upload_dir . basename($bukpem);
            if (move_uploaded_file($_FILES['bukpem']['tmp_name'], $upload_file)) {

                // Simpan data ke tbl_pendaftaran
                $sql_pendaftaran = "INSERT INTO tbl_pendaftaran (id_pelatihan, id_peserta, tgl_daftar, metode_pembayaran, jml_pembayaran, bukpem, status_pembayaran, keterangan, kelas) 
                                    VALUES ($id_pelatihan, $id_peserta, '$tgl_daftar', '$metode_pembayaran', '$jml_pembayaran', '$bukpem', '', '', '$kelas_label')";

                if (mysqli_query($conn, $sql_pendaftaran)) {
                    // Ambil ID pendaftaran terakhir yang diinsert
                    $id_pendaftaran_baru = mysqli_insert_id($conn);

                    // Simpan data kehadiran ke tbl_kehadiran
                    $sql_kehadiran = "INSERT INTO tbl_kehadiran (id_pendaftaran, status_kehadiran, nilai, saran) 
                                      VALUES ($id_pendaftaran_baru, '', '', '')";

                    if (mysqli_query($conn, $sql_kehadiran)) {
?>
                        <!DOCTYPE html>
                        <html lang="en">

                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Form Pendaftaran - <?php echo htmlspecialchars($row_pelatihan['nama_pelatihan'], ENT_QUOTES, 'UTF-8'); ?></title>
                            <link rel="stylesheet" href="css/bootstrap.css" />
                            <link rel="stylesheet" href="css/style.css" />
                            <link rel="stylesheet" href="assets/css/style.css" /> <!-- css dashboard -->
                        </head>

                        <body>
                            <div class="section-top-border">
                                <div class="col-12 grid-margin stretch-card">
                                    <div class="card">
                                        <div class="card-body">
                                            <h2 class="title">Form Pendaftaran - <?php echo htmlspecialchars($row_pelatihan['nama_pelatihan'], ENT_QUOTES, 'UTF-8'); ?> </h2>
                                            <div class="alert alert-success text-center" role="alert">
                                                Pendaftaran berhasil! Silakan tunggu informasi selanjutnya di <a href="my-course.php" class="alert-link">Pelatihan Saya</a>.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </body>

                        </html>
<?php
                        exit; // Keluar dari skrip setelah menampilkan pesan
                    } else {
                        echo "Gagal menyimpan kehadiran.";
                    }
                } else {
                    echo "Gagal menyimpan pendaftaran.";
                }
            } else {
                echo "Gagal meng-upload bukti pembayaran.";
            }
        }
    }
} else {
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran - <?php echo htmlspecialchars($row_pelatihan['nama_pelatihan'], ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="assets/css/style.css" /> <!-- css dashboard -->
</head>

<body>
    <div class="section-top-border">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h2 class="title">Form Pendaftaran - <?php echo htmlspecialchars($row_pelatihan['nama_pelatihan'], ENT_QUOTES, 'UTF-8'); ?> </h2>
                    <?php if ($redirect_to_login) : ?>
                        <div class="alert alert-warning" role="alert">
                            Anda harus login terlebih dahulu untuk mengisi form pendaftaran. <a href="login.php">Login</a>
                        </div>

                    <?php elseif ($status_kegiatan == 'done') : ?>
                        <div class="alert alert-primary text-center" role="alert">
                            Pelatihan ini telah selesai.
                        </div>
                    <?php elseif ($sudah_mendaftar) : ?>
                        <div class="alert alert-info text-center" role="alert">
                            Anda sudah mendaftar di pelatihan ini. Untuk informasi lebih lanjut, silahkan cek <a href="my-course.php" class="alert-link">Pelatihan Saya</a>.
                        </div>
                    <?php else : ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, 'UTF-8') . "?id_pelatihan=" . htmlspecialchars($id_pelatihan, ENT_QUOTES, 'UTF-8'); ?>" enctype="multipart/form-data">
                            <div>
                                <input type="hidden" name="id_pelatihan" value="<?php echo $id_pelatihan; ?>">
                                <input type="hidden" name="id_peserta" value="<?php echo $id_peserta_selected; ?>">
                                <input type="hidden" id="tgl_daftar" name="tgl_daftar">
                            </div>
                            <div class="form-group row">
                                <label for="id_peserta" class="col-sm-2 col-form-label">Nama</label>
                                <div class="col-sm-10 mt-3">
                                    <span><strong><?php echo $nama_peserta; ?></strong></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="metode_pembayaran" class="col-sm-2 col-form-label">Metode Pembayaran</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <select name="metode_pembayaran" id="metode_pembayaran" class="form-control" required>
                                            <option value="">-- Pilih Metode Pembayaran --</option>
                                            <option value="tf">Transfer (Mandiri an. Yayasan Hasnur Centre: 0310019368888)</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jml_pembayaran" class="col-sm-2 col-form-label">Jumlah Pembayaran</label>
                                <div class="col-sm-10 mt-3">
                                    <span><strong><?php echo 'Rp. ' . number_format($harga, 0, ',', '.') . ',-'; ?></strong></span>
                                    <input type="hidden" name="jml_pembayaran" value="<?php echo $harga; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bukpem" class="col-sm-2 col-form-label">Upload Bukti Pembayaran</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="bukpem" accept="image/*,application/pdf" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button type="submit" name="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>