<?php
include "koneksi.php";

// Query untuk mengambil testimoni dari tabel tbl_evaluasi_pelatihan
$sql_evaluasi = "SELECT e.testimoni, p.nama_peserta
                 FROM tbl_evaluasi_pelatihan e
                 INNER JOIN tbl_peserta p ON e.id_peserta = p.id_peserta
                 ORDER BY RAND()";
$result_evaluasi = $conn->query($sql_evaluasi);
?>

<div class="testimonial_area section_gap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="main_title">
                    <h2 class="mb-3">Testimoni Peserta</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="testi_slider owl-carousel">
                <?php
                if ($result_evaluasi->num_rows > 0) {
                    while ($row_evaluasi = $result_evaluasi->fetch_assoc()) {
                        echo '
                        <div class="testi_item">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="testi_text">
                                        <h4>' . $row_evaluasi['nama_peserta'] . '</h4>
                                        <p>
                                            ' . $row_evaluasi['testimoni'] . '
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    }
                } else {
                    echo '<p>Tidak ada testimoni saat ini.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</div>