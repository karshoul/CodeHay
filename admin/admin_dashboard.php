<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login.php"); // Thêm "../" để lùi ra một thư mục
    exit();
}
require_once("../includes/db_connect.php");
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      font-family: 'Montserrat', sans-serif;
    }

    body {
      margin: 0;
      background: #f4f6f8;
      color: #333;
    }

    .admin-header {
      background: #2c3e50;
      color: white;
      padding: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .admin-header h1 {
      margin: 0;
      font-size: 26px;
    }

    .admin-header a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.2s;
    }

    .admin-header a:hover {
      color: #1abc9c;
    }

    .admin-content {
      max-width: 1100px;
      margin: 40px auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }

    section {
      background: white;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.2s;
    }

    section:hover {
      transform: translateY(-5px);
    }

    h2 {
      margin-top: 0;
      color: #2c3e50;
      font-size: 20px;
    }

    .btn {
      display: inline-block;
      margin-top: 15px;
      padding: 10px 16px;
      background: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: bold;
      transition: background 0.2s;
    }

    .btn:hover {
      background: #2980b9;
    }

    .icon {
      margin-right: 8px;
    }
  </style>
</head>
<body>

  <?php include '../includes/header.php'; ?>
  <header class="admin-header">
    <h1>Bảng điều khiển Quản trị viên</h1>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
  </header>

  <main class="admin-content">
    <section>
      <h2><i class="fas fa-book icon"></i>Quản lý khóa học</h2>
      <p>Xem, chỉnh sửa và thêm mới các khóa học hiện có.</p>
      <a href="manage_courses.php" class="btn">Xem danh sách</a>
    </section>

    <section>
      <h2><i class="fas fa-users icon"></i>Quản lý người dùng</h2>
      <p>Quản lý thông tin và phân quyền người dùng.</p>
      <a href="manage_users.php" class="btn">Xem người dùng</a>
    </section>

    <section>
      <h2><i class="fas fa-chart-line icon"></i>Thống kê truy cập</h2>
      <p>Xem báo cáo số lượt truy cập và hành vi người dùng.</p>
      <a href="#" class="btn">Xem thống kê</a>
    </section>
  </main>
</body>
</html>
