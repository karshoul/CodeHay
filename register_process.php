<?php
session_start();
include 'includes/db_connect.php'; // Bao gồm file kết nối cơ sở dữ liệu (đã sửa đường dẫn)

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $username = $_POST['username']; 
    $email = $_POST['email']; 
    $password = $_POST['password']; 
    $confirm_password = $_POST['confirm_password']; 

    // 1. Kiểm tra mật khẩu khớp nhau - ĐẶT ĐẦU TIÊN
    if ($password !== $confirm_password) { 
        header("Location: register.php?message=Mật khẩu và xác nhận mật khẩu không khớp.&type=error"); // Đã sửa thành register.php
        exit(); 
    } 

    // 2. Hash mật khẩu - SAU KHI ĐÃ XÁC NHẬN KHỚP
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

    // 3. Kiểm tra xem tên đăng nhập hoặc email đã tồn tại chưa - TRƯỚC KHI THÊM MỚI
    $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?"); 
    $stmt_check->bind_param("ss", $username, $email); 
    $stmt_check->execute(); 
    $result_check = $stmt_check->get_result(); 

    if ($result_check->num_rows > 0) { 
        header("Location: register.php?message=Tên đăng nhập hoặc Email đã tồn tại.&type=error");
        exit(); 
    } 
    $stmt_check->close(); 

    // 4. Thêm người dùng mới vào cơ sở dữ liệu - SAU KHI TẤT CẢ CÁC KIỂM TRA ĐỀU QUA
    $stmt_insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)"); 
    $stmt_insert->bind_param("sss", $username, $email, $hashed_password); 

    if ($stmt_insert->execute()) { 
        // Chuyển hướng về trang đăng nhập với thông báo thành công
        header("Location: login.php?message=Đăng ký thành công! Vui lòng đăng nhập.&type=success"); // Đã sửa thành login.php
        exit(); 
    } else {
        // Xử lý lỗi khi không thêm được vào DB
        header("Location: register.php?message=Đã xảy ra lỗi khi đăng ký. Vui lòng thử lại.&type=error"); 
        exit(); 
    } 
    $stmt_insert->close(); 
    $conn->close(); // Đóng kết nối DB
} else {
    // Nếu không phải phương thức POST, chuyển hướng về trang đăng ký
    header("Location: register.php");
    exit();
}
?>