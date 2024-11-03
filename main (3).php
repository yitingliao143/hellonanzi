<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>歡迎成為楠梓人</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h1>歡迎成為楠梓人</h1>
    </header>

    <div class="container">
        <div class="left-section">
            <!-- 左上角：最新新聞 -->
            <div class="news-section">
                <h3>最新新聞</h3>
                <p>這裡顯示最新新聞內容</p>
            </div>

            <!-- 左下角：地圖 -->
            <div id="TGMap">地圖</div>
        </div>

        <div class="right-section">
            <!-- 右上角：功能按鈕和搜尋 -->
            <div class="top-right">
                <li>
                    <?php if (isset($_SESSION['login']) && $_SESSION['login'] === true): ?>
                        <form action="logout.php" method="post" style="display:inline;">
                            <button type="submit" style="background: none; border: none; color: white;">登出</button>
                        </form>
                    <?php else: ?>
                        <a href="index.php" class="floating-button">登入</a>
                    <?php endif; ?>
                </li>
                <div class="search-container">
                    <input type="text" placeholder="搜尋...">
                    <button type="submit">搜尋</button>
                </div>
            </div>

            <!-- 右下角：功能按鈕 2 和其他按鈕 -->
            <div class="bottom-right">
                <button class="full-width-button">功能按鈕 1</button>
                <button class="full-width-button">功能按鈕 2</button>
                <li class="dropdown">
                    <button class="floating-button">分類</button>
                    <div class="dropdown-content dropdown-content-categories">
                        <a href="#">美食</a>
                        <a href="#">生活</a>
                        <a href="#">遊樂</a>
                        <a href="#">穿搭</a>
                        <a href="#">交通</a>
                    </div>
                </li>
                <li class="button-container button-container-add-store">
                    <a href="#" onclick="location.href='add_data.php'">新增店家</a>
                </li>
                <li class="button-container button-container-store-overview">
                    <a href="#" onclick="location.href='store.php'">店家總覽</a>
                </li>
                <li class="dropdown">
                    <button class="floating-button">語言</button>
                    <div class="dropdown-content dropdown-content-language">
                        <button onclick="switchLanguage('zh')">中文</button>
                        <button onclick="switchLanguage('en')">English</button>
                    </div>
                </li>
            </div>
        </div>
    </div>
</body>
</html>
