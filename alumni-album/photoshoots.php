<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Фотосесии</title>
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
    <h1>Моите фотосесии</h1>
    <a href="html/request_photoshoot.html">Заяви фотосесия</a> 
    <?php
    include 'database.php';
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.html');
        exit();
    }

    $user_id = $_SESSION['user_id'];


    $stmt = $conn->prepare("SELECT session_date, status, place, type FROM sessions WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Дата на фотосесията</th><th>Адрес</th><th>Тип фотосесия</th><th>Статус</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['session_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['place']) . "</td>";
            echo "<td>" . htmlspecialchars($row['type']) . "</td>";
            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>Нямате направени фотосесии.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>
    
</body>
</html>
