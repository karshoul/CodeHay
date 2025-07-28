<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Các Khóa Học Nổi Bật - Trang 2 | CodeCrafted</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="all-course.css" />
</head>

<body>

    <div id="wrapper">
        <div id="header">
            <a href="#" class="logo">
                <span>CODE HAY</span>
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
    <h2 class="section-title">Các Khoá Học Nổi Bật (Trang 2)</h2>
    <div class="courses-container">
      <?php
        $courses2 = [
          ["course_flutter.png", "Flutter Mobile App", "Xây dựng ứng dụng di động đa nền tảng với Flutter.", "50", "4.8"],
          ["course_nodejs.jpg", "Node.js Backend", "Lập trình backend hiệu quả với Node.js và Express.", "60", "4.7"],
          ["course_csharp.jpg", "C# và .NET Framework", "Phát triển phần mềm với ngôn ngữ C#.", "55", "4.6"],
          ["course_ruby.jpg", "Ruby on Rails", "Xây dựng ứng dụng web với framework Ruby on Rails.", "45", "4.5"],
          ["course_android.jpg", "Lập trình Android Java", "Phát triển ứng dụng Android với Java.", "65", "4.7"],
          ["course_ios.jpg", "Lập trình iOS Swift", "Tạo app iOS native với Swift.", "55", "4.6"],
          ["course_uiux.jpg", "UX Research", "Nghiên cứu hành vi người dùng và trải nghiệm.", "30", "4.8"],
          ["course_cplusplus.jpg", "Lập Trình C++", "Hiểu bản chất lập trình hệ thống với C++.", "60", "4.7"],
          ["course_datastructures.jpg", "Cấu Trúc Dữ Liệu", "Tư duy thuật toán và xử lý dữ liệu.", "40", "4.9"],
          ["course_cyber.jpg", "An Ninh Mạng", "Cơ bản về bảo mật thông tin, ethical hacking.", "50", "4.8"],
        ];

        foreach ($courses2 as $c) {
          echo "<div class='course-card'>
                  <img src='assets/$c[0]' alt='$c[1]'>
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
