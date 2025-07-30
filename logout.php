<?php
session_start(); // Bắt đầu session

// Hủy tất cả các biến session
$_SESSION = array(); //

// Xóa cookie session nếu có
if (ini_get("session.use_cookies")) { 
    $params = session_get_cookie_params(); 
    setcookie(session_name(), '', time() - 42000, 
        $params["path"], $params["domain"], 
        $params["secure"], $params["httponly"] 
    ); 
} 

// Hủy session
session_destroy(); 

// Chuyển hướng về trang chủ
header("Location: index.php"); // Hoặc login.php nếu bạn muốn chuyển về trang đăng nhập
exit(); 
?>