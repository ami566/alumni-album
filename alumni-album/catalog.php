<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}


$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'upload_date';
$sort_order = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'asc' : 'desc';

$valid_columns = ['id', 'user_id', 'photo_path', 'upload_date', 'major', 'potok_number', 'stream', 'event'];
if (!in_array($sort_column, $valid_columns)) {
    $sort_column = 'upload_date';
}

$stmt = $conn->prepare("SELECT id, user_id, photo_path, upload_date, major, potok_number, stream, event FROM photos ORDER BY $sort_column $sort_order");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Каталог със снимки</title>
</head>
<body>
    <nav class="menu menu-2">
        <ul>
            <li><a href="profile.php">Профил</a></li>
            <li><a href="catalog2.php">Каталог със снимки</a></li> 
            <li><a href="photoshoots.php">Фотосесии</a></li>
            <li><a href="orders.php">Поръчки</a></li>
            <li><a href="logout.php">Изход</a></li>
        </ul>
    </nav>
    <div class="header-container">
    <h1>Каталог със снимки</h1>
    <div class="icon-container">
        <a href="catalog2.php"><img class="icon" src="uploads/grid.png" alt="grid"></a>
        <a href="catalog.php"><img class="icon" src="uploads/table.png" alt="table"></a>
    </div>
</div>
<a href="html/upload_photo.html">Качи снимка</a> 
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr>";
        foreach ($valid_columns as $column) {
            $new_order = $sort_order == 'asc' ? 'desc' : 'asc';
            echo "<th><a href=\"?sort=$column&order=$new_order\">" . ucfirst(str_replace('_', ' ', $column)) . "</a></th>";
        }
        echo "<th>Photo</th>";
        echo "<th>Order</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($valid_columns as $column) {
                echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
            }
            echo "<td><img src=\"" . htmlspecialchars($row['photo_path']) . "\" alt=\"Photo\" class=\"photo\" onclick=\"openModal('" . htmlspecialchars($row['photo_path']) . "')\"></td>";
            echo "<td><button onclick=\"document.getElementById('order-form-".$row['id']."').style.display='block'\">Order</button></td>";
            echo "</tr>";

            echo "<tr id='order-form-".$row['id']."' class='order-form' style='display: none;'>";
            echo "<td colspan='".(count($valid_columns) + 2)."'>";
            echo "<form action='order.php' method='POST'>";
            echo "<input type='hidden' name='photo_id' value='".$row['id']."'>";
            echo "<label for='order_type'>Тип на поръчка:</label>";
            echo "<select name='order_type'>";
            echo "<option value='album'>Албум</option>";
            echo "<option value='card'>Карта</option>";
            echo "<option value='calendar'>Календар</option>";
            echo "<option value='mug'>Чаша</option>";
            echo "<option value='bridge_card'>Карти за бридж</option>";
            echo "<option value='frame'>Рамка</option>";
            echo "</select>";
            echo "<button type='submit'>Поръчай</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Няма налични снимки.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <img id="modalImage" src="">
        </div>
    </div>
    <script>
        function openModal(src) {
            document.getElementById('imageModal').style.display = "block";
            document.getElementById('modalImage').src = src;
        }
        function closeModal() {
            document.getElementById('imageModal').style.display = "none";
        }
    </script>
</body>
</html>
