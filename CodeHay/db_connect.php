<?php
$servername = "localhost"; // Tên máy chủ MySQL, thường là localhost
$username = "root";      // Tên người dùng MySQL của bạn (mặc định là root)
$password = "";          // Mật khẩu MySQL của bạn (mặc định là rỗng)
$dbname = "codehay_db";   // Tên cơ sở dữ liệu bạn đã tạo ở Bước 1

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Thiết lập mã hóa ký tự UTF-8 cho kết nối
$conn->set_charset("utf8mb4");
?>