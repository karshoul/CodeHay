// Trong file assets/js/script.js của bạn

document.addEventListener('DOMContentLoaded', function() {
    const userDropdownBtn = document.getElementById('userDropdownBtn');
    const userDropdownContent = document.getElementById('userDropdownContent');

    if (userDropdownBtn && userDropdownContent) {
        // Xử lý khi nhấp vào nút "Xin chào, Username"
        userDropdownBtn.addEventListener('click', function(event) {
            event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a> (chuyển hướng trang)
            userDropdownContent.classList.toggle('show'); // Thêm hoặc loại bỏ class 'show'
        });

        // Xử lý khi nhấp chuột ra ngoài dropdown, thì đóng dropdown lại
        window.addEventListener('click', function(event) {
            // Nếu click không phải là nút dropdown và cũng không phải là bên trong nội dung dropdown
            if (!userDropdownBtn.contains(event.target) && !userDropdownContent.contains(event.target)) {
                if (userDropdownContent.classList.contains('show')) {
                    userDropdownContent.classList.remove('show');
                }
            }
        });
    }

    // (Giữ lại các script khác của bạn nếu có)
});