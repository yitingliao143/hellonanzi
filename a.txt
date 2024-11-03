<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁面</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="login-container">
        <h2>登入</h2>
        <form action="login.php" method="post">
            <div class="input-group">
                <label for="username">用戶名</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">密碼</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">登入</button>
        </form>
        <div class="forgot-password">
            <a href="forgot-password.php"><button type="submit">忘記密碼</button></a>
        </div></br>
        <div class="register-link">
            <a href="register.php"><button type="submit">註冊</button></a>
        </div>
    </div>
	
</body>
</html>
