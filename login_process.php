<?php
session_start(); // Bắt đầu session để lưu trạng thái đăng nhập
include 'db_connect.php'; // Bao gồm file kết nối cơ sở dữ liệu

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = $_POST['username'];
    $password = $_POST['password'];

    // Bảo vệ khỏi SQL Injection
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Kiểm tra mật khẩu đã hash
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công, lưu thông tin vào session
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Chuyển hướng về trang chủ hoặc trang dashboard
            header("Location: index.php"); // Hoặc dashboard.php nếu có
            exit();
        } else {
            // Mật khẩu không đúng
            header("Location: login.php?error=Tên đăng nhập hoặc mật khẩu không đúng.");
            exit();
        }
    } else {
        // Người dùng không tồn tại
        header("Location: login.php?error=Tên đăng nhập hoặc mật khẩu không đúng.");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Nếu truy cập trực tiếp file này mà không qua form POST
    header("Location: login.php");
    exit();
}
?>