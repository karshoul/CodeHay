 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ</title>
    <link rel="stylesheet" href="assets/css/style.css">
 </head>
 <body>
 <?php include 'includes/header.php'; ?>
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
 </body>
 </html>   
    
    
    