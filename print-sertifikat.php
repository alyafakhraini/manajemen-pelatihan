<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["id_pelatihan"]) && isset($_GET["id_peserta"])) {

    $id_pelatihan = $_GET["id_pelatihan"];
    $id_peserta = $_GET["id_peserta"];

    // Ambil data pelatihan dan kategori program
    $query_pelatihan = mysqli_query($conn, "SELECT nama_pelatihan, kategori_program, tgl_pelatihan FROM tbl_pelatihan WHERE id_pelatihan = '$id_pelatihan'");
    $data_pelatihan = mysqli_fetch_assoc($query_pelatihan);
    $nama_pelatihan = $data_pelatihan['nama_pelatihan'];
    $kategori_program = $data_pelatihan['kategori_program'];
    $tanggal_pelatihan = $data_pelatihan['tgl_pelatihan'];

    // Menentukan teks kategori program
    switch ($kategori_program) {
        case 'level up':
            $kategori_program_text = 'Level Up';
            $template_image = 'image/level up.png';
            break;
        case 'psc':
            $kategori_program_text = 'Professional Skill Certificate';
            $template_image = 'image/psc.png';
            break;
        case 'ap':
            $kategori_program_text = 'Acceleration Program';
            $template_image = 'image/ap.png';
            break;
        case 'bootcamp':
            $kategori_program_text = 'Bootcamp';
            $template_image = 'image/bootcamp.png';
            break;
        default:
            $kategori_program_text = ucfirst($kategori_program);
            $template_image = 'image/default.png'; // jika tidak ada kategori yang sesuai
            break;
    }

    // Ambil informasi peserta
    $query_peserta = mysqli_query($conn, "SELECT nama_peserta FROM tbl_peserta WHERE id_peserta = '$id_peserta'");
    $data_peserta = mysqli_fetch_assoc($query_peserta);
    $nama_peserta = $data_peserta['nama_peserta'];

    // Ambil nomor sertifikat
    $query_sertifikat = mysqli_query($conn, "SELECT no_sertif, tgl_terbit_sertif FROM tbl_sertifikat WHERE id_pelatihan = '$id_pelatihan' AND id_peserta = '$id_peserta'");
    $data_sertifikat = mysqli_fetch_assoc($query_sertifikat);
    $nomor_sertifikat = $data_sertifikat['no_sertif'];
    $tgl_terbit_sertif = $data_sertifikat['tgl_terbit_sertif'];

    // Format tanggal terbit
    $bulan_terbit = date('n', strtotime($tgl_terbit_sertif));
    $tanggal_terbit = date('j', strtotime($tgl_terbit_sertif));
    $tahun_terbit = date('Y', strtotime($tgl_terbit_sertif));
    $formatted_tanggal_terbit = $tanggal_terbit . ' ' . getBulanIndonesia($bulan_terbit) . ' ' . $tahun_terbit;
} else {
    $nama_pelatihan = "";
    $kategori_program_text = "";
    $nama_peserta = "";
    $nomor_sertifikat = "";
    $tanggal_pelatihan = "";
    $template_image = 'image/default.png'; // jika tidak ada kategori yang sesuai
}

function getBulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"
    ];
    return $bulanIndo[$bulan];
}

$bulan = date('n', strtotime($tanggal_pelatihan));
$tanggal = date('j', strtotime($tanggal_pelatihan));
$tahun = date('Y', strtotime($tanggal_pelatihan));
$formatted_tanggal = $tanggal . ' ' . getBulanIndonesia($bulan) . ' ' . $tahun;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sertifikat</title>
    <!-- Meta Tag -->
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="handheldfriendly" content="true" />
    <meta name="MobileOptimized" content="width" />
    <meta name="description" content="" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Logo Halaman -->
    <link rel="icon" href="image/bcti_logo.png" type="image/png">
    <!-- Print CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .sertifikat-container {
            position: relative;
            width: 100%;
            height: 100vh;
            background-image: url('<?php echo $template_image; ?>');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sertifikat-content {
            position: absolute;
            text-align: center;
            color: #000;
        }

        .sertifikat-content .nomor-sertifikat {
            font-size: 20px;
            position: relative;
            top: -28px;
            /* Geser ke atas */
        }

        .sertifikat-content h1 {
            font-size: 80px;
        }

        .sertifikat-content h2 {
            font-size: 25px;
            position: relative;
            top: -20px;
            /* Geser ke atas */
        }

        .sertifikat-content p {
            font-size: 18px;
            position: relative;
            top: -20px;
        }

        .ttd {
            position: absolute;
            bottom: 30px;
            right: 50px;
            text-align: center;
            color: #000;
            padding: 20px;
        }

        .ttd p {
            font-size: 14px;
            margin: 0;
        }

        .ttd img {
            max-width: 100px;
            width: 70px;
            height: auto;
            margin: 10px 0;
        }
    </style>
    <script>
        window.print();
    </script>
</head>

<body>
    <div class="sertifikat-container">
        <div class="sertifikat-content">
            <p class="nomor-sertifikat">
                <?php echo $nomor_sertifikat; ?>
            </p>
            <h1><?php echo $nama_peserta; ?></h1>
            <h2>Peserta Pelatihan</h2>
            <p>Telah Berhasil Menyelesaikan Pelatihan <b><?php echo $kategori_program_text; ?>: <?php echo $nama_pelatihan; ?></b> pada Tanggal <?php echo $formatted_tanggal; ?>.</p>
        </div>
        <div class="ttd">
            <p>Barito Kuala, <?php echo $formatted_tanggal_terbit; ?></p>
            <img src="image/ttd.png" alt="Tanda Tangan">
            <p><b><u>Muhammad Zain Mahbuby, B.Eng. (Hons) CETP, CLMA.</u></b></p>
            <p>Koordinator BCTI</p>
        </div>
    </div>
</body>

</html>