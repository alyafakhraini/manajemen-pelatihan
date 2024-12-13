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
  <title>About Us</title>
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


  <!--================Home Banner Area =================-->
  <section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="banner_content text-center">
              <h2>About Us</h2>
              <div class="page_link">
                <a href="index.php">Home</a>
                <a href="about-us.php">About Us</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================End Home Banner Area =================-->

  <!--================ Start About Area =================-->
  <section class="about_area section_gap">
    <div class="container">
      <div class="row h_blog_item">
        <div class="col-lg-6">
          <div class="h_blog_img">
            <img class="img-fluid" src="img/about2.jpg" alt="" />
          </div>
        </div>
        <div class="col-lg-6">
          <div class="h_blog_text">
            <div class="h_blog_text_inner left right">
              <h4>Who We Are?</h4>
              <p>
                Business & Communication Training Institute (BCTI) adalah lembaga pengembangan diri dan pengoptimalan
                potensi sumberdaya manusia yang bergerak dalam bidang pelatihan soft skills.
              </p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--================ End About Area =================-->

  <!--================ Start Feature Area =================-->
  <section class="feature_area section_gap_top title-bg">
    <div class="container">

      <div class="row justify-content-center">
        <div class="col-lg-3 col-md-6">
          <div class="single_feature text-center">
            <img class=" img-fluid" src="img/about us/people.png" alt="" style="max-width: 100px;" />
            <div class=" icon"><br><span>2144</span>
            </div>
            <div class="desc">
              <h4 class="mt-3 mb-2">Jumlah peserta yang pernah ikut event training BCTI</h4>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single_feature text-center">
            <img class=" img-fluid" src="img/about us/schedule.png" alt="" style="max-width: 100px;" />
            <div class="icon"><br><span>40</span></div>
            <div class="desc">
              <h4 class="mt-3 mb-2">Jumlah Event Training BCTI</h4>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single_feature text-center">
            <img class=" img-fluid" src="img/about us/growth.png" alt="" style="max-width: 100px;" />
            <div class="icon"><br><span>76.2%</span></div>
            <div class="desc">
              <h4 class="mt-3 mb-2">Presentase kenaikan rata-rata pengetahuan peserta</h4>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="single_feature text-center">
            <img class="img-fluid" src="img/about us/rating.png" alt="" style="max-width: 100px;" />
            <div class="icon"><br><span>97%</span></div>
            <div class="desc">
              <h4 class="mt-3 mb-2">Presentasi kepuasan</h4>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!--================ End Feature Area =================-->

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