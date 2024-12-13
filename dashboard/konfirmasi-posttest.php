<?php
include "../koneksi.php";

$id_konfirmasi = isset($_GET["id_konfirmasi"]) ? $_GET["id_konfirmasi"] : 0;
$id_pelatihan = isset($_GET["id_pelatihan"]) ? $_GET["id_pelatihan"] : 0;
$id_peserta = isset($_GET["id_peserta"]) ? $_GET["id_peserta"] : 0;

$update = mysqli_query($conn, "UPDATE tbl_konfirmasi_test SET status_post = 'done' WHERE id_konfirmasi = '$id_konfirmasi'");

if ($update) {
    echo '<!DOCTYPE html>
              <html lang="en">
              <head>
                  <meta charset="UTF-8">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <title>Success</title>
                  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
              </head>
              <body>
                  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
                  <script>
                      Swal.fire({
                          icon: "success",
                          title: "Berhasil!",
                          text: "Pengisian Post-Test berhasil dikonfirmasi.",
                          showConfirmButton: false,
                          timer: 1500
                      }).then(() => {
                          window.location = "test-pengisian.php?id_pelatihan=' . $id_pelatihan . '";
                      });
                  </script>
              </body>
              </html>';
} else {
    echo '<!DOCTYPE html>
          <html lang="en">
          <head>
              <meta charset="UTF-8">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Error</title>
              <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
          </head>
          <body>
              <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
              <script>
                  Swal.fire({
                      icon: "error",
                      title: "Oops...",
                      text: "Terjadi kesalahan saat mengkonfirmasi pengisian Post-Test.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "test-pengisian.php?id_pelatihan=' . $id_pelatihan . '";
                  });
              </script>
          </body>
          </html>';
}
