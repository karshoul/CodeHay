<?php
session_start();
require_once 'includes/db_connect.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$course = null;
$message = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $course_id = (int)$_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $course = $result->fetch_assoc();
        } else {
            $message = "Không tìm thấy khóa học này.";
        }
        $stmt->close();
    } else {
        $message = "Lỗi truy vấn cơ sở dữ liệu.";
    }
} else {
    $message = "ID khóa học không hợp lệ hoặc không được cung cấp.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $course ? htmlspecialchars($course['title']) : 'Chi tiết khóa học'; ?> | CODE HAY</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .course-detail-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow-medium);
        }
        .course-detail-container h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .course-detail-content {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .course-detail-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: var(--shadow-light);
        }
        .course-info-block h3 {
            color: var(--secondary-color);
            font-size: 1.8em;
            margin-bottom: 15px;
        }
        .course-meta-detail {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            margin-top: 15px;
            font-size: 1.1em;
            color: var(--dark-gray);
        }
        .course-meta-detail span {
            display: flex;
            align-items: center;
        }
        .course-meta-detail i {
            margin-right: 8px;
            color: var(--primary-color);
        }
        .course-description p {
            line-height: 1.8;
            color: var(--text-color);
            margin-bottom: 20px;
            white-space: pre-wrap; /* Giữ định dạng xuống dòng từ textarea */
        }
        .back-button {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            background-color: var(--primary-color);
            color: var(--white);
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: var(--secondary-color);
        }
        .no-course-message {
            text-align: center;
            font-size: 1.5em;
            color: var(--dark-gray);
            padding: 50px 0;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .course-detail-content {
                flex-direction: row; /* Chuyển sang bố cục 2 cột trên màn hình lớn */
                align-items: flex-start;
            }
            .course-detail-content img {
                flex: 1; /* Ảnh chiếm 1 phần */
                max-width: 45%; /* Chiều rộng ảnh tối đa */
            }
            .course-info-block {
                flex: 1.5; /* Khối thông tin chiếm nhiều hơn */
            }
        }
        @media (max-width: 768px) {
            .course-detail-container {
                margin: 30px 5%;
                padding: 30px;
            }
            .course-detail-container h2 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>
    <div id="wrapper">

        <div class="course-detail-container">
            <?php if ($course): ?>
                <h2><?php echo htmlspecialchars($course['title']); ?></h2>
                <div class="course-detail-content">
                    <img src="assets/img/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    <div class="course-info-block">
                        <div class="course-meta-detail">
                            <span><i class="fas fa-clock"></i> Thời lượng: <?php echo htmlspecialchars($course['duration']); ?> giờ</span>
                            <span><i class="fas fa-calendar-alt"></i> Cập nhật: <?php echo date("d/m/Y", strtotime($course['created_at'])); ?></span>
                        </div>
                        <h3>Mô tả khóa học:</h3>
                        <div class="course-description">
                            <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                        </div>
                        <a href="#" class="btn-primary">Đăng ký ngay</a>
                    </div>
                </div>
                <div style="text-align: center;">
                    <a href="all-course.php" class="back-button"><i class="fas fa-arrow-left"></i> Quay lại tất cả khóa học</a>
                </div>
            <?php else: ?>
                <p class="no-course-message"><?php echo $message; ?></p>
                <div style="text-align: center;">
                    <a href="all-course.php" class="back-button"><i class="fas fa-arrow-left"></i> Quay lại tất cả khóa học</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>