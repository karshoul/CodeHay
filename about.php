<?php
session_start();
require_once 'includes/db_connect.php'; // Kết nối cơ sở dữ liệu

// Đóng kết nối cơ sở dữ liệu sau khi sử dụng, nếu cần
if ($conn) {
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới Thiệu Về CODE HAY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css"> <style>
        /* CSS tùy chỉnh cho trang giới thiệu */
        .about-section {
            padding: 80px 0;
            background-color: var(--light-gray);
            text-align: center;
            margin-top: 70px; /* Đảm bảo nội dung không bị header che mất */
        }

        .about-container {
            max-width: 960px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .about-container h2 {
            font-size: 2.8em;
            color: var(--primary-color);
            margin-bottom: 30px;
            position: relative;
            padding-bottom: 10px;
        }

        .about-container h2::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--secondary-color);
            border-radius: 2px;
        }

        .about-container p {
            font-size: 1.1em;
            line-height: 1.8;
            color: var(--dark-gray);
            margin-bottom: 20px;
            text-align: justify;
        }

        .about-container .highlight {
            font-weight: bold;
            color: var(--primary-color);
        }

        .about-container .vision-mission {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 40px;
            gap: 20px;
        }

        .about-container .vision-mission .box {
            background-color: var(--white);
            padding: 30px;
            border-radius: 10px;
            box-shadow: var(--shadow-small);
            flex: 1;
            min-width: 300px;
            text-align: left;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .about-container .vision-mission .box:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-medium);
        }

        .about-container .vision-mission .box h3 {
            font-size: 1.8em;
            color: var(--secondary-color);
            margin-bottom: 15px;
            border-bottom: 2px solid var(--light-gray);
            padding-bottom: 10px;
        }

        .about-container .vision-mission .box p {
            font-size: 1em;
            color: var(--text-color);
            text-align: left;
        }

        @media (max-width: 768px) {
            .about-container h2 {
                font-size: 2em;
            }
            .about-container p {
                font-size: 1em;
            }
            .about-container .vision-mission .box {
                min-width: unset;
                width: 100%;
            }
        }
    </style>
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
                    <div class="item"><a href="all-course.php">Khóa học</a></div>
                    <div class="item"><a href="all-blog-page1.php">Blog</a></div>
                    <div class="item"><a href="about.php">Giới thiệu</a></div>
                </div>
                <div class="actions">
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <div class="item dropdown">
                            <a href="#" class="dropbtn" id="userDropdownBtn">
                                <i class="fas fa-user"></i>
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
        <div class="about-section">
            <div class="about-container">
                <h2>Về Chúng Tôi</h2>
                <p>
                    Chào mừng bạn đến với <span class="highlight">CODE HAY</span> – nơi chắp cánh đam mê lập trình và mang đến kiến thức công nghệ chất lượng cao. Chúng tôi là một cộng đồng và nền tảng giáo dục trực tuyến, được thành lập với sứ mệnh giúp mọi người tiếp cận và thành thạo lập trình, từ những người mới bắt đầu cho đến các lập trình viên muốn nâng cao kỹ năng.
                </p>
                <p>
                    Tại CODE HAY, chúng tôi tin rằng lập trình không chỉ là một kỹ năng, mà là một ngôn ngữ giúp bạn giải quyết vấn đề, sáng tạo và mở ra vô vàn cơ hội trong thế giới số. Chúng tôi cam kết cung cấp các khóa học được thiết kế kỹ lưỡng, nội dung thực tiễn, và phương pháp giảng dạy hiện đại để đảm bảo bạn có được trải nghiệm học tập tốt nhất.
                </p>
                <p>
                    Đội ngũ của chúng tôi bao gồm các chuyên gia lập trình, giảng viên giàu kinh nghiệm và những người có chung niềm đam mê với công nghệ. Chúng tôi không ngừng cập nhật nội dung để bắt kịp với những xu hướng mới nhất trong ngành, từ phát triển web, ứng dụng di động, khoa học dữ liệu cho đến trí tuệ nhân tạo.
                </p>

                <div class="vision-mission">
                    <div class="box">
                        <h3>Tầm Nhìn</h3>
                        <p>Trở thành nền tảng giáo dục lập trình hàng đầu, truyền cảm hứng và trang bị cho hàng triệu người trên toàn thế giới những kỹ năng cần thiết để thành công trong kỷ nguyên số.</p>
                    </div>
                    <div class="box">
                        <h3>Sứ Mệnh</h3>
                        <p>Cung cấp môi trường học tập chất lượng cao, dễ tiếp cận, thực tiễn và liên tục đổi mới, giúp học viên phát triển tư duy lập trình và đạt được mục tiêu sự nghiệp.</p>
                    </div>
                </div>

                <p style="margin-top: 40px;">
                    Hãy cùng <span class="highlight">CODE HAY</span> khám phá thế giới lập trình đầy thú vị và xây dựng tương lai công nghệ của bạn!
                </p>
            </div>
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
                        <li><a href="all-course.php">Khoá học</a></li>
                        <li><a href="all-blog-page1.php">Blog</a></li>
                        <li><a href="contact.php">Liên hệ</a></li>
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
    // JavaScript để xử lý dropdown menu
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
                // Kiểm tra xem click có phải vào nút dropdown hoặc bên trong dropdown content không
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