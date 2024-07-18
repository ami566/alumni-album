<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];



$stmt = $conn->prepare("SELECT orders.id, orders.photo_id, orders.order_type, orders.order_date, orders.status, photos.photo_path 
                        FROM orders 
                        JOIN photos ON orders.photo_id = photos.id 
                        WHERE orders.user_id = ? 
                        ORDER BY orders.order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <nav class="menu menu-2">
        <ul>
            <li><a href="profile.php">Профил</a></li>
            <li><a href="catalog2.php">Каталог със снимки</a></li> 
            <li><a href="photoshoots.php">Фотосесии</a></li>
            <li><a href="orders.php">Поръчки</a></li>
            <li><a href="logout.php">Изход</a></li>
        </ul>
    </nav>
    <title>Моите поръчки</title>
</head>
<body>
    <h1>Моите поръчки</h1>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Номер на поръчка</th>";
        echo "<th>Снимка</th>";
        echo "<th>Тип на поръчката</th>";
        echo "<th>Дата на поръчка</th>";
        echo "<th>Статус</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td><img src=\"" . htmlspecialchars($row['photo_path']) . "\" alt=\"Photo\" class=\"photo\"></td>";
            echo "<td>" . htmlspecialchars($row['order_type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Нямате направени поръчки.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
