<?php
ob_start();
session_start();
require_once 'includes/db_connect.php'; // Kết nối CSDL

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // ==== 1. Kiểm tra trong bảng admin trước ====
    $sql_admin = "SELECT id, username, password FROM admin WHERE username = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $username);
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    if ($result_admin && $result_admin->num_rows === 1) {
        $admin = $result_admin->fetch_assoc();
        if ($password === $admin['password']) { // Nếu bạn lưu password thuần
        // Hoặc dùng password_verify($password, $admin['password']) nếu password đã mã hóa
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['role'] = 'admin';

            echo "Login thành công. Đang chuyển trang...";
            header("Refresh: 2; URL=admin/admin_dashboard.php");
            exit();
        }
    }

    // ==== 2. Nếu không phải admin, kiểm tra trong bảng users ====
    $sql_user = "SELECT id, username, password FROM users WHERE username = ? OR email = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("ss", $username, $username);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user && $result_user->num_rows === 1) {
        $user = $result_user->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'user';

            header("Location: index.php");
            exit();
        }
    }

    // ==== 3. Nếu không đúng tài khoản nào ====
    $_SESSION['login_error'] = "Tên đăng nhập hoặc mật khẩu không đúng.";
    header("Location: login.php");
    exit();
} else {
    header("Location: login.php");
    exit();
}
