<?php
session_start(); // Memulai sesi

// Menghapus semua variabel sesi
$_SESSION = array();

// Jika ada cookie sesi, hapus cookie tersebut
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Mengakhiri sesi
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>

<body>
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        // Tampilkan SweetAlert untuk konfirmasi logout
        Swal.fire({
            title: 'Logout',
            text: 'Anda yakin ingin logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika dikonfirmasi, tampilkan SweetAlert sedang diarahkan kembali
                Swal.fire({
                    title: 'Logout',
                    text: 'Anda sedang diarahkan kembali ke halaman utama...',
                    icon: 'info',
                    showConfirmButton: false,
                    timer: 1500, // Durasi SweetAlert ditampilkan (dalam milidetik)
                    timerProgressBar: true
                }).then(() => {
                    // Setelah SweetAlert ditampilkan, arahkan ke halaman utama
                    window.location = '../index.php'; // Pastikan untuk mengarahkan ke folder yang benar
                });
            } else {
                // Jika tidak dikonfirmasi, arahkan kembali ke halaman sebelumnya
                window.history.back();
            }
        });
    </script>
</body>

</html>