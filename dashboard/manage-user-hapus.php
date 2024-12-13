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

// Hapus data terkait di tbl_trainer
$hapus_trainer = mysqli_query($conn, "DELETE FROM tbl_trainer WHERE id_user = '$id_user'");

// Hapus data terkait di tbl_peserta
$hapus_peserta = mysqli_query($conn, "DELETE FROM tbl_peserta WHERE id_user = '$id_user'");

if ($hapus_trainer && $hapus_peserta) {
    // Jika berhasil menghapus data terkait, hapus data user
    $hapus_user = mysqli_query($conn, "DELETE FROM tbl_user WHERE id_user = '$id_user'");

    if ($hapus_user) {
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
                          window.location = "manage-user.php";
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
                          text: "Terjadi kesalahan saat menghapus data user.",
                          showConfirmButton: false,
                          timer: 1500
                      }).then(() => {
                          window.location = "manage-user.php";
                      });
                  </script>
              </body>
              </html>';
    }
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
                      text: "Terjadi kesalahan saat menghapus data peserta atau trainer terkait.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "manage-user.php";
                  });
              </script>
          </body>
          </html>';
}
