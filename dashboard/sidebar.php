<?php

// Mengatur role user dari session
$user_role = isset($_SESSION['level']) ? $_SESSION['level'] : '';

// Fungsi untuk mengecek akses berdasarkan role
function canAccess($roleNeeded, $allowedRoles)
{
    return in_array($roleNeeded, $allowedRoles);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .sidebar {
            width: 260px;
            /* Atur lebar sidebar */
        }

        .sidebar .nav {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .sidebar .nav .nav-item {
            width: 100%;
        }

        .sidebar .nav .nav-item .nav-link {
            display: flex;
            align-items: center;
            white-space: nowrap;
            padding: 10px 35px 10px 35px;
            color: #484848;
            transition-duration: 0.45s;
            transition-property: color;
            font-weight: 400;
            width: 100%;
            /* Memastikan elemen mengambil lebar penuh */
            box-sizing: border-box;
            /* Memastikan padding dimasukkan dalam lebar */
            border-radius: 0px 20px 20px 0px;
            overflow: hidden;
            /* Pastikan border-radius terlihat dengan benar */
            background-clip: padding-box;
            /* Membantu dalam menampilkan border-radius dengan benar */
            position: relative;
            /* Membantu dalam memastikan elemen berada di atas elemen lain */
            z-index: 1;
            /* Membantu dalam memastikan elemen berada di atas elemen lain */
        }
    </style>
</head>

<body>
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="mdi mdi-grid-large menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>

            <!-- Back to landing page -->
            <li class="nav-item">
                <a class="nav-link" href="../index.php">
                    <i class="mdi mdi-arrow-left menu-icon"></i>
                    <span class="menu-title">Back to BCTI Page</span>
                </a>
            </li>

            <!-- Manage User (hanya admin yang bisa akses) -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="manage-user.php">
                        <i class="menu-icon mdi mdi-account-key"></i>
                        <span class="menu-title">Manage User</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Main Menu -->
            <li class="nav-item nav-category">Main Menu</li>

            <!-- Agenda BCTI -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#agenda" aria-expanded="false" aria-controls="agenda">
                    <i class="menu-icon mdi mdi-calendar"></i>
                    <span class="menu-title">Agenda BCTI</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="agenda">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="agenda-bcti.php">Agenda Bulanan BCTI</a></li>
                        <?php if (canAccess('admin', [$user_role])) : ?>
                            <li class="nav-item"> <a class="nav-link" href="pelatihan.php">Data Pelatihan</a></li>
                        <?php endif; ?>
                        <li class="nav-item"> <a class="nav-link" href="agenda.php">Data Agenda</a></li>
                    </ul>
                </div>
            </li>

            <!-- Data Peserta (hanya admin yang bisa akses) -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="peserta.php">
                        <i class="menu-icon mdi mdi-account-group"></i>
                        <span class="menu-title">Data Peserta</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Data Trainer -->
            <li class="nav-item">
                <a class="nav-link" href="trainer.php">
                    <i class="menu-icon mdi mdi-account-tie"></i>
                    <span class="menu-title">Data Trainer</span>
                </a>
            </li>

            <!-- Data Pendaftar (hanya admin yang bisa akses) -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="daftar-pelatihan-list.php">
                        <i class="menu-icon mdi mdi-file-document"></i>
                        <span class="menu-title">Data Pendaftar</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Data Kehadiran Peserta -->
            <li class="nav-item">
                <a class="nav-link" href="kehadiran-pelatihan-list.php">
                    <i class="menu-icon mdi mdi-clipboard-check"></i>
                    <span class="menu-title">Data Performa Peserta</span>
                </a>
            </li>

            <!-- Data Test -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#test" aria-expanded="false" aria-controls="evaluasi">
                    <i class="menu-icon mdi mdi-clipboard-text"></i>
                    <span class="menu-title">Data Test Peserta</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="test">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="test-show.php">Data Test (pertanyaan)</a></li>
                        <li class="nav-item"> <a class="nav-link" href="pre-pelatihan-list.php">Pre-Test</a></li>
                        <li class="nav-item"> <a class="nav-link" href="post-pelatihan-list.php">Post-Test</a></li>
                    </ul>
                </div>
            </li>

            <!-- Data Evaluasi -->
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#evaluasi" aria-expanded="false" aria-controls="evaluasi">
                    <i class="menu-icon mdi mdi-clipboard-text"></i>
                    <span class="menu-title">Data Evaluasi</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="evaluasi">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="evaluasi-pelatihan-list.php">Data Evaluasi Pelatihan</a></li>
                        <?php if (canAccess('admin', [$user_role])) : ?>
                            <li class="nav-item"> <a class="nav-link" href="evaluasi-trainer-pelatihan-list.php">Data Evaluasi Trainer</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>

            <!-- Data Sertifikat Peserta -->
            <li class="nav-item">
                <a class="nav-link" href="sertifikat-pelatihan-list.php">
                    <i class="menu-icon mdi mdi-certificate"></i>
                    <span class="menu-title">Data Sertifikat Peserta</span>
                </a>
            </li>

            <!-- Data Keuangan (hanya admin yang bisa akses) -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="keuangan-pelatihan-list.php">
                        <i class="menu-icon mdi mdi-currency-usd"></i>
                        <span class="menu-title">Data Keuangan</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Data Pengaduan -->
            <li class="nav-item">
                <a class="nav-link" href="pengaduan.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Data Pengaduan</span>
                </a>
            </li>


            <!-- Report -->
            <li class="nav-item nav-category">Report</li>

            <!-- Daftar Pelatihan -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="report-program-pelatihan.php">
                        <i class="menu-icon mdi mdi-file-document"></i>
                        <span class="menu-title">Daftar Program Pelatihan</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Jadwal Agenda Bulanan -->
            <li class="nav-item">
                <a class="nav-link" href="report-jadwal.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Jadwal BCTI</span>
                </a>
            </li>

            <!-- Data Trainer -->
            <li class="nav-item">
                <a class="nav-link" href="report-trainer.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Data Trainer</span>
                </a>
            </li>

            <!-- Presensi -->
            <li class="nav-item">
                <a class="nav-link" href="report-presensi.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Presensi Peserta</span>
                </a>
            </li>

            <!-- Data Pendaftar -->
            <li class="nav-item">
                <a class="nav-link" href="report-pendaftar.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Data Pendaftar</span>
                </a>
            </li>

            <!-- Pembayaran Peserta -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="report-pembayaran.php">
                        <i class="menu-icon mdi mdi-file-document"></i>
                        <span class="menu-title">Pembayaran Pendaftaran</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Metode Pembayaran Peserta -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="report-metode-pembayaran.php">
                        <i class="menu-icon mdi mdi-file-document"></i>
                        <span class="menu-title">Metode Pembayaran</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Performa Peserta -->
            <li class="nav-item">
                <a class="nav-link" href="report-performa.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Performa Peserta</span>
                </a>
            </li>

            <!-- Evaluasi Pelatihan -->
            <li class="nav-item">
                <a class="nav-link" href="report-evaluasi-pelatihan.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Evaluasi Pelatihan</span>
                </a>
            </li>

            <!-- Evaluasi Trainer -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="report-evaluasi-trainer.php">
                        <i class="menu-icon mdi mdi-file-document"></i>
                        <span class="menu-title">Evaluasi Trainer</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Sertifikat -->
            <li class="nav-item">
                <a class="nav-link" href="report-sertifikat.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Penerbitan Sertifikat</span>
                </a>
            </li>

            <!-- Keuangan Pelatihan -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="report-keuangan.php">
                        <i class="menu-icon mdi mdi-file-document"></i>
                        <span class="menu-title">Keuangan Pelatihan</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Keuangan Pelatihan -->
            <?php if (canAccess('admin', [$user_role])) : ?>
                <li class="nav-item">
                    <a class="nav-link" href="report-keuangan-kategori.php">
                        <i class="menu-icon mdi mdi-file-document"></i>
                        <span class="menu-title">Keuangan Per Kategori</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Data Pengaduan -->
            <li class="nav-item">
                <a class="nav-link" href="report-pengaduan.php">
                    <i class="menu-icon mdi mdi-file-document"></i>
                    <span class="menu-title">Pengaduan Per Bulan</span>
                </a>
            </li>

        </ul>
    </nav>
</body>