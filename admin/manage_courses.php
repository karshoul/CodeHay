<?php
session_start();
require_once '../includes/db_connect.php'; // Đảm bảo đường dẫn này đã đúng

// Kiểm tra xem người dùng đã đăng nhập chưa và có vai trò admin không
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php"); // Chuyển hướng về trang đăng nhập
    exit();
}
// Kích hoạt kiểm tra vai trò admin - RẤT QUAN TRỌNG CHO BẢO MẬT
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); // Hoặc trang báo lỗi quyền truy cập
    exit();
}


// Lấy tất cả khóa học (Đã bỏ cột 'rating')
$sql = "SELECT id, title, description, image, duration FROM courses ORDER BY id ASC";
$result = $conn->query($sql);

$message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'deleted') {
        $message = '<p class="success-msg">Khóa học đã được xóa thành công!</p>';
    } elseif ($_GET['status'] == 'updated') {
        $message = '<p class="success-msg">Khóa học đã được cập nhật thành công!</p>';
    } elseif ($_GET['status'] == 'error') {
        $message = '<p class="error-msg">Có lỗi xảy ra. Vui lòng thử lại!</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quản Lý Khóa Học | CODE HAY</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="../assets/css/header.css">
    <style>
        /* CSS cho layout quản lý dạng bảng */
        #all-courses-content {
            max-width: 1200px; /* Tăng chiều rộng tối đa */
            margin: 40px auto;
            padding: 20px;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: var(--shadow-medium);
        }

        .section-title {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2.5em;
        }

        .add-course-btn-container {
            text-align: right;
            margin-bottom: 20px;
        }
        .add-course-btn {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease;
            display: inline-block;
        }
        .add-course-btn:hover {
            background-color: var(--secondary-color);
        }

        .success-msg {
            color: green;
            background-color: #e0ffe0;
            border: 1px solid green;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .error-msg {
            color: red;
            background-color: #ffe0e0;
            border: 1px solid red;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        /* CSS cho bảng quản lý khóa học */
        .course-management-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .course-management-table th,
        .course-management-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: middle;
        }

        .course-management-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }

        .course-management-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .course-management-table tr:hover {
            background-color: #f1f1f1;
        }

        .course-management-table img {
            width: 80px; /* Kích thước ảnh nhỏ hơn trong bảng */
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .course-management-table .actions {
            display: flex;
            gap: 5px;
            justify-content: center; /* Căn giữa các nút hành động */
            align-items: center;
        }
        .course-management-table .actions a {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
            font-size: 0.9em;
        }
        .course-management-table .actions .edit-btn {
            background-color: var(--secondary-color); /* Màu xanh */
            color: white;
        }
        .course-management-table .actions .edit-btn:hover {
            background-color: #0056b3;
        }
        .course-management-table .actions .delete-btn {
            background-color: #dc3545; /* Màu đỏ */
            color: white;
        }
        .course-management-table .actions .delete-btn:hover {
            background-color: #c82333;
        }

        /* Responsive cho bảng */
        @media (max-width: 768px) {
            .course-management-table, .course-management-table tbody, .course-management-table td, .course-management-table th, .course-management-table tr {
                display: block;
            }

            .course-management-table thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .course-management-table tr {
                margin-bottom: 15px;
                border: 1px solid #ddd;
                display: flex;
                flex-wrap: wrap;
            }

            .course-management-table td {
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 50%;
                text-align: right;
                flex: 1 1 100%; /* Mỗi ô chiếm toàn bộ chiều rộng */
            }

            .course-management-table td:before {
                position: absolute;
                top: 6px;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                text-align: left;
                font-weight: bold;
                content: attr(data-label);
            }
            .course-management-table td.center-content {
                text-align: center;
            }
            .course-management-table td .actions {
                justify-content: flex-end; /* Căn phải các nút trên mobile */
            }
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <header>
            <div id="header">
                <a href="../index.php" class="logo"> <span>CODE HAY</span>
                </a>
                <div id="menu">
                    <div class="item"><a href="../index.php">Trang chủ</a></div>
                    <div class="item"><a href="../index.php#courses-section">Khoá học</a></div>
                    <div class="item"><a href="../index.php#blog-section">Blog</a></div>
                    <div class="item"><a href="../index.php#contact-section">Liên hệ</a></div>
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
                                <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="item">
                            <a href="../login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Đăng nhập</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <div id="all-courses-content">
            <h2 class="section-title">Quản Lý Khóa Học</h2>
            <div class="add-course-btn-container">
                <a href="add_course.php" class="add-course-btn"><i class="fas fa-plus-circle"></i> Thêm Khoá Học Mới</a>
            </div>
            <?php echo $message; // Hiển thị thông báo ?>

            <?php if ($result && $result->num_rows > 0): ?>
                <table class="course-management-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Mô tả</th>
                            <th>Thời lượng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $row_number = 1; ?>
                        <?php while ($course = $result->fetch_assoc()): ?>
                            <tr>
                                <td data-label="STT"><?php echo $row_number++; ?></td>
                                <td data-label="Ảnh"><img src="../assets/img/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>"></td>
                                <td data-label="Tiêu đề"><?php echo htmlspecialchars($course['title']); ?></td>
                                <td data-label="Mô tả"><?php echo nl2br(htmlspecialchars(mb_strimwidth($course['description'], 0, 100, "..."))); // Cắt bớt mô tả nếu quá dài ?></td>
                                <td data-label="Thời lượng"><?php echo htmlspecialchars($course['duration']); ?> giờ</td>
                                <td data-label="Hành động" class="actions">
                                    <a href="edit_course.php?id=<?php echo $course['id']; ?>" class="edit-btn"><i class="fas fa-edit"></i> Sửa</a>
                                    <a href="delete_course.php?id=<?php echo $course['id']; ?>" class="delete-btn" onclick="return confirm('Bạn có chắc chắn muốn xóa khóa học này không?');"><i class="fas fa-trash-alt"></i> Xóa</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="no-courses-found">Không tìm thấy khóa học nào để quản lý.</p>
            <?php endif; ?>
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
                        <li><a href="../index.php#banner">Trang chủ</a></li> <li><a href="../index.php#courses-section">Khoá học</a></li> <li><a href="../index.php#blog-section">Blog</a></li> <li><a href="../index.php#contact-section">Liên hệ</a></li> <li><a href="#">Chính sách bảo mật</a></li>
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
                <p>&copy; <?php echo date("Y"); ?> Code Hay. All rights reserved.</p>
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