<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: catalog.php');
    exit();
}

$photo_id = $_GET['id'];


$stmt = $conn->prepare("SELECT * FROM photos WHERE id = ?");
$stmt->bind_param("i", $photo_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p>Photo not found.</p>";
    exit();
}

$photo = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_type = $_POST['order_type'];
    $user_id = $_SESSION['user_id'];

    $order_stmt = $conn->prepare("INSERT INTO orders (user_id, photo_id, order_type, status) VALUES (?, ?, ?, 'pending')");
    $order_stmt->bind_param("iis", $user_id, $photo_id, $order_type);

    if ($order_stmt->execute()) {
        echo "<p>Order placed successfully!</p>";
    } else {
        echo "<p>Error placing order: " . $order_stmt->error . "</p>";
    }

    $order_stmt->close();
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
    <title>Детайли за снимката</title>
    <style>
        .photo-details img {
            width: 100%;
            height: auto;
        }
        .photo-info {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav class="menu menu-2">
        <ul>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="catalog.php">Catalogue</a></li> 
            <li><a href="photoshoots.php">Photoshoots</a></li>
            <li><a href="orders.php">Orders</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <h1>Детайли за снимката</h1>
    <div class="photo-details">
        <img src="<?php echo htmlspecialchars($photo['photo_path']); ?>" alt="Photo">
        <div class="photo-info">
            <p><strong>ID:</strong> <?php echo htmlspecialchars($photo['id']); ?></p>
            <p><strong>User ID:</strong> <?php echo htmlspecialchars($photo['user_id']); ?></p>
            <p><strong>Upload Date:</strong> <?php echo htmlspecialchars($photo['upload_date']); ?></p>
            <p><strong>Major:</strong> <?php echo htmlspecialchars($photo['major']); ?></p>
            <p><strong>Potok Number:</strong> <?php echo htmlspecialchars($photo['potok_number']); ?></p>
            <p><strong>Stream:</strong> <?php echo htmlspecialchars($photo['stream']); ?></p>
            <p><strong>Event:</strong> <?php echo htmlspecialchars($photo['event']); ?></p>
          
        </div>
        <div class="order-form">
            <h2>Order this photo</h2>
            <form action="photo_details.php?id=<?php echo htmlspecialchars($photo_id); ?>" method="POST">
                <label for="order_type">Order Type:</label>
                <select name="order_type">
                    <option value="album">Album</option>
                    <option value="card">Card</option>
                    <option value="calendar">Calendar</option>
                    <option value="mug">Mug</option>
                    <option value="bridge_card">Bridge Cards</option>
                    <option value="frame">Frame</option>
                </select>
                <button type="submit">Submit Order</button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
