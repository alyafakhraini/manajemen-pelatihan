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

$id_kehadiran = isset($_GET["id_kehadiran"]) ? $_GET["id_kehadiran"] : 0;
$id_pelatihan = isset($_GET["id_pelatihan"]) ? $_GET["id_pelatihan"] : 0;
$id_peserta = isset($_GET["id_peserta"]) ? $_GET["id_peserta"] : 0;

$update = mysqli_query($conn, "UPDATE tbl_kehadiran SET status_kehadiran = 'hadir' WHERE id_kehadiran = '$id_kehadiran'");

if ($update) {
    // Insert data ke tbl_sertifikat
    $insert_sertifikat_query = "INSERT INTO tbl_sertifikat (id_kehadiran, id_pelatihan, id_peserta, no_sertif, tgl_terbit_sertif)
                                VALUES ('$id_kehadiran', '$id_pelatihan', '$id_peserta', '', 'NULL')";
    $insert_sertifikat = mysqli_query($conn, $insert_sertifikat_query);

    if ($insert_sertifikat) {
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
                          text: "Kehadiran berhasil dikonfirmasi.",
                          showConfirmButton: false,
                          timer: 1500
                      }).then(() => {
                          window.location = "kehadiran-show.php?id_pelatihan=' . $id_pelatihan . '";
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
                          text: "Terjadi kesalahan saat memasukkan data sertifikat.",
                          showConfirmButton: false,
                          timer: 1500
                      }).then(() => {
                          window.location = "kehadiran-show.php?id_pelatihan=' . $id_pelatihan . '";
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
                      text: "Terjadi kesalahan saat mengkonfirmasi kehadiran.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "kehadiran-show.php?id_pelatihan=' . $id_pelatihan . '";
                  });
              </script>
          </body>
          </html>';
}
