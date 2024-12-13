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

    // Ambil data pelatihan dan peserta
    $query = mysqli_query($conn, "SELECT P.nama_pelatihan, P.tempat, P.tgl_pelatihan, P.waktu, C.nama_peserta, P.kategori_program, D.kelas  
                                  FROM tbl_pendaftaran D
                                  JOIN tbl_pelatihan P ON D.id_pelatihan = P.id_pelatihan
                                  JOIN tbl_peserta C ON D.id_peserta = C.id_peserta
                                  WHERE D.id_pelatihan = '$id_pelatihan' 
                                  AND D.id_peserta = '$id_peserta'
                                  AND D.status_pembayaran = 'confirmed'");

    $data = mysqli_fetch_assoc($query);
    if ($data) {
        $nama_pelatihan = $data['nama_pelatihan'];
        $tempat = $data['tempat'];
        $tgl_pelatihan = date("d", strtotime($data['tgl_pelatihan'])) . ' ' . getBulanIndonesia(date("n", strtotime($data['tgl_pelatihan']))) . ' ' . date("Y", strtotime($data['tgl_pelatihan']));
        $waktu = $data['waktu'];
        $nama_peserta = strtoupper($data['nama_peserta']);
        $kategori_program = $data['kategori_program'];
        $kelas = $data['kelas'];

        // Tentukan warna gradasi berdasarkan kategori program
        switch ($kategori_program) {
            case 'level up':
                $bg_color_start = '#9f5dc7';
                $bg_color_end = '#6ab7ff';
                break;
            case 'psc':
                $bg_color_start = '#ff8f33';
                $bg_color_end = '#4d8ae8';
                break;
            case 'ap':
                $bg_color_start = '#4c8adb';
                $bg_color_end = '#ffb84d';
                break;
            case 'bootcamp':
                $bg_color_start = '#35cb88';
                $bg_color_end = '#6ab7ff';
                break;
            default:
                $bg_color_start = '#6ab7ff'; // Warna default
                $bg_color_end = '#8a85ff';   // Warna default
        }
    } else {
        echo "Data tidak ditemukan!";
        exit;
    }
} else {
    echo "ID Pelatihan atau ID Peserta tidak ditemukan!";
    exit;
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ID CARD Peserta</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="image/bcti_logo.png" type="image/png">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .print-area {
            width: 595px;
            height: 842px;
            padding: 20px;
            box-sizing: border-box;
            position: relative;
            border: 1px solid #ddd;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .id-card {
            width: 350px;
            height: 500px;
            border: 1px solid #e0e0e0;
            padding: 0px 20px 0px 20px;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            box-sizing: border-box;
            background: linear-gradient(135deg, <?php echo $bg_color_start; ?>, <?php echo $bg_color_end; ?>);
            border-radius: 10px;
            color: #fff;
        }

        .logo-bcti {
            width: 150px;
            margin: 0 auto 20px auto;
            padding: 5px 8px 3px 8px;
            background-color: #fff;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .logo-bcti img {
            width: 100%;
            display: block;
        }

        .id-card h4 {
            text-align: left;
            font-size: 14px;
            margin: 5px 0;
            color: #f0f0f0;
        }

        .id-card h3 {
            text-align: center;
            font-size: 18px;
            margin: 2px 0;
            font-weight: 600;
            color: #f0f0f0;
        }

        .id-card .participant-name {
            font-size: 28px;
            font-weight: bold;
            margin: 80px 0 10px 0;
            border-bottom: 2px solid #fff;
            padding-bottom: 10px;
        }

        .id-card .role {
            font-size: 18px;
            margin-top: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #fff;
        }

        @media print {

            body,
            .print-area {
                margin: 0;
                padding: 0;
            }

            .print-area {
                width: 100%;
                height: 100%;
                border: none;
                box-shadow: none;
            }

            .id-card {
                border: 1px solid #000;
            }
        }
    </style>
</head>

<body>
    <div class="print-area">
        <div class="id-card">
            <div class="logo-bcti">
                <img src="image/bcti_logo_panjang.png" alt="Logo BCTI">
            </div>
            <br><br>
            <h4>
                <?php echo getKategoriProgramText($kategori_program) . ': ' . $nama_pelatihan; ?>
            </h4>
            <h4><?php echo $tempat; ?></h4>
            <h4><?php echo $tgl_pelatihan . ' (' . $waktu . ')'; ?></h4>

            <div class="participant-name">
                <?php echo $nama_peserta; ?>
            </div>
            <div class="role">
                Peserta
            </div>
            <h3>(<?php echo $kelas; ?>)</h3>
        </div>
    </div>
</body>

</html>