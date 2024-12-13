<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'admin' && $level != 'panitia') {
    header("Location: ../login.php");
    exit;
}

$id_pengaduan = isset($_GET["id_pengaduan"]) ? $_GET["id_pengaduan"] : 0;
$tanggapan_admin = isset($_GET["tanggapan_admin"]) ? $_GET["tanggapan_admin"] : '';

$update = mysqli_query($conn, "UPDATE tbl_pengaduan SET status_pengaduan = 'done', tanggapan_admin = '$tanggapan_admin' WHERE id_pengaduan = '$id_pengaduan'");

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
                          text: "Penanganan pengaduan berhasil dikonfirmasi.",
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
                      text: "Terjadi kesalahan saat mengkonfirmasi penanganan pengaduan.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "pengaduan.php";
                  });
              </script>
          </body>
          </html>';
}
