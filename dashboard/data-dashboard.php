<?php
include "../koneksi.php"; // Mengimpor koneksi database

function get_statistics($conn)
{
    // Query untuk mendapatkan jumlah data dari tabel
    $queries = [
        'pelatihan_bcti' => "SELECT COUNT(*) as count FROM tbl_pelatihan",
        'peserta_terdaftar' => "SELECT COUNT(*) as count FROM tbl_peserta",
        'trainer_terdaftar' => "SELECT COUNT(*) as count FROM tbl_trainer",
        'keuangan' => "SELECT COUNT(*) as count FROM tbl_keuangan",
        //'keuangan' => "SELECT SUM(amount) as total FROM tbl_keuangan"
    ];

    $stats = [];
    foreach ($queries as $key => $query) {
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stats[$key] = $row['count'] ?? $row['total'];
        } else {
            $stats[$key] = 0;
        }
    }

    return $stats;
}
