<?php
// Thông tin kết nối CSDL
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "codehay_db";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("❌ Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

// Thiết lập charset để đảm bảo hỗ trợ tiếng Việt và emoji
if (!$conn->set_charset("utf8mb4")) {
    die("❌ Thiết lập charset thất bại: " . $conn->error);
}

// ✅ Kết nối thành công và charset đã được thiết lập
?>
