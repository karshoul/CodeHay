<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php"); // Chuyển hướng về trang đăng nhập nếu chưa đăng nhập
    exit();
}

// Kiểm tra vai trò của người dùng
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Nếu không phải admin, chuyển hướng về trang chủ hoặc hiển thị thông báo lỗi
    header("Location: ../index.php"); // Chuyển hướng về trang chủ
    exit();
}

$message = '';
$message_type = '';

if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
    $message_type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : 'error';
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Khóa Học Mới</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/header.css">
    <style>
        .add-course-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow-medium);
        }
        .add-course-container h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2.2em;
        }
        .add-course-container .form-group {
            margin-bottom: 20px;
        }
        .add-course-container label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-color);
            font-weight: 500;
        }
        .add-course-container input[type="text"],
        .add-course-container input[type="number"],
        .add-course-container textarea,
        .add-course-container input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        .add-course-container input[type="text"]:focus,
        .add-course-container input[type="number"]:focus,
        .add-course-container textarea:focus,
        .add-course-container input[type="file"]:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 102, 0, 0.2);
        }
        .add-course-container textarea {
            resize: vertical;
            min-height: 120px;
        }
        .add-course-container button[type="submit"] {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }
        .add-course-container button[type="submit"]:hover {
            background-color: var(--secondary-color);
        }
        .message {
            padding: 10px;
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
        /* Responsive */
        @media (max-width: 768px) {
            .add-course-container {
                margin: 30px 5%;
                padding: 30px;
            }
            .add-course-container h2 {
                font-size: 1.8em;
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">

        <div class="add-course-container">
            <h2>Thêm Khóa Học Mới</h2>
            <?php if ($message): ?>
                <div class="message <?php echo $message_type; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            <form action="process_add_course.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Tiêu đề khóa học:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Mô tả:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Ảnh khóa học (Chỉ chấp nhận JPG, PNG, WebP):</label>
                    <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png, .webp" required>
                </div>
                <div class="form-group">
                    <label for="duration">Thời lượng (ví dụ: 60 giờ):</label>
                    <input type="text" id="duration" name="duration" placeholder="e.g., 60 giờ" required>
                </div>
                <button type="submit">Thêm Khóa Học</button>
                <a href="manage_courses.php" class="btn btn-secondary back-button-add-course" style="margin-top: 15px; display: inline-block;">Quay lại Quản lý Khóa học</a>
            </form>
        </div>
    </div>
    <script>
    // JavaScript để xử lý dropdown menu (nếu bạn có)
    document.addEventListener('DOMContentLoaded', function() {
        var userDropdownBtn = document.getElementById('userDropdownBtn');
        var userDropdownContent = document.getElementById('userDropdownContent');

        if (userDropdownBtn && userDropdownContent) {
            userDropdownBtn.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a
                userDropdownContent.classList.toggle('show');
            });

            // Đóng dropdown nếu click bên ngoài
            window.addEventListener('click', function(event) {
                if (!event.target.matches('.dropbtn') && !event.target.closest('.dropdown')) {
                    if (userDropdownContent.classList.contains('show')) {
                        userDropdownContent.classList.remove('show');
                    }
                }
            });
        }
    });
    </script>
</body>
</html>