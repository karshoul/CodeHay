<?php
session_start(); // Bắt đầu session
require_once 'includes/db_connect.php'; // Bao gồm file kết nối cơ sở dữ liệu

// Truy vấn để lấy các khóa học nổi bật từ cơ sở dữ liệu
// Giới hạn 4 khóa học để hiển thị trên trang chủ
// Đã bỏ cột 'rating' khỏi truy vấn
$sql_courses = "SELECT id, title, description, image, duration FROM courses ORDER BY created_at DESC LIMIT 4";
$result_courses = $conn->query($sql_courses);

// Truy vấn để lấy các bài viết blog mới nhất (3 bài)
$sql_blogs = "SELECT id, title, content, image, date_posted, category FROM blogs ORDER BY date_posted DESC LIMIT 3";
$result_blogs = $conn->query($sql_blogs);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CODE HAY</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/header.css"> 
</head>

<body>
    <div id="wrapper">
    <header>
    <div id="header">
        <a href="index.php" class="logo">
            <span>CODE HAY</span>
        </a>
        <div id="menu">
            <div class="item"><a href="index.php">Trang chủ</a></div>
            <div class="item"><a href="index.php#courses-section">Khoá học</a></div>
            <div class="item"><a href="index.php#blog-section">Blog</a></div>
            <div class="item"><a href="about.php">Giới thiệu</a></div>
        </div>
        <div class="actions">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <div class="item dropdown">
                    <a href="#" class="dropbtn" id="userDropdownBtn"> <i class="fas fa-user"></i>
                        <span>Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        <i class="fas fa-caret-down"></i>
                    </a>
                    <div class="dropdown-content" id="userDropdownContent"> 
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                            <?php endif; ?>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="item">
                    <a href="login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </header>
    <div id="banner">
        <div class="box-left">
            <h2>
                <span>LẬP TRÌNH KHÔNG KHÓ VÌ CÓ CODE HAY</span>
            </h2>
            <p>
                Cung cấp các khóa học lập trình từ cơ bản đến nâng cao. Giúp bạn phát triển tư duy, kỹ năng và định hướng sự nghiệp trong ngành công nghệ.
            </p>
            <a href="all-course.php">
            <button>Xem khóa học</button>
            </a>
        </div>
        <div class="box-right">
            <img src="assets/img/img_banner.png" alt="">
        </div>
    </div>

    <div id="courses-section" class="section">
        <h2 class="section-title">Khóa Học Nổi Bật</h2>
        <div class="course-list">
            <?php if ($result_courses && $result_courses->num_rows > 0): ?>
                <?php while ($course = $result_courses->fetch_assoc()): ?>
                    <div class="course-card">
                        <img src="assets/img/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                        <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars(mb_strimwidth($course['description'], 0, 100, "..."))); ?></p>
                        <div class="course-meta">
                            <span><i class="fas fa-clock"></i> <?php echo htmlspecialchars($course['duration']); ?> giờ</span>
                            </div>
                        <a href="course_detail.php?id=<?php echo $course['id']; ?>" class="btn-primary">Tìm hiểu thêm</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Không có khóa học nổi bật nào.</p>
            <?php endif; ?>
        </div>
        <a href="all-course.php">
            <button class="btn-secondary">Xem tất cả khóa học</button>
        </a>
    </div>

    <div id="blog-section" class="section blog-section-bg">
        <h2 class="section-title">Bài Viết Mới Nhất</h2>
        <div class="blog-posts-container">
            <?php if ($result_blogs && $result_blogs->num_rows > 0): ?>
                <?php while ($blog = $result_blogs->fetch_assoc()): ?>
                    <div class="blog-post-card">
                        <img src="assets/img/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>">
                        <div class="post-content">
                            <h3><?php echo htmlspecialchars($blog['title']); ?></h3>
                            <p class="post-meta">
                                <i class="fas fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($blog['date_posted'])); ?> | 
                                <i class="fas fa-tag"></i> <?php echo htmlspecialchars($blog['category']); ?>
                            </p>
                            <p><?php echo nl2br(htmlspecialchars(mb_strimwidth($blog['content'], 0, 100, "..."))); ?></p>
                            <a href="blog_detail.php?id=<?php echo $blog['id']; ?>" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Không có bài viết nào để hiển thị.</p>
            <?php endif; ?>
        </div>
        <a href="all-blog.php">
            <button class="btn-secondary">Xem tất cả bài viết</button>
        </a>
    </div>

   
    <div id="footer">
        <div class="footer-content">
            <div class="footer-column about-us">
                <h3>Về Code Hay</h3>
                <p>Chúng tôi cung cấp các khóa học lập trình chất lượng, giúp bạn dễ dàng tiếp cận và làm chủ thế giới công nghệ.</p>
                <div class="social-media">
                    <h3>Theo dõi chúng tôi</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-column quick-links">
                <h3>Liên kết nhanh</h3>
                <ul>
                    <li><a href="index.php#banner">Trang chủ</a></li>
                    <li><a href="index.php#courses-section">Khoá học</a></li>
                    <li><a href="index.php#blog-section">Blog</a></li>
                    <li><a href="index.php#contact-section">Liên hệ</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                </ul>
            </div>
            <div class="footer-column contact-info-footer">
                <h3>Thông tin liên hệ</h3>
                <p><i class="fas fa-map-marker-alt"></i> 132 Nguyễn Đệ, Bình Thuỷ, TP Cần Thơ</p>
                <p><i class="fas fa-phone"></i> +84 798 059 074</p>
                <p><i class="fas fa-envelope"></i> hotro@codehay.vn</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <?php echo date("Y"); ?> Code Hay. All rights reserved.</p>
        </div>
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

<?php $conn->close(); ?>