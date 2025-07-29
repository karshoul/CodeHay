<?php

session_start();
require_once 'includes/db_connect.php'; // Kết nối cơ sở dữ liệu

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 9; // Giới hạn 9 khóa học mỗi trang (ví dụ: 3 cột x 3 hàng)
$offset = ($page - 1) * $limit;

$totalCourses = 0; // Khởi tạo tổng số khóa học
$result = null; // Khởi tạo biến kết quả truy vấn

if ($conn) { // Kiểm tra xem kết nối cơ sở dữ liệu có thành công không
    // Lấy tổng số khóa học
    $totalResult = $conn->query("SELECT COUNT(*) AS total FROM courses");
    if ($totalResult) {
        $totalRow = $totalResult->fetch_assoc();
        $totalCourses = $totalRow['total'];
    } else {
        // Ghi log lỗi nếu truy vấn tổng số khóa học thất bại
        error_log("Error fetching total courses: " . $conn->error);
        // Có thể hiển thị thông báo lỗi cho người dùng nếu muốn
    }

    // Truy vấn lấy khóa học cho trang hiện tại
    // Đã bỏ cột 'rating' khỏi truy vấn
    $sql = "SELECT id, title, description, image, duration FROM courses ORDER BY created_at DESC LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // Ghi log lỗi nếu prepare statement thất bại
        error_log("Error preparing course query: " . $conn->error);
        // Có thể hiển thị thông báo lỗi cho người dùng nếu muốn
    }
} else {
    // Ghi log lỗi nếu kết nối cơ sở dữ liệu thất bại
    error_log("Database connection failed in all-courses.php");
    // Có thể hiển thị thông báo lỗi cho người dùng nếu muốn
}

$totalPages = ceil($totalCourses / $limit);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tất Cả Các Khóa Học | CODE HAY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/all-course.css" />
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <a href="index.php" class="logo">
                <span>CODE HAY</span>
            </a>
            <div id="menu">
                <div class="item"><a href="index.php">Trang chủ</a></div>
                <div class="item"><a href="all-course.php">Khóa học</a></div>
                <div class="item"><a href="all-blog-page1.php">Blog</a></div>
                <div class="item"><a href="contact.php">Liên hệ</a></div>
            </div>
            <div class="actions">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <div class="item dropdown">
                        <a href="#" class="dropbtn">
                            <i class="fas fa-user-circle"></i>
                            <?php echo htmlspecialchars($_SESSION['username']); ?>
                            <i class="fas fa-caret-down"></i>
                        </a>
                        <div class="dropdown-content">
                            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="item">
                        <a href="login.php" class="login-btn">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <script>
            // JavaScript for dropdown functionality
            document.addEventListener('DOMContentLoaded', function() {
                const dropdown = document.querySelector('.dropdown');
                if (dropdown) {
                    const dropbtn = dropdown.querySelector('.dropbtn');
                    const dropdownContent = dropdown.querySelector('.dropdown-content');

                    dropbtn.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent default link behavior
                        dropdownContent.classList.toggle('show');
                    });

                    // Close the dropdown if the user clicks outside of it
                    window.addEventListener('click', function(event) {
                        if (!event.target.matches('.dropbtn') && !event.target.closest('.dropdown-content')) {
                            if (dropdownContent.classList.contains('show')) {
                                dropdownContent.classList.remove('show');
                            }
                        }
                    });
                }
            });
        </script>
        <div id="all-courses-content">
            <h2 class="section-title">Tất Cả Các Khóa Học</h2>
            <div class="course-grid">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($course = $result->fetch_assoc()): ?>
                        <div class='course-card'>
                            <img src='assets/img/<?php echo htmlspecialchars($course['image']); ?>' alt='<?php echo htmlspecialchars($course['title']); ?>'>
                            <div class='course-info'>
                                <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                                <p><?php echo htmlspecialchars(mb_strimwidth($course['description'], 0, 100, "...")); ?></p>
                                <div class='course-meta'>
                                    <span><i class='fas fa-clock'></i> <?php echo htmlspecialchars($course['duration']); ?> giờ</span>
                                    </div>
                                <a href="course_detail.php?id=<?php echo $course['id']; ?>" class="btn-primary">Tìm hiểu thêm</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-courses-found">Không tìm thấy khóa học nào.</p>
                <?php endif; ?>
            </div>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="all-courses.php?page=<?php echo $page - 1; ?>" class="pagination-arrow">&laquo; Trang trước</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <?php if ($i == 1): // Check if it's the first page link ?>
                        <a href="index.php#courses-section" <?php if ($i == $page) echo 'class="active"'; ?>> Quay lại</a>
                    <?php else: ?>
                        <a href="all-courses.php?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="all-courses.php?page=<?php echo $page + 1; ?>" class="pagination-arrow">Trang sau &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
// Đóng kết nối cơ sở dữ liệu ở cuối cùng của file
if ($conn) {
    $conn->close();
}
?>