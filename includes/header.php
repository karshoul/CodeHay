<?php
// Đảm bảo session đã được khởi tạo trước khi include file này ở các trang khác
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<header>
<link rel="stylesheet" href="assets/css/header.css">
<div id="header">
    <a href="index.php" class="logo">
        <span>CODE HAY</span>
    </a>
    <div id="menu">
        <div class="item"><a href="index.php">Trang chủ</a></div>
        <div class="item"><a href="index.php#courses-section">Khoá học</a></div>
        <div class="item"><a href="index.php#blog-section">Blog</a></div>
        <div class="item"><a href="index.php#contact-section">Liên hệ</a></div>
    </div>
    <div class="actions">
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <div class="item dropdown">
                <a href="#" class="dropbtn" id="userDropdownBtn"> <i class="fas fa-user"></i>
                    <span>Xin chào, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <i class="fas fa-caret-down"></i>
                </a>
                <div class="dropdown-content" id="userDropdownContent"> <a href="profile.php"><i class="fas fa-info-circle"></i> Xem thông tin</a>
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