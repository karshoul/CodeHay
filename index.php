<?php
session_start(); // Bắt đầu session
// Không có kiểm tra đăng nhập ở đây để trang chủ luôn công khai
require_once 'includes/db_connect.php'; // Bao gồm file kết nối cơ sở dữ liệu

// Truy vấn để lấy các khóa học nổi bật từ cơ sở dữ liệu
// Giới hạn 4 khóa học để hiển thị trên trang chủ
$sql_courses = "SELECT id, title, description, image, duration, rating FROM courses ORDER BY created_at DESC LIMIT 4";
$result_courses = $conn->query($sql_courses);

// Đóng kết nối cơ sở dữ liệu sau khi sử dụng
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CODE HAY</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div id="wrapper"> <?php include 'includes/header.php'; ?> <div id="banner">
            <div class="box-left">
                <h2>
                    <span>LẬP TRÌNH KHÔNG KHÓ</span><br>
                    <span>VÌ CÓ CODE HAY</span>
                </h2>
                <p>
                    Học lập trình trong thời gian ngắn nhất<br>
                    nắm được cơ bản và phát triển toàn diện.<br>
                </p>
                <button class="btn-primary">Mua ngay</button>
            </div>
            <div class="box-right">
                </div>
        </div>

        <div id="courses-section" class="section">
            <h2 class="section-title">Các Khoá Học Nổi Bật</h2>
            <div class="courses-container">
                <?php if ($result_courses && $result_courses->num_rows > 0): ?>
                    <?php while ($course = $result_courses->fetch_assoc()): ?>
                        <div class="course-card">
                            <img src="assets/img/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                            <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                            <p><?php echo htmlspecialchars($course['description']); ?></p>
                            <div class="course-meta">
                                <span><i class="fas fa-clock"></i> <?php echo htmlspecialchars($course['duration']); ?> giờ</span>
                                <span><i class="fas fa-star"></i> <?php echo htmlspecialchars($course['rating']); ?></span>
                            </div>
                            <a href="course_detail.php?id=<?php echo $course['id']; ?>" class="btn-primary">Tìm hiểu thêm</a> </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-courses-found">Hiện chưa có khóa học nào được thêm.</p>
                <?php endif; ?>
            </div>

            <a href="all-course.php">
                <button class="btn-secondary">Xem tất cả khoá học</button>
            </a>
        </div>

        <div id="blog-section" class="section">
            <h2 class="section-title">Bài Viết Mới Nhất</h2>
            <div class="blog-posts-container">
                <div class="blog-post-card">
                    <img src="assets/img/10pphoclaptrinh.png" alt="Blog Post Image 1">
                    <div class="post-content">
                        <h3>10 Mẹo Để Học Lập Trình Hiệu Quả</h3>
                        <p class="post-meta"><i class="fas fa-calendar-alt"></i> 20/07/2025 | <i class="fas fa-tag"></i> Học tập</p>
                        <p>Khám phá những phương pháp tốt nhất để tối ưu hóa quá trình học lập trình của bạn...</p>
                        <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="blog-post-card">
                    <img src="assets/img/xuhuongcongnghe2025.jpg" alt="Blog Post Image 2">
                    <div class="post-content">
                        <h3>Xu Hướng Công Nghệ Nổi Bật Năm 2025</h3>
                        <p class="post-meta"><i class="fas fa-calendar-alt"></i> 15/07/2025 | <i class="fas fa-tag"></i> Công nghệ</p>
                        <p>Cập nhật những xu hướng công nghệ đang định hình tương lai của ngành lập trình...</p>
                        <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="blog-post-card">
                    <img src="assets/img/taoportpolio.jpg" alt="Blog Post Image 3">
                    <div class="post-content">
                        <h3>Tạo Portfolio Lập Trình Ấn Tượng</h3>
                        <p class="post-meta"><i class="fas fa-calendar-alt"></i> 10/07/2025 | <i class="fas fa-tag"></i> Sự nghiệp</p>
                        <p>Hướng dẫn từng bước để xây dựng một portfolio giúp bạn nổi bật trong mắt nhà tuyển dụng...</p>
                        <a href="#" class="read-more">Đọc thêm <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <a href="all-blog-page1.php">
                <button class="btn-secondary">Xem tất cả bài viết</button>
            </a>
        </div>

        <div id="contact-section" class="section contact-section-bg">
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8415170367253!2d105.76842691479803!3d10.029933692830833!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0895e6307137b%3A0x6a10065c71d33113!2zSOG7jWMgVmnhu4duIEtp4buDbiBUaOG7i3UgQ2FuIFRodeG7nyBLaWVudCDDsmEgdHXhuqNuIMSRw6Bv!5e0!3m2!1svi!2svn!4v1625000000000!5m2!1svi!2svn" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?> </div>
    <script src="assets/js/script.js"></script>
</body>
</html>