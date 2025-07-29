<?php
session_start();
require_once 'includes/db_connect.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$limit = 6; // Đổi thành 6 bài viết mỗi trang để phù hợp với bố cục lưới 3 cột x 2 hàng
$offset = ($page - 1) * $limit;

$totalResult = $conn->query("SELECT COUNT(*) AS total FROM blogs");
$totalRow = $totalResult->fetch_assoc();
$totalBlogs = $totalRow['total'];

$sql = "SELECT * FROM blogs ORDER BY date_posted DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $limit, $offset);
$stmt->execute();
$result = $stmt->get_result();

$totalPages = ceil($totalBlogs / $limit);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog Code Hay</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" /> 
    <link rel="stylesheet" href="assets/css/all-blogs.css" />
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
                <div class="item"><a href="all-blog.php">Blog</a></div>
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
        <div id="all-blogs-content">
            <h2 class="section-title">Bài viết nổi bật</h2>
            <div class="blog-grid">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($blog = $result->fetch_assoc()): ?>
                        <div class="blog-card">
                            <img src="assets/img/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                            <div class="blog-info">
                                <h3><?php echo htmlspecialchars($blog['title']); ?></h3>
                                <div class="blog-meta">
                                    <span><i class="fas fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($blog['date_posted'])); ?></span>
                                    <span><i class="fas fa-tag"></i> <?php echo htmlspecialchars($blog['category']); ?></span>
                                </div>
                                <p><?php echo nl2br(htmlspecialchars(substr($blog['content'], 0, 150))) . '...'; ?></p>
                                <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-blogs-found">Không tìm thấy bài viết nào.</p>
                <?php endif; ?>
            </div>

            <div class="pagination">
                <a href="index.php#blog-section" class="back-button">
                    <i class="fas fa-arrow-left"></i> Quay lại 
                </a>

                <?php if ($page > 1): ?>
                    <a href="all-blog.php?page=<?php echo $page - 1; ?>" class="pagination-arrow">&laquo; Trang trước</a>
                <?php endif; ?>
                
                <?php /*
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="all-blog.php?page=<?php echo $i; ?>" <?php if ($i == $page) echo 'class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
                */ ?>
                
                <?php if ($page < $totalPages): ?>
                    <a href="all-blog.php?page=<?php echo $page + 1; ?>" class="pagination-arrow">Trang sau &raquo;</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>