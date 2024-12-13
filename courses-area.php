<?php
include "koneksi.php";

// Query to get the data from tbl_pelatihan
$query_pelatihan = "SELECT kategori_program FROM tbl_pelatihan";
$result_pelatihan = mysqli_query($conn, $query_pelatihan);

// Initialize an array to store the data
$programs = [];

while ($row_pelatihan = mysqli_fetch_assoc($result_pelatihan)) {
    $programs[] = $row_pelatihan['kategori_program'];
}
?>

<section class="feature_area section_gap_top">
    <div class="popular_courses">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="main_title">
                        <h2 class="mb-3">Our Program</h2>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="owl-carousel active_course">
                        <!-- single course -->
                        <div class="single_course">
                            <div class="course_head">
                                <img class="img-fluid" src="img/courses/levelup.jpg" alt="" />
                            </div>
                            <div class="course_content">
                                <span class="tag mb-4 d-inline-block">1 Session</span>
                                <h4 class="mb-3">
                                    <a href="courses.php?kategori_program=level up">Level Up</a>
                                </h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Lacus sed turpis tincidunt id. Orci phasellus egestas tellus rutrum.
                                </p>
                                <div class="course_meta d-flex justify-content-lg-between align-items-lg-center flex-lg-row flex-column mt-4">
                                </div>
                            </div>
                        </div>

                        <div class="single_course">
                            <div class="course_head">
                                <img class="img-fluid" src="img/courses/ap.jpg" alt="" />
                            </div>
                            <div class="course_content">
                                <span class="tag mb-4 d-inline-block">Weekly Sessions (1-2 months)</span>
                                <h4 class="mb-3">
                                    <a href="courses.php?kategori_program=ap">Acceleration Program</a>
                                </h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Lacus sed turpis tincidunt id. Orci phasellus egestas tellus rutrum.
                                </p>
                                <div class="course_meta d-flex justify-content-lg-between align-items-lg-center flex-lg-row flex-column mt-4">
                                </div>
                            </div>
                        </div>

                        <div class="single_course">
                            <div class="course_head">
                                <img class="img-fluid" src="img/courses/psc.jpg" alt="" />
                            </div>
                            <div class="course_content">
                                <span class="tag mb-4 d-inline-block">1 Session</span>
                                <h4 class="mb-3">
                                    <a href="courses.php?kategori_program=psc">Professional Skill Certificate</a>
                                </h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Lacus sed turpis tincidunt id. Orci phasellus egestas tellus rutrum.
                                </p>
                                <div class="course_meta d-flex justify-content-lg-between align-items-lg-center flex-lg-row flex-column mt-4">
                                </div>
                            </div>
                        </div>

                        <div class="single_course">
                            <div class="course_head">
                                <img class="img-fluid" src="img/courses/bootcamp.jpg" alt="" />
                            </div>
                            <div class="course_content">
                                <span class="tag mb-4 d-inline-block">Bootcamp</span>
                                <h4 class="mb-3">
                                    <a href="courses.php?kategori_program=bootcamp">Bootcamp</a>
                                </h4>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                    Lacus sed turpis tincidunt id. Orci phasellus egestas tellus rutrum.
                                </p>
                                <div class="course_meta d-flex justify-content-lg-between align-items-lg-center flex-lg-row flex-column mt-4">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>