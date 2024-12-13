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

$id_pendaftaran = isset($_GET["id_pendaftaran"]) ? $_GET["id_pendaftaran"] : 0;
$id_pelatihan = isset($_GET["id_pelatihan"]) ? $_GET["id_pelatihan"] : 0;

// Hapus data dari tbl_evaluasi_trainer terlebih dahulu
$hapus_evaluasi_trainer = mysqli_query($conn, "DELETE FROM tbl_evaluasi_trainer WHERE id_kehadiran IN (SELECT id_kehadiran FROM tbl_kehadiran WHERE id_pendaftaran = '$id_pendaftaran')");

if ($hapus_evaluasi_trainer) {
    // Hapus data dari tbl_sertifikat
    $hapus_sertifikat = mysqli_query($conn, "DELETE FROM tbl_sertifikat WHERE id_kehadiran IN (SELECT id_kehadiran FROM tbl_kehadiran WHERE id_pendaftaran = '$id_pendaftaran')");

    if ($hapus_sertifikat) {
        // Hapus data dari tbl_evaluasi_pelatihan
        $hapus_evaluasi = mysqli_query($conn, "DELETE FROM tbl_evaluasi_pelatihan WHERE id_kehadiran IN (SELECT id_kehadiran FROM tbl_kehadiran WHERE id_pendaftaran = '$id_pendaftaran')");

        if ($hapus_evaluasi) {
            // Hapus data dari tbl_kehadiran
            $hapus_kehadiran = mysqli_query($conn, "DELETE FROM tbl_kehadiran WHERE id_pendaftaran = '$id_pendaftaran'");

            if ($hapus_kehadiran) {
                // Hapus data dari tbl_pendaftaran
                $hapus_pendaftaran = mysqli_query($conn, "DELETE FROM tbl_pendaftaran WHERE id_pendaftaran = '$id_pendaftaran'");

                if ($hapus_pendaftaran) {
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
                                      window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
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
                                      text: "Terjadi kesalahan saat menghapus data pendaftaran.",
                                      showConfirmButton: false,
                                      timer: 1500
                                  }).then(() => {
                                      window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
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
                                  text: "Terjadi kesalahan saat menghapus data kehadiran.",
                                  showConfirmButton: false,
                                  timer: 1500
                              }).then(() => {
                                  window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
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
                              text: "Terjadi kesalahan saat menghapus data evaluasi.",
                              showConfirmButton: false,
                              timer: 1500
                          }).then(() => {
                              window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
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
                          text: "Terjadi kesalahan saat menghapus data sertifikat.",
                          showConfirmButton: false,
                          timer: 1500
                      }).then(() => {
                          window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
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
                      text: "Terjadi kesalahan saat menghapus data evaluasi trainer.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
                  });
              </script>
          </body>
          </html>';
}
