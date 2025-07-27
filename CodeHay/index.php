<?php
session_start(); // Bắt đầu session

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang đăng nhập
    header("Location: login.php"); // Sửa từ login.html thành login.php
    exit(); // Rất quan trọng: Dừng việc thực thi script sau khi chuyển hướng
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code hay</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <a href="#" class="logo">
                <span>Code hay</span>
            </a>
            <div id="menu">
                <div class="item"><a href="#banner">Trang chủ</a></div>
                <div class="item"><a href="#courses-section">Khoá học</a></div>
                <div class="item"><a href="#blog-section">Blog</a></div>
                <div class="item"><a href="#contact-section">Liên hệ</a></div>
            </div>
            <div class="actions">
                <div class="item">
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <a href="#" style="text-decoration: none; color: var(--primary-color); font-weight: 500;">
                            Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                        <a href="logout.php" style="margin-left: 15px;">
                            <img src="assets/logout
                            .png" alt="Logout" style="width: 22px; height: auto;">
                        </a>
                    <?php else: ?>
                        <a href="login.php" style="text-decoration: none;"> <img src="assets/user.png" alt="User" style="width: 22px; height: auto;">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div id="banner">
            <div class="box-left">
                <h2>
                    <span>LẬP TRÌNH KHÔNG KHÓ</span><br>
                    <span>VÌ CÓ CODE HAY</span>
                </h2>
                <p>
                    Học lập trình trong thời gian ngắn nhất<br>
                    nắm được cơ bản và phát triển toàn diện.<br>
                </p>
                <button>Mua ngay</button>
            </div>
            <div class="box-right">
            </div>
        </div>

        <div id="courses-section" class="section">
            <h2 class="section-title">Các Khoá Học Nổi Bật</h2>
            <div class="courses-container">
                <div class="course-card">
                    <img src="assets/course_html_css.jpg" alt="HTML CSS Course">
                    <h3>Khoá Học HTML & CSS Cơ Bản</h3>
                    <p>Xây dựng giao diện website đầu tiên của bạn với HTML và CSS.</p>
                    <div class="course-meta">
                        <span><i class="fas fa-clock"></i> 30 giờ</span>
                        <span><i class="fas fa-star"></i> 4.8</span>
                    </div>
                    <button class="btn-primary">Tìm hiểu thêm</button>
                </div>
                <div class="course-card">
                    <img src="assets/course_javascript.jpg" alt="JavaScript Course">
                    <h3>Khoá Học JavaScript Toàn Diện</h3>
                    <p>Làm chủ JavaScript, thêm tương tác và logic cho website.</p>
                    <div class="course-meta">
                        <span><i class="fas fa-clock"></i> 60 giờ</span>
                        <span><i class="fas fa-star"></i> 4.9</span>
                    </div>
                    <button class="btn-primary">Tìm hiểu thêm</button>
                </div>
                <div class="course-card">
                    <img src="assets/course_react.jpg" alt="ReactJS Course">
                    <h3>Phát Triển Web với ReactJS</h3>
                    <p>Xây dựng ứng dụng web hiện đại với thư viện ReactJS.</p>
                    <div class="course-meta">
                        <span><i class="fas fa-clock"></i> 50 giờ</span>
                        <span><i class="fas fa-star"></i> 4.7</span>
                    </div>
                    <button class="btn-primary">Tìm hiểu thêm</button>
                </div>
                <div class="course-card">
                    <img src="assets/course_python.jpg" alt="Python Course">
                    <h3>Lập Trình Python Từ A-Z</h3>
                    <p>Học Python để phát triển web, AI và phân tích dữ liệu.</p>
                    <div class="course-meta">
                        <span><i class="fas fa-clock"></i> 45 giờ</span>
                        <span><i class="fas fa-star"></i> 4.9</span>
                    </div>
                    <button class="btn-primary">Tìm hiểu thêm</button>
                </div>
            </div>
            <button class="btn-secondary">Xem tất cả khoá học</button>
        </div>

        <div id="blog-section" class="section">
            <h2 class="section-title">Bài Viết Mới Nhất</h2>
            <div class="blog-posts-container">
                <div class="blog-post-card">
                    <img src="assets/blog_post1.jpg" alt="Blog Post Image 1">
                    <div class="post-content">
                        <h3>10 Mẹo Để Học Lập Trình Hiệu Quả</h3>
                        <p class="post-meta"><i class="fas fa-calendar-alt"></i> 20/07/2025 | <i class="fas fa-tag"></i> Học tập</p>
                        <p>Khám phá những phương pháp tốt nhất để tối ưu hóa quá trình học lập trình của bạn...</p>
                        <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="blog-post-card">
                    <img src="assets/blog_post2.jpg" alt="Blog Post Image 2">
                    <div class="post-content">
                        <h3>Xu Hướng Công Nghệ Nổi Bật Năm 2025</h3>
                        <p class="post-meta"><i class="fas fa-calendar-alt"></i> 15/07/2025 | <i class="fas fa-tag"></i> Công nghệ</p>
                        <p>Cập nhật những xu hướng công nghệ đang định hình tương lai của ngành lập trình...</p>
                        <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="blog-post-card">
                    <img src="assets/blog_post3.jpg" alt="Blog Post Image 3">
                    <div class="post-content">
                        <h3>Tạo Portfolio Lập Trình Ấn Tượng</h3>
                        <p class="post-meta"><i class="fas fa-calendar-alt"></i> 10/07/2025 | <i class="fas fa-tag"></i> Sự nghiệp</p>
                        <p>Hướng dẫn từng bước để xây dựng một portfolio giúp bạn nổi bật trong mắt nhà tuyển dụng...</p>
                        <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <button class="btn-secondary">Xem tất cả bài viết</button>
        </div>

        <div id="contact-section" class="section contact-section-bg">
            <h2 class="section-title">Liên Hệ Với Chúng Tôi</h2>
            <div class="contact-container">
                <div class="contact-info">
                    <h3>Thông tin liên hệ</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 123 Đường Lập Trình, Quận Code, Thành phố Cần Thơ</p>
                    <p><i class="fas fa-phone"></i> +84 987 654 321</p>
                    <p><i class="fas fa-envelope"></i> hotro@codehay.vn</p>
                    <div class="socials">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="contact-form">
                    <h3>Gửi tin nhắn cho chúng tôi</h3>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="name">Họ và tên:</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Chủ đề:</label>
                            <input type="text" id="subject" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="message">Nội dung:</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Gửi tin nhắn</button>
                    </form>
                </div>
            </div>
            <div class="map-container">
                 <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8415170367253!2d105.76842691479803!3d10.029933692830833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0895e6307137b%3A0x6a10065c71d33113!2zSOG7jWMgVmnhu4duIEtp4buDbiBUaOG7i3UgQ2FuIFRodeG7nyBLaWVudCDDsmEgdHXhuqNuIMSRw6Bv!5e0!3m2!1svi!2svn!4v1625000000000!5m2!1svi!2svn" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        
             </div>
             </div> <div id="footer">
            <div class="footer-content">
                <div class="footer-column about-us">
                    <h3>Về Code Hay</h3>
                    <p>Chúng tôi cung cấp các khóa học lập trình chất lượng cao, giúp bạn dễ dàng tiếp cận và làm chủ thế giới công nghệ.</p>
                </div>
                <div class="footer-column quick-links">
                    <h3>Liên kết nhanh</h3>
                    <ul>
                        <li><a href="#banner">Trang chủ</a></li>
                        <li><a href="#courses-section">Khoá học</a></li>
                        <li><a href="#blog-section">Blog</a></li>
                        <li><a href="#contact-section">Liên hệ</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                    </ul>
                </div>
                <div class="footer-column contact-info-footer">
                    <h3>Thông tin liên hệ</h3>
                    <p><i class="fas fa-map-marker-alt"></i> 132 Nguyễn Đệ, Bình Thuỷ, TP Cần Thơ</p>
                    <p><i class="fas fa-phone"></i> +84 798 059 074</p>
                    <p><i class="fas fa-envelope"></i> hotro@codehay.vn</p>
                </div>
                <div class="footer-column social-media">
                    <h3>Theo dõi chúng tôi</h3>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date("Y"); ?> Code Hay. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>