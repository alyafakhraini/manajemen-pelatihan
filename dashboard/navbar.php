<?php
if (!isset($_SESSION)) {
    session_start();
}

include "../koneksi.php"; // Memanggil file koneksi
$id_user = $_SESSION['id_user'];

// Ambil foto profil dari database berdasarkan id_user
$query_profile = "SELECT profile, username FROM tbl_user WHERE id_user = $id_user";
$result = $conn->query($query_profile);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $profile = $row['profile'];
    $username = $row['username'];
} else {
    $profile = '';
    $username = '';
}

// Tentukan path gambar profil, jika tidak ada, gunakan user.png
$profile_image = !empty($profile) ? "../profile/" . $profile : "../profile/user.png";
?>

<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div>
            <a class="navbar-brand brand-logo" href="index.php">
                <img src="../image/bcti_logo_panjang.png" alt="logo" style="width: 280px; height: 70px;" />
            </a>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item fw-semibold d-none d-lg-block ms-0">
                <script>
                    function getGreeting() {
                        var now = new Date();
                        var hours = now.getHours();
                        var greeting;

                        if (hours < 12) {
                            greeting = "Selamat Pagi";
                        } else if (hours < 15) {
                            greeting = "Selamat Siang";
                        } else if (hours < 18) {
                            greeting = "Selamat Sore";
                        } else {
                            greeting = "Selamat Malam";
                        }

                        return greeting;
                    }

                    document.addEventListener("DOMContentLoaded", function() {
                        var greetingText = getGreeting();
                        var username = "<?php echo htmlspecialchars($username); ?>";
                        document.getElementById("greeting").innerHTML = greetingText + ", <span class='text-black fw-bold'>" + username + "</span>";
                    });
                </script>
                <h1 class="welcome-text" id="greeting">, <span class="text-black fw-bold"><?php echo htmlspecialchars($username); ?></span></h1>
            </li>
        </ul>

        <ul class="navbar-nav ms-auto">
            <div class="text-gray-600 ml-auto" id="clock2"></div>
            <script type='text/javascript'>
                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
                var date = new Date();
                var day = date.getDate();
                var month = date.getMonth();
                var thisDay = date.getDay(),
                    thisDay = myDays[thisDay];
                var yy = date.getYear();
                var year = (yy < 1000) ? yy + 1900 : yy;
                document.getElementById('clock2').innerHTML = thisDay + ', ' + day + ' ' + months[month] + ' ' + year;
            </script>
            <li class="nav-item">
                <form class="search-form" action="#">
                    <i class="icon-search"></i>
                    <input type="search" class="form-control" placeholder="Search Here" title="Search here">
                </form>
            </li>

            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="<?php echo $profile_image; ?>" alt="Profile image">
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="<?php echo $profile_image; ?>" alt="Profile image" style="width: 40px; height: 40px;">
                        <p class="mb-1 mt-3 fw-semibold"><?php echo htmlspecialchars($username); ?></p>
                    </div>
                    <a class="dropdown-item" href="profile.php"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Profile Saya</a>
                    <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i> Keluar</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>