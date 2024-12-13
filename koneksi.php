<?php
$conn = mysqli_connect("localhost", "root", "", "pelatihan_bcti");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
