<?php
include "../koneksi.php";

$id_pengaduan = $_GET["id_pengaduan"];

$hapus = mysqli_query($conn, "DELETE FROM tbl_pengaduan WHERE id_pengaduan = '$id_pengaduan'");

if ($hapus) {
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
                      text: "Data berhasil dihapus.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "pengaduan.php";
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
                      text: "Terjadi kesalahan saat menghapus data.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "pengaduan.php";
                  });
              </script>
          </body>
          </html>';
}
