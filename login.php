<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - Code Hay</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
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
            color: var(--text-color);
            font-weight: 500;
        }

        .login-container input[type="text"],
        .login-container input[type="email"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .login-container button {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            font-weight: 600;
            transition: background-color 0.3s ease;
            width: 100%;
            margin-top: 10px;
        }

        .login-container button:hover {
            background-color: var(--secondary-color);
        }

        .login-container .message {
            margin-top: 20px;
            color: red;
            font-weight: 500;
        }
        .login-container .success-message {
            color: green;
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
            if (isset($_GET['error'])) {
                echo '<p class="message">' . htmlspecialchars($_GET['error']) . '</p>';
            } elseif (isset($_GET['message']) && isset($_GET['type']) && $_GET['type'] == 'success') {
                echo '<p class="message success-message">' . htmlspecialchars($_GET['message']) . '</p>';
            }
            ?>
        </form>
        <p>Chưa có tài khoản? <a href="register.php">Đăng ký ngay</a></p>
    </div>
</body>

</html>