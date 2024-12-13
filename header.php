<?php
ob_start();

$load_dashboard_css = isset($load_dashboard_css) ? $load_dashboard_css : false;

$current_url = $_SERVER['REQUEST_URI'];
$id_user = isset($_SESSION['id_user']) ? $_SESSION['id_user'] : null;
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

function isMenuActive($url)
{
    global $current_url;
    return strpos($current_url, $url) !== false ? 'active' : '';
}

// Default profile image jika tidak ada
$default_profile_image = "profile/user.png";
$profile_image = $default_profile_image;

if ($id_user) {
    $query_profile = "SELECT profile FROM tbl_user WHERE id_user = ?";
    $stmt_profile = $conn->prepare($query_profile);
    $stmt_profile->bind_param("i", $id_user);
    $stmt_profile->execute();
    $stmt_profile->bind_result($profile);
    $stmt_profile->fetch();
    $stmt_profile->close();

    if (!empty($profile)) {
        $profile_image = "profile/" . $profile;
    }
}
?>

<header class="header_area">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand logo_h" href="index.php"><img src="image/bcti_logo.png" alt="" width="80" height="50" /></a>
                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
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
                                document.getElementById("greeting").innerHTML = greetingText + ", " + username + "</span>";
                            });
                        </script>
                        <?php if ($user_level) : ?>
                            <li class="nav-item">
                                <a class="nav-link" id="greeting"></a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item <?php echo isMenuActive('index.php'); ?>">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>
                        <li class="nav-item <?php echo isMenuActive('about-us.php'); ?>">
                            <a class="nav-link" href="about-us.php">About</a>
                        </li>
                        <li class="nav-item <?php echo isMenuActive('courses.php'); ?>">
                            <a class="nav-link" href="courses.php">Pelatihan</a>
                        </li>
                        <?php if ($user_level == 'peserta') : ?>
                            <li class="nav-item <?php echo isMenuActive('my-course.php'); ?>">
                                <a class="nav-link" href="my-course.php">Pelatihan Saya</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($user_level == 'peserta') : ?>
                            <li class="nav-item <?php echo isMenuActive('pengaduan-peserta.php'); ?>">
                                <a class="nav-link" href="pengaduan-peserta.php">Pengaduan</a>
                            </li>
                        <?php endif; ?>
                        <?php if (in_array($user_level, ['admin', 'panitia'])) : ?>
                            <li class="nav-item <?php echo isMenuActive('dashboard/index.php'); ?>">
                                <a class="nav-link" href="dashboard/index.php">Panel internal</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($user_level == 'trainer') : ?>
                            <li class="nav-item <?php echo isMenuActive('trainer-schedule.php'); ?>">
                                <a class="nav-link" href="trainer-schedule.php">Trainer</a>
                            </li>
                        <?php endif; ?>
                        <?php if ($user_level) : ?>
                            <li class="nav-item submenu dropdown">
                                <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <img class="img-xs rounded-circle" src="<?php echo $profile_image; ?>" alt="Profile image" style="width: 30px; height: 30px;">
                                </a>
                                <ul class="dropdown-menu">
                                    <div class="dropdown-header text-center">
                                        <img class="img-md rounded-circle" src="<?php echo $profile_image; ?>" alt="Profile image" style="width: 40px; height: 40px;">
                                        <p class="mb-1 mt-3 fw-semibold"><?php echo htmlspecialchars($username); ?></p>
                                    </div>
                                    <a class="dropdown-item" href="profile.php"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Profil Saya</a>
                                    <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i> Keluar</a>
                                </ul>
                            </li>
                        <?php else : ?>
                            <li class="nav-item ">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>

                </div>
            </div>
        </nav>

    </div>
</header>

<!-- Jika memerlukan CSS dashboard, muat di sini -->
<?php if ($load_dashboard_css) : ?>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- css dashboard -->
<?php endif; ?>

<link rel="stylesheet" href="assets/vendors/feather/feather.css">
<link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
<link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Plugin css for this page -->
<link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">

<?php
ob_end_flush(); // Akhiri output buffering sebelum selesai
?>