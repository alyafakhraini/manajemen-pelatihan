<?php
session_start();
include "koneksi.php";

$user_level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" href="image/bcti_logo.png" type="image/png" />
  <title>BCTI - Naikin Level mu!</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.css" />
  <link rel="stylesheet" href="css/flaticon.css" />
  <link rel="stylesheet" href="css/themify-icons.css" />
  <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css" />
  <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css" />
  <!-- main css -->
  <link rel="stylesheet" href="css/style.css" />
  <style>
    .event_thumb_img {
      max-width: 100%;
      height: auto;
      display: block;
      margin: 0 auto;
      /* Optional: untuk memusatkan gambar dalam kontainer */
    }
  </style>
</head>

<body>
  <!--================ Start Header Menu Area =================-->
  <?php include "header.php"; ?>
  <!--================ End Header Menu Area =================-->


  <!--================ Start Home Banner Area =================-->
  <section class="home_banner_area">
    <div class="banner_inner">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="banner_content text-center">
              <p class="text-uppercase">
                Powering your softskill to the level max! #NaikinLevelmu
              </p>
              <h2 class="text-uppercase mt-4 mb-5">
                Business & Communication Training Institute
              </h2>
              <div>
                <a href="about-us.php" class="primary-btn2 mb-3 mb-sm-0">learn more</a>
                <a href="courses.php" class="primary-btn ml-sm-3 ml-0">see course</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ End Home Banner Area =================-->


  <!--================ Start Popular Courses Area =================-->
  <?php include "courses-area.php"; ?>
  <!--================ End Popular Courses Area =================-->


  <!--================ Start Events Area =================-->
  <?php include "events.php"; ?>
  <!--================ End Events Area =================-->


  <!--================ Start Testimonial Area =================-->
  <?php include "testimoni.php"; ?>
  <!--================ End Testimonial Area =================-->


  <!--================ Start footer Area  =================-->
  <?php include "footer.php"; ?>
  <!--================ End footer Area  =================-->

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="js/jquery-3.2.1.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
  <script src="vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="js/owl-carousel-thumb.min.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/mail-script.js"></script>
  <!--gmaps Js-->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
  <script src="js/gmaps.min.js"></script>
  <script src="js/theme.js"></script>
</body>

</html>