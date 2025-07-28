<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Code hay</title>
    <link rel="stylesheet" href="style.css"> <style>
        /* Thêm CSS cho form đăng nhập */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--light-gray);
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            background-color: var(--white);
            padding: 40px;
            border-radius: 10px;
            box-shadow: var(--shadow-medium);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .login-container h2 {
            color: var(--primary-color);
            margin-bottom: 30px;
            font-size: 2em;
        }

        .login-container .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .login-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-gray);
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--medium-gray);
            border-radius: 5px;
            font-size: 1em;
            color: var(--text-color);
            transition: border-color 0.3s ease;
        }

        .login-container input[type="text"]:focus,
        .login-container input[type="password"]:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 102, 0, 0.2);
        }

        .login-container button {
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

        .login-container button:hover {
            background-color: #e65500;
        }

        .login-container .message {
            margin-top: 20px;
            color: red;
            font-weight: 500;
        }

        .login-container p {
            margin-top: 20px;
            font-size: 0.9em;
            color: var(--dark-gray);
        }
        .login-container p a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        .login-container p a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Tên đăng nhập hoặc Email:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Đăng nhập</button>
            <?php
            // Đảm bảo PHP được mở và đóng đúng cách
            if (isset($_GET['error'])) {
                echo '<p class="message">' . htmlspecialchars($_GET['error']) . '</p>';
            }
            ?>
        </form>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p> </div>
</body>

</html>