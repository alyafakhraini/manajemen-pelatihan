<?php
include "../koneksi.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../login.php");
    exit;
}

$level = $_SESSION['level'];

if ($level != 'admin') {
    header("Location: access-denied.php");
    exit;
}

function getBulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];
    return $bulanIndo[$bulan];
}

function getKategoriProgramText($kategori_program)
{
    switch ($kategori_program) {
        case 'level up':
            return 'Level Up';
        case 'ap':
            return 'Acceleration Program';
        case 'psc':
            return 'Professional Skill Certificate';
        case 'bootcamp':
            return 'Bootcamp';
        default:
            return 'Tidak Diketahui';
    }
}

$id_pendaftaran = isset($_GET["id_pendaftaran"]) ? $_GET["id_pendaftaran"] : 0;
$id_pelatihan = isset($_GET["id_pelatihan"]) ? $_GET["id_pelatihan"] : 0;
$status_pembayaran = isset($_GET["status_pembayaran"]) ? $_GET["status_pembayaran"] : '';
$keterangan = isset($_GET["keterangan"]) ? $_GET["keterangan"] : '';

// Memperbarui status pembayaran dan keterangan di database
$update_query = "UPDATE tbl_pendaftaran SET status_pembayaran = '$status_pembayaran', keterangan = '$keterangan' WHERE id_pendaftaran = '$id_pendaftaran'";
$result_update = mysqli_query($conn, $update_query);

if (!$result_update) {
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
                      text: "Gagal memperbarui status pembayaran di database.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
                  });
              </script>
          </body>
          </html>';
    exit;
}

$query_email = mysqli_query($conn, "SELECT peserta.email, peserta.nama_peserta, pelatihan.kategori_program, pelatihan.nama_pelatihan, pelatihan.waktu, pelatihan.tempat, pelatihan.link_grub, pelatihan.tgl_pelatihan
                                    FROM tbl_pendaftaran AS daftar 
                                    JOIN tbl_pelatihan AS pelatihan ON daftar.id_pelatihan = pelatihan.id_pelatihan
                                    JOIN tbl_peserta AS peserta ON daftar.id_peserta = peserta.id_peserta
                                    WHERE daftar.id_pendaftaran = '$id_pendaftaran'");
$result = mysqli_fetch_assoc($query_email);

if ($result) {
    $email = $result['email'];
    $nama_peserta = $result['nama_peserta'];
    $kategori_program_text = getKategoriProgramText($result['kategori_program']);
    $nama_pelatihan = $result['nama_pelatihan'];
    $link_grub = $result['link_grub'];
    $tempat = $result['tempat'];
    $waktu = $result['waktu'];

    // Pastikan $result mengandung data yang benar dari query
    if (!empty($result['tgl_pelatihan'])) {
        $tgl_pelatihan = date("Y-m-d", strtotime($result['tgl_pelatihan']));
        $tanggal = date("d", strtotime($tgl_pelatihan));
        $bulan = date("n", strtotime($tgl_pelatihan));
        $tahun = date("Y", strtotime($tgl_pelatihan));
        $tgl_pelatihan = "$tanggal " . getBulanIndonesia($bulan) . " $tahun";
    } else {
        $tgl_pelatihan = "Tanggal Pelatihan Tidak Tersedia";
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'testingaplikasi22@gmail.com';
        $mail->Password = 'sxcbmfqifwxuiebq';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('testingaplikasi22@gmail.com', 'BCTI');
        $mail->addAddress($email);

        $mail->isHTML(true);

        if ($status_pembayaran == 'confirmed') {
            $mail->Subject = "Konfirmasi Pembayaran $kategori_program_text: $nama_pelatihan Berhasil";
            $mail->Body = "
            Halo, <b>$nama_peserta</b>!
            <br><br>
            Pembayaran Anda untuk pelatihan <b>$kategori_program_text: $nama_pelatihan</b> telah berhasil dikonfirmasi.
            <br><br>
            Silahkan bergabung dengan grup ini agar tidak ketinggalan informasi mengenai pelatihan:
            <br>
            <a href='$link_grub'>$link_grub</a>
            <br><br>
            Sampai bertemu di <b>$tempat</b> pada tanggal <b>$tgl_pelatihan</b> jam <b>$waktu</b>. Terima kasih.
            <br><br>
            Tertanda,<br>
            <b>BCTI</b>";

            $mail->send();
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
                              text: "Pembayaran berhasil dikonfirmasi. Email telah terkirim",
                              showConfirmButton: false,
                              timer: 1500
                          }).then(() => {
                              window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
                          });
                      </script>
                  </body>
                  </html>';
        } elseif ($status_pembayaran == 'failed') {
            $mail->Subject = "Pembayaran Untuk $kategori_program_text: $nama_pelatihan Gagal";
            $mail->Body = "
            Halo, <b>$nama_peserta</b>!
            <br><br>
            Mohon maaf atas ketidaknyamanannya. Kami informasikan bahwa kami belum dapat mengkonfirmasi
            pembayaran Anda untuk pelatihan <b>$kategori_program_text: $nama_pelatihan</b>. Oleh karena itu,
            saat ini pendaftaran Anda masih dalam status <b>pending</b>.
            <br><br>
            Berikut detail terkait kegagalan pendaftaran:
            <b>$keterangan</b>
            <br><br>
            Langkah-langkah yang dapat Anda lakukan untuk mengupdate form pendaftaran:
            <ol>
                <li>Buka website BCTI dan login</li>
                <li>Buka halaman <b>Pelatihan Saya</b> dan temukan pelatihan <b>$kategori_program_text: $nama_pelatihan</b></li>
                <li>Perhatikan status pembayaran anda pada pelatihan tersebut. Klik <b>Edit Form Pendaftaran</b> untuk memperbaharui Formulir Pendaftaran</li>
            </ol>
            <br>
            Terimakasih atas perhatian anda.
            <br><br>
            Tertanda,<br>
            <b>BCTI</b>";

            $mail->send();
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
                              title: "Status Pembayaran Gagal!",
                              text: "Email konfirmasi pembayaran gagal telah terkirim.",
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
                              text: "Status pembayaran tidak valid.",
                              showConfirmButton: false,
                              timer: 1500
                          }).then(() => {
                              window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
                          });
                      </script>
                  </body>
                  </html>';
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
                      text: "Gagal mengambil data peserta.",
                      showConfirmButton: false,
                      timer: 1500
                  }).then(() => {
                      window.location = "daftar-show.php?id_pelatihan=' . $id_pelatihan . '";
                  });
              </script>
          </body>
          </html>';
}
