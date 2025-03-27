<?php
$servername = "localhost";
$username = "root"; // Tên user mặc định trong Laragon
$password = ""; // Mật khẩu mặc định là rỗng trong Laragon
$dbname = "CompanyDB";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
