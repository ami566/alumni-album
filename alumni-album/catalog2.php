<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}


$search = isset($_GET['search']) ? $_GET['search'] : '';
$filter_column = isset($_GET['filter_column']) ? $_GET['filter_column'] : '';
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'upload_date';
$sort_order = isset($_GET['order']) && $_GET['order'] == 'asc' ? 'asc' : 'desc';

$valid_columns = ['id', 'user_id', 'upload_date', 'major', 'potok_number', 'stream', 'event'];

if (!in_array($sort_column, $valid_columns)) {
    $sort_column = 'upload_date';
}

$sql = "SELECT id, photo_path FROM photos";
$params = [];
$types = "";

if ($search && $filter_column && in_array($filter_column, $valid_columns)) {
    $sql .= " WHERE $filter_column LIKE ?";
    $params[] = "%$search%";
    $types .= "s";
}

$sql .= " ORDER BY $sort_column $sort_order";
$stmt = $conn->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
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
    <style>
        .photo-gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .photo-item {
            flex: 1 1 calc(25% - 10px);
            box-sizing: border-box;
        }
        .photo-item img {
            width: 100%;
            height: auto;
            cursor: pointer;
        }
    </style>
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
    <form method="GET" action="catalog.php">
        <label for="filter_column">Филтрирай по:</label>
        <select name="filter_column" id="filter_column">
            <option value="">Избери поле</option>
            <?php foreach ($valid_columns as $column): ?>
                <option value="<?php echo $column; ?>" <?php if ($filter_column == $column) echo 'selected'; ?>>
                    <?php echo ucfirst(str_replace('_', ' ', $column)); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search...">
        <button type="submit">Търси</button>
    </form>
    <div class="photo-gallery">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='photo-item'>";
                echo "<a href='photo_details.php?id=" . htmlspecialchars($row['id']) . "'>";
                echo "<img src='" . htmlspecialchars($row['photo_path']) . "' alt='Photo'>";
                echo "</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Няма налични снимки.</p>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
</body>
</html>
