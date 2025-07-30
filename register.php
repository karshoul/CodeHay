<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký - Code Hay</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        
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
            color: var(--text-color);
            font-weight: 500;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .register-container button {
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

        .register-container button:hover {
            background-color: var(--secondary-color);
        }

        .register-container .message {
            margin-top: 20px;
            color: red;
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