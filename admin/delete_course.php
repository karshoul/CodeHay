<?php
session_start();
require_once '../includes/db_connect.php';

// Kiểm tra đăng nhập và vai trò admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $course_id = (int)$_GET['id'];

    // Chuẩn bị câu lệnh SQL để xóa
    $sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $course_id);
        if ($stmt->execute()) {
            // Xóa thành công, chuyển hướng về trang quản lý với thông báo
            header("Location: manage_courses.php?status=deleted");
            exit();
        } else {
            // Lỗi khi thực thi
            error_log("Error deleting course: " . $stmt->error);
            header("Location: manage_courses.php?status=error");
            exit();
        }
        $stmt->close();
    } else {
        // Lỗi chuẩn bị câu lệnh SQL
        error_log("Error preparing statement: " . $conn->error);
        header("Location: manage_courses.php?status=error");
        exit();
    }
} else {
    // Không có ID được cung cấp
    header("Location: manage_courses.php?status=error");
    exit();
}

$conn->close();
?>