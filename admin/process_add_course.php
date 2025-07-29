<?php
session_start();
require_once '../includes/db_connect.php'; // Điều chỉnh đường dẫn đến db_connect.php

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php");
    exit();
}

// Kiểm tra vai trò của người dùng
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $duration = trim($_POST['duration']);
    // Đã bỏ biến $rating

    $image_name = null;

    // Validate inputs (đã bỏ kiểm tra $rating)
    if (empty($title) || empty($description) || empty($duration)) {
        header("Location: add_course.php?message=Vui lòng điền đầy đủ tất cả các trường.&type=error");
        exit();
    }

    // Đã bỏ kiểm tra rating < 0 hoặc rating > 5

    // Xử lí ảnh
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../assets/img/"; // Thư mục lưu ảnh, điều chỉnh đường dẫn nếu cần
        $image_file_type = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = array("jpg", "jpeg", "png", "webp");

        if (!in_array($image_file_type, $allowed_extensions)) {
            header("Location: add_course.php?message=Chỉ chấp nhận file JPG, JPEG, PNG, WEBP.&type=error");
            exit();
        }

        // Tạo tên file duy nhất để tránh trùng lặp
        $image_name = uniqid('course_', true) . '.' . $image_file_type;
        $target_file = $target_dir . $image_name;

        // Di chuyển file đã upload
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            header("Location: add_course.php?message=Có lỗi xảy ra khi tải ảnh lên.&type=error");
            exit();
        }
    } else {
        header("Location: add_course.php?message=Vui lòng chọn một ảnh cho khóa học.&type=error");
        exit();
    }

    // Insert course into database (đã bỏ cột rating)
    $stmt = $conn->prepare("INSERT INTO courses (title, description, image, duration) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        // Đã bỏ tham số $rating
        $stmt->bind_param("ssss", $title, $description, $image_name, $duration);

        if ($stmt->execute()) {
            header("Location: add_course.php?message=Thêm khóa học thành công!&type=success");
            exit();
        } else {
            // Xóa ảnh đã tải lên nếu việc chèn vào DB thất bại
            if ($image_name && file_exists($target_file)) {
                unlink($target_file);
            }
            header("Location: add_course.php?message=Lỗi khi thêm khóa học vào cơ sở dữ liệu: " . $stmt->error . "&type=error");
            exit();
        }
        $stmt->close();
    } else {
        header("Location: add_course.php?message=Lỗi chuẩn bị truy vấn: " . $conn->error . "&type=error");
        exit();
    }

    $conn->close();
} else {
    // Nếu truy cập trực tiếp bằng GET, chuyển hướng về trang thêm khóa học
    header("Location: add_course.php");
    exit();
}
?>