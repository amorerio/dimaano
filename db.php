<?php
$conn = mysqli_connect("localhost", "root", "", "payroll");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>