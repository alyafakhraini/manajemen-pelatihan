<?php
include "../koneksi.php";

$id_keuangan = isset($_GET["id_keuangan"]) ? $_GET["id_keuangan"] : 0;
$id_pelatihan = isset($_GET["id_pelatihan"]) ? $_GET["id_pelatihan"] : 0;

$hapus = mysqli_query($conn, "DELETE FROM tbl_keuangan WHERE id_keuangan = '$id_keuangan'");

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
                      window.location = "keuangan.php?id_pelatihan=' . $id_pelatihan . '";
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
                      window.location = "keuangan.php?id_pelatihan=' . $id_pelatihan . '";
                  });
              </script>
          </body>
          </html>';
}
