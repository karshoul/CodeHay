<?php
session_start();
require_once '../includes/db_connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa và có vai trò admin không
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Kiểm tra xem request có phải là POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    // $rating = $_POST['rating'] ?? null; // Đã bỏ trường rating
    $old_image = $_POST['old_image'] ?? ''; // Lấy tên ảnh cũ

    $new_image_name = $old_image; // Mặc định giữ ảnh cũ

    $message = '';
    $message_type = 'error';

    // Validate inputs
    if (empty($course_id) || !is_numeric($course_id)) {
        $message = "ID khóa học không hợp lệ.";
    } elseif (empty($title) || empty($description) || empty($duration)) { // Đã bỏ validation cho rating
        $message = "Vui lòng điền đầy đủ và đúng định dạng các thông tin cần thiết.";
    } else {
        // Xử lý tải lên ảnh mới (nếu có)
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $target_dir = "assets/img/"; // Đảm bảo đường dẫn này đúng với cấu trúc thư mục của bạn
            $file_extension = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
            $allowed_extensions = array("jpg", "jpeg", "png", "webp");

            if (!in_array($file_extension, $allowed_extensions)) {
                $message = "Chỉ cho phép các định dạng JPG, JPEG, PNG, WEBP.";
            } elseif ($_FILES["image"]["size"] > 5000000) { // 5MB limit
                $message = "Kích thước ảnh quá lớn, tối đa 5MB.";
            } else {
                // Tạo tên file duy nhất để tránh trùng lặp
                $new_image_name = uniqid() . "." . $file_extension;
                $target_file = $target_dir . $new_image_name;

                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Nếu tải ảnh mới thành công và có ảnh cũ khác ảnh mặc định, xóa ảnh cũ
                    if (!empty($old_image) && file_exists($target_dir . $old_image) && $old_image !== 'default_course.jpg') { // Thay 'default_course.jpg' bằng tên ảnh mặc định của bạn nếu có
                        unlink($target_dir . $old_image);
                    }
                    $message = "Ảnh đã được tải lên thành công.";
                    $message_type = "success";
                } else {
                    $message = "Có lỗi xảy ra khi tải ảnh lên.";
                }
            }
        }
        // Nếu không có lỗi nào từ việc tải ảnh hoặc không có ảnh mới, tiến hành cập nhật DB
        if (empty($message) || $message_type == 'success') { // Chỉ cập nhật nếu không có lỗi hoặc lỗi chỉ liên quan đến ảnh mà ảnh không bắt buộc
            if ($conn) {
                // Đã bỏ cột 'rating' khỏi câu lệnh UPDATE
                $sql = "UPDATE courses SET title = ?, description = ?, image = ?, duration = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);

                if ($stmt) {
                    // Cập nhật bind_param để khớp với số lượng và kiểu dữ liệu của các trường đã thay đổi
                    $stmt->bind_param("sssii", $title, $description, $new_image_name, $duration, $course_id);

                    if ($stmt->execute()) {
                        $message = "Khóa học đã được cập nhật thành công!";
                        $message_type = "success";
                    } else {
                        $message = "Lỗi khi cập nhật khóa học vào cơ sở dữ liệu: " . $stmt->error;
                        $message_type = "error";
                    }
                    $stmt->close();
                } else {
                    $message = "Lỗi chuẩn bị truy vấn: " . $conn->error;
                    $message_type = "error";
                }
            } else {
                $message = "Lỗi kết nối cơ sở dữ liệu.";
                $message_type = "error";
            }
        }
    }

    $conn->close();

    // Redirect back to edit_course.php with message
    header("Location: edit_course.php?id=" . $course_id . "&message=" . urlencode($message) . "&type=" . urlencode($message_type));
    exit();

} else {
    // Nếu không phải là POST request, chuyển hướng về trang chủ hoặc trang quản lý
    header("Location: index.php");
    exit();
}
?>