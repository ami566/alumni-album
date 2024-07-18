<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: html/login.html');
    exit();
}
$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="styles/style.css">
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
    <h1>Моят профил</h1>
    <p>Потребителско име: <?php echo htmlspecialchars($username); ?></p>
    <p>Имейл: <?php echo htmlspecialchars($email); ?></p>


    <a href="html/request_photoshoot.html">Request Photoshoot</a> | 
    <a href="export_data.php">Export Data</a> | 
    <a href="logout.php">Logout</a>
</body>
</html>
