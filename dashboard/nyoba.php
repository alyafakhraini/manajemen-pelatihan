<?php
session_start();
require_once "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_template'])) {
    $id_pelatihan = $_POST['id_pelatihan'];

    // Pastikan ada file yang diunggah
    if (isset($_FILES['template_sertifikat']) && $_FILES['template_sertifikat']['error'] === UPLOAD_ERR_OK) {
        $template_sertifikat = $_FILES["template_sertifikat"]["name"];
        $upload_dir = '../template_sertifikat/';
        $upload_file = $upload_dir . $template_sertifikat;

        // Pindahkan file yang diunggah ke direktori tujuan
        if (move_uploaded_file($_FILES['template_sertifikat']['tmp_name'], $upload_file)) {
            // Lakukan operasi penyimpanan ke database
            $template_sertifikat = mysqli_real_escape_string($conn, $template_sertifikat); // Hindari SQL Injection
            $update_template_query = "INSERT INTO tbl_template_sertifikat (id_pelatihan, template_sertifikat) 
                                    VALUES ('$id_pelatihan', '$template_sertifikat')
                                    ON DUPLICATE KEY UPDATE template_sertifikat = '$template_sertifikat'";

            if (mysqli_query($conn, $update_template_query)) {
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Berhasil!",
                            text: "Template sertifikat berhasil diupload dan disimpan.",
                        });
                      </script>';
            } else {
                echo '<script>
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Gagal menyimpan data template sertifikat ke database: ' . mysqli_error($conn) . '",
                        });
                      </script>';
            }
        } else {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Gagal!",
                        text: "Upload template sertifikat gagal.",
                    });
                  </script>';
        }
    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat mengupload template sertifikat.",
                });
              </script>';
    }
}
?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data" class="mb-3">
    <div class="form-group row">
        <input type="hidden" name="id_pelatihan" value="<?php echo isset($_POST['id_pelatihan']) ? $_POST['id_pelatihan'] : ''; ?>">
        <label for="template_sertifikat_lama" class="col-sm-2 col-form-label">Template Sertifikat Lama</label>
        <div class="col-sm-10">
            <?php
            // Tampilkan gambar template sertifikat lama jika ada
            $template_sertifikat_query = "SELECT template_sertifikat FROM tbl_template_sertifikat WHERE id_pelatihan = '$id_pelatihan'";
            $template_sertifikat_result = mysqli_query($conn, $template_sertifikat_query);

            if ($template_sertifikat_result && mysqli_num_rows($template_sertifikat_result) > 0) {
                $template_sertifikat_row = mysqli_fetch_assoc($template_sertifikat_result);
                $template_sertifikat_lama = $template_sertifikat_row['template_sertifikat'];
                echo '<img src="../template_sertifikat/' . $template_sertifikat_lama . '" alt="template_sertifikat" class="img-thumbnail" width="200">';
            } else {
                echo '<span class="text-muted">Belum ada template sertifikat.</span>';
            }
            ?>
        </div>
    </div>
    <div class="form-group row">
        <label for="template_sertifikat_baru" class="col-sm-2 col-form-label">Template Sertifikat Baru</label>
        <div class="col-sm-10">
            <input type="file" class="form-control-file" name="template_sertifikat" id="template_sertifikat">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-10 offset-sm-2">
            <button type="submit" class="btn btn-primary" name="submit_template">Submit</button>
        </div>
    </div>
</form>