<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $photo_id = $_POST['photo_id'];
    $order_type = $_POST['order_type'];


    $stmt = $conn->prepare("INSERT INTO orders (user_id, photo_id, order_type, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iis", $user_id, $photo_id, $order_type);

    if ($stmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    header('Location: orders.php');
    exit();
} else {
    header('Location: catalog.php');
    exit();
}
?>
