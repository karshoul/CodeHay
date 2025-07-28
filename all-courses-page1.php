<!-- all-courses.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Các Khóa Học Nổi Bật</title>
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
                        <img src="assets/logout.png" alt="Logout" style="width: 22px; height: auto;">
                        </a>


                    <?php else: ?>
                        <a href="login.php" style="text-decoration: none;"> <img src="assets/user.png" alt="User" style="width: 22px; height: auto;">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>


  <div id="courses-section" class="section">
    <h2 class="section-title">Các Khoá Học Nổi Bật</h2>
    <div class="courses-container">
      <?php
        $courses = [
          ["course_html_css.jpg", "Khoá Học HTML & CSS Cơ Bản", "Xây dựng giao diện website đầu tiên với HTML và CSS.", "30", "4.8"],
          ["course_javascript.jpg", "Khoá Học JavaScript Toàn Diện", "Làm chủ JavaScript, thêm tương tác và logic cho website.", "60", "4.9"],
          ["course_react.jpg", "Phát Triển Web với ReactJS", "Xây dựng ứng dụng web hiện đại với ReactJS.", "50", "4.7"],
          ["course_python.png", "Lập Trình Python Từ A-Z", "Học Python để phát triển web, AI và phân tích dữ liệu.", "45", "4.9"],
          ["course_php.jpg", "Lập Trình PHP Cơ Bản", "Tạo website động bằng PHP và MySQL.", "40", "4.6"],
          ["course_java.png", "Java OOP & Spring Boot", "Phát triển ứng dụng doanh nghiệp với Java.", "55", "4.7"],
          ["course_sql.jpg", "Hệ Quản Trị CSDL với SQL", "Thiết kế và truy vấn dữ liệu hiệu quả bằng SQL.", "35", "4.5"],
          ["course_figma.png", "Thiết Kế UI với Figma", "Thiết kế giao diện đẹp và thực tế cho sản phẩm số.", "25", "4.6"],
          ["course_ai.jpg", "Nhập Môn Trí Tuệ Nhân Tạo", "Hiểu cơ bản về AI, Machine Learning và ứng dụng.", "50", "4.8"],
          ["course_git.jpg", "Quản Lý Mã Nguồn với Git", "Sử dụng Git và GitHub trong làm việc nhóm.", "20", "4.9"],
        ];

        foreach ($courses as $c) {
          echo "<div class='course-card'>
                  <img src='assets/img/$c[0]' alt='$c[1]'>
                  <h3>$c[1]</h3>
                  <p>$c[2]</p>
                  <div class='course-meta'>
                    <span><i class='fas fa-clock'></i> $c[3] giờ</span>
                    <span><i class='fas fa-star'></i> $c[4]</span>
                  </div>
                  <button class='btn-primary'>Tìm hiểu thêm</button>
                </div>";
        }
      ?>
    </div>

     <div class="pagination">
      <a href="all-courses-page1.php">1</a>
      <a href="all-courses-page2.php">2</a>
    </div>
  </div>

</body>
</html>