<?php
session_start();
require_once '../includes/db_connect.php';

// Kiểm tra xem người dùng đã đăng nhập chưa và có vai trò admin không
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$course = null;
$message = '';
$message_type = '';

// Lấy ID khóa học từ URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $course_id = (int)$_GET['id'];

    if ($conn) {

        $stmt = $conn->prepare("SELECT id, title, description, image, duration FROM courses WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $course_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $course = $result->fetch_assoc();
            } else {
                $message = "Không tìm thấy khóa học này.";
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
} else {
    $message = "ID khóa học không hợp lệ hoặc không được cung cấp.";
    $message_type = "error";
}

// Xử lý thông báo từ quá trình cập nhật
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    $message_type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : 'error';
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Khóa Học - <?php echo $course ? htmlspecialchars($course['title']) : 'Không tìm thấy'; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        
        .edit-course-container {
            background-color: var(--white);
            padding: 40px;
            border-radius: 10px;
            box-shadow: var(--shadow-medium);
            max-width: 800px;
            margin: 50px auto;
            text-align: left;
        }

        .edit-course-container h2 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2em;
            text-align: center;
        }

        .edit-course-container .form-group {
            margin-bottom: 20px;
        }

        .edit-course-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-gray);
        }

        .edit-course-container input[type="text"],
        .edit-course-container input[type="number"],
        .edit-course-container textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            font-size: 1em;
            color: var(--text-color);
            transition: border-color 0.3s ease;
            box-sizing: border-box; /* Đảm bảo padding không làm tăng chiều rộng */
        }

        .edit-course-container input[type="file"] {
            width: 100%;
            padding: 12px 0; /* Padding riêng cho input file */
            border: 1px solid var(--medium-gray); /* Thêm border cho input file */
            border-radius: 5px;
            font-size: 1em;
            color: var(--text-color);
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .edit-course-container input[type="text"]:focus,
        .edit-course-container input[type="number"]:focus,
        .edit-course-container textarea:focus,
        .edit-course-container input[type="file"]:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 102, 0, 0.2);
        }

        .edit-course-container textarea {
            resize: vertical;
            min-height: 120px;
        }

        .edit-course-container button[type="submit"] {
            display: block;
            width: auto;
            margin: 30px auto 0;
            padding: 12px 30px;
            background-color: var(--primary-color);
            border: none;
            color: var(--white);
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .edit-course-container button[type="submit"]:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .message {
            padding: 10px 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: 500;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .current-image {
            margin-top: 10px;
            margin-bottom: 20px;
            text-align: center;
        }

        .current-image img {
            max-width: 200px;
            height: auto;
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            box-shadow: var(--shadow-light);
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: var(--medium-gray);
            color: var(--text-color);
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: var(--dark-gray);
            color: var(--white);
        }
    </style>
</head>
<body>
    <div id="wrapper">

        <div class="edit-course-container">
            <h2>Sửa Khóa Học</h2>
            <?php if ($message): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($course): ?>
                <form action="process_edit_course.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
                    <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($course['image']); ?>">

                    <div class="form-group">
                        <label for="title">Tiêu đề khóa học:</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Mô tả:</label>
                        <textarea id="description" name="description" required><?php echo htmlspecialchars($course['description']); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Ảnh khóa học hiện tại:</label>
                        <div class="current-image">
                            <img src="../assets/img/<?php echo htmlspecialchars($course['image']); ?>" alt="Ảnh hiện tại">
                        </div>
                        <label for="image">Thay đổi ảnh khóa học (Chỉ chấp nhận JPG, PNG, WebP):</label>
                        <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png, .webp">
                        <small>Để trống nếu bạn không muốn thay đổi ảnh.</small>
                    </div>

                    <div class="form-group">
                        <label for="duration">Thời lượng (ví dụ: 60 giờ):</label>
                        <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($course['duration']); ?>" placeholder="e.g., 60 giờ" required>
                    </div>

                    <button type="submit">Cập Nhật Khóa Học</button>
                </form>
            <?php else: ?>
                <p style="text-align: center; font-size: 1.1em; color: var(--dark-gray); margin-top: 30px;">
                    Không thể tải thông tin khóa học để chỉnh sửa. Vui lòng thử lại.
                </p>
            <?php endif; ?>
            <div style="text-align: center;">
                <a href="manage_courses.php" class="back-button"><i class="fas fa-arrow-left"></i> Quay lại tất cả khóa học</a>
            </div>
        </div>
    </div>
</body>
</html>