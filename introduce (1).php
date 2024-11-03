<?php  
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tgos";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch store details
$id = $_GET['id'] ?? 1;  // Default to id 1 if no specific store id is provided
$sql = "SELECT pic, name, map, phone, time, tags, description, announcement FROM tgos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$store = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($store['name']); ?> - 店家介紹</title>
    <style>  
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            min-height: 100vh;
            background-color: #546377;
            color: #0d47a1;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
            margin-left: auto;
            margin-right: auto;
            display: flex;
            transition: margin-left 0.3s; /* 添加平滑過渡 */
        }

        .left {
            flex: 1;
            padding: 20px;
            margin-right: 20px;
            background-color: #f7f7f7; /* 淺色背景 */
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .right {
            flex: 2;
            padding: 20px;
            background-color: #ffffff; /* 白色背景 */
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 2em;
            color: #0d47a1; /* 藍色 */
        }

        .image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .info {
            margin: 15px 0;
        }

        .tags {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
        }

        .tag {
            display: inline-block;
            background-color: #007BFF;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 5px;
            transition: background-color 0.3s;
        }

        .tag:hover {
            background-color: #0056b3;
        }

        .editable, .comments-section, .announcement {
            margin-top: 20px;
        }

        .editable textarea, .announcement textarea, .comments-section textarea {
            width: 100%;
            height: 100px;
            margin-top: 5px;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            border: 1px solid #ccc;
            resize: vertical;
        }

        .submit-btn {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-btn:hover {
            background-color: #0056b3;
        }

        .comment {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            background-color: #f9f9f9; /* 淺色背景 */
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Left Section for Store Info -->
    <div class="left">
        <h1><?php echo htmlspecialchars($store['name']); ?></h1>
        
        <!-- Store Image -->
        <?php if ($store['pic']): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($store['pic']); ?>" alt="Store Image" class="image">
        <?php endif; ?>

        <!-- Store Information -->
        <div class="info">
            <p><strong>地址:</strong> <a href="https://www.google.com/maps/search/?api=1&query=<?php echo urlencode($store['map']); ?>" target="_blank"><?php echo htmlspecialchars($store['map']); ?></a></p>
            <p><strong>電話:</strong> <?php echo htmlspecialchars($store['phone']); ?></p>
            <p><strong>營業時間:</strong> <?php echo htmlspecialchars($store['time']); ?></p>
        </div>

        <!-- Tags -->
        <div class="tags">
            <?php
            $tags = explode(',', $store['tags']);
            foreach ($tags as $tag) {
                echo "<span class='tag'>" . htmlspecialchars($tag) . "</span>";
            }
            ?>
        </div>

        <!-- Editable Introduction Section -->
        <div class="editable">
            <h3>店家介紹</h3>
            <form method="post" action="update_intro.php?id=<?php echo $id; ?>">
                <textarea name="introduction"><?php echo htmlspecialchars($store['description'] ?? ''); ?></textarea> <!-- 使用正確的欄位名稱 -->
                <button type="submit" class="submit-btn">儲存介紹</button>
            </form>
        </div>

        <!-- Announcement Section -->
        <div class="announcement">
            <h3>公佈欄</h3>
            <form method="post" action="update_announcement.php?id=<?php echo $id; ?>">
                <textarea name="announcement"><?php echo htmlspecialchars($store['announcement'] ?? ''); ?></textarea>
                <button type="submit" class="submit-btn">儲存公佈</button>
            </form>
        </div>
    </div>

    <!-- Right Section for Comments -->
    <div class="right">
        <h3>留言區</h3>
        <form method="post" action="post_comment.php?id=<?php echo $id; ?>">
            <textarea name="comment" placeholder="留下您的留言"></textarea>
            <button type="submit" class="submit-btn">送出留言</button>
        </form>

        <!-- Display Comments -->
        <?php
        $comments_sql = "SELECT * FROM comments WHERE store_id = ? ORDER BY created_at DESC";
        $comments_stmt = $conn->prepare($comments_sql);
        $comments_stmt->bind_param("i", $id);
        $comments_stmt->execute();
        $comments_result = $comments_stmt->get_result();
        
        while ($comment = $comments_result->fetch_assoc()) {
            echo "<div class='comment'><p>" . htmlspecialchars($comment['content']) . "</p><small>時間: " . htmlspecialchars($comment['created_at']) . "</small></div>";
        }
        ?>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
