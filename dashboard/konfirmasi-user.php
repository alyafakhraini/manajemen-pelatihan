<?php
include "../koneksi.php";

$id_user = isset($_GET["id_user"]) ? $_GET["id_user"] : 0;

$update = mysqli_query($conn, "UPDATE tbl_user SET status = 'aktif' WHERE id_user = '$id_user'");

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
                      text: "User berhasil dikonfirmasi.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "manage-user.php?";
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
                      text: "Terjadi kesalahan saat mengkonfirmasi user.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "manage-user.php";
                  });
              </script>
          </body>
          </html>';
}
