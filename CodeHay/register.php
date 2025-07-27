<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Code hay</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS tương tự như login.html, có thể tái sử dụng hoặc điều chỉnh */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--light-gray);
            font-family: 'Poppins', sans-serif;
        }

        .register-container {
            background-color: var(--white);
            padding: 40px;
            border-radius: 10px;
            box-shadow: var(--shadow-medium);
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .register-container h2 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2em;
        }

        .register-container .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .register-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-gray);
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            font-size: 1em;
            color: var(--text-color);
            transition: border-color 0.3s ease;
        }

        .register-container input[type="text"]:focus,
        .register-container input[type="email"]:focus,
        .register-container input[type="password"]:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 102, 0, 0.2);
        }

        .register-container button {
            width: 100%;
            padding: 15px;
            background-color: var(--secondary-color);
            border: none;
            color: var(--white);
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 1.1em;
            text-transform: uppercase;
        }

        .register-container button:hover {
            background-color: #e65500;
        }

        .register-container .message {
            margin-top: 20px;
            font-weight: 500;
        }
        .register-container .success-message {
            color: green;
        }
        .register-container .error-message {
            color: red;
        }

        .register-container p {
            margin-top: 20px;
            font-size: 0.9em;
            color: var(--dark-gray);
        }
        .register-container p a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        .register-container p a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h2>Đăng ký tài khoản mới</h2>
        <form action="register_process.php" method="POST">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Xác nhận mật khẩu:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit">Đăng ký</button>
            <?php
            // Hiển thị thông báo (nếu có)
            if (isset($_GET['message'])) {
                $msg_type = (isset($_GET['type']) && $_GET['type'] == 'success') ? 'success-message' : 'error-message';
                echo '<p class="message ' . $msg_type . '">' . htmlspecialchars($_GET['message']) . '</p>';
            }
            ?>
        </form>
        <p>Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a></p>
    </div>
</body>

</html>