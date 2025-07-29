<?php
ob_start();
session_start();
require_once 'includes/db_connect.php'; // Kết nối CSDL
header('Content-Type: application/json'); // Trả về JSON

$response = ["success" => false, "message" => "Lỗi không xác định"];

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
        if ($password === $admin['password']) { // Hoặc password_verify nếu có mã hóa
            $_SESSION['loggedin'] = true;
            $_SESSION['user_id'] = $admin['id'];
            $_SESSION['username'] = $admin['username'];
            $_SESSION['role'] = 'admin';

            $response = ["success" => true, "redirect" => "admin/admin_dashboard.php"];
            echo json_encode($response);
            exit();
        }
    }

    // ==== 2. Kiểm tra user ====
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

            $response = ["success" => true, "redirect" => "index.php"];
            echo json_encode($response);
            exit();
        }
    }

    // Sai tài khoản hoặc mật khẩu
    $response = ["success" => false, "message" => "Tên đăng nhập hoặc mật khẩu không đúng"];
    echo json_encode($response);
    exit();
} else {
    $response = ["success" => false, "message" => "Phương thức không hợp lệ"];
    echo json_encode($response);
    exit();
}
