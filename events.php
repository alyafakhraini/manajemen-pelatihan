<?php
include "koneksi.php";

// Query untuk mengambil data pelatihan
$sql_pelatihan = "SELECT * FROM tbl_pelatihan WHERE status_kegiatan = 'on going' ORDER BY tgl_pelatihan DESC";

$result_pelatihan = $conn->query($sql_pelatihan);
?>

<div class="events_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="main_title">
                    <h2 class="mb-3 text-white">Upcoming Events</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            if ($result_pelatihan->num_rows > 0) {
                // Output data dari setiap baris
                while ($row_pelatihan = $result_pelatihan->fetch_assoc()) {
                    // Format tanggal pelatihan
                    $tanggal_pelatihan = date("d", strtotime($row_pelatihan['tgl_pelatihan']));
                    $bulan_pelatihan = date("M", strtotime($row_pelatihan['tgl_pelatihan']));
            ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single_event position-relative">
                            <div class="event_thumb">
                                <img class="event_thumb_img" src="poster/<?php echo $row_pelatihan['poster']; ?>" alt="" />
                            </div>
                            <div class="event_details">
                                <div class="d-flex mb-2">
                                    <div class="date"><span><?php echo $tanggal_pelatihan; ?></span> <?php echo $bulan_pelatihan; ?></div>
                                    <div class="time-location">
                                        <p>
                                            <span class="ti-location-pin mr-2"></span><?php echo $row_pelatihan['tempat']; ?>
                                        </p>
                                    </div>
                                </div>
                                <p><strong><?php echo $row_pelatihan['nama_pelatihan']; ?></strong></p>
                                <a href="course-detail.php?id_pelatihan=<?php echo $row_pelatihan['id_pelatihan']; ?>" class="genric-btn primary-border medium">Details</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>No upcoming events found.</p>";
            }
            ?>
            <div class="col-lg-12">
                <div class="text-center pt-lg-5 pt-3">
                    <a href="courses.php" class="event-link">
                        View All Event <img src="img/next.png" alt="" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>