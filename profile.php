<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit();
}

// Bao gồm file kết nối cơ sở dữ liệu
include 'includes/db_connect.php';

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];
$username_from_session = $_SESSION['username'];
$email_from_session = isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A'; // Lấy email từ session nếu có

// Lấy thông tin chi tiết hơn từ cơ sở dữ liệu nếu cần
$full_name = "Chưa cập nhật";
$phone_number = "Chưa cập nhật";
$address = "Chưa cập nhật";
$created_at = "N/A";

$stmt = $conn->prepare("SELECT full_name, phone_number, address, created_at FROM users WHERE id = ?");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user_info_db = $result->fetch_assoc();
        $full_name = htmlspecialchars($user_info_db['full_name'] ?: "Chưa cập nhật");
        $phone_number = htmlspecialchars($user_info_db['phone_number'] ?: "Chưa cập nhật");
        $address = htmlspecialchars($user_info_db['address'] ?: "Chưa cập nhật");
        $created_at = htmlspecialchars($user_info_db['created_at'] ?: "N/A");
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản - Code Hay</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        /* CSS cho trang profile */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-gray);
            margin: 0;
            padding: 0;
        }

        #wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .profile-container {
            flex-grow: 1;
            background-color: var(--white);
            padding: 40px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: var(--shadow-medium);
            width: 90%;
            max-width: 600px;
            text-align: left;
        }

        .profile-container h2 {
            color: var(--primary-color);
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.2em;
        }

        .profile-info p {
            font-size: 1.1em;
            margin-bottom: 15px;
            color: var(--text-color);
            line-height: 1.6;
        }

        .profile-info strong {
            color: var(--dark-gray);
            min-width: 150px; /* Adjust as needed for alignment */
            display: inline-block;
        }

        .profile-actions {
            margin-top: 30px;
            text-align: center;
        }
        .profile-actions a {
            margin: 0 10px;
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .profile-actions a:hover {
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <?php include 'includes/header.php'; ?>

        <div class="profile-container">
            <h2>Thông tin tài khoản</h2>
            <div class="profile-info">
                <p><strong>Tên đăng nhập:</strong> <?php echo $username_from_session; ?></p>
                <p><strong>Email:</strong> <?php echo $email_from_session; ?></p>
                <p><strong>Họ và tên:</strong> <?php echo $full_name; ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo $phone_number; ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo $address; ?></p>
                <p><strong>Ngày tạo tài khoản:</strong> <?php echo $created_at; ?></p>
            </div>
            <div class="profile-actions">
                <a href="#">Chỉnh sửa thông tin</a>
                <a href="#">Đổi mật khẩu</a>
                <a href="index.php" class="btn-primary">Về trang chủ</a>
            </div>
        </div>
    </div>
</body>
</html>