<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: html/login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $session_date = $_POST['session_date'];
    $place = $_POST['place'];
    $type = $_POST['type'];


    $stmt = $conn->prepare("INSERT INTO sessions (user_id, session_date, place, type, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("isss", $user_id, $session_date, $place, $type);

    if ($stmt->execute()) {
        header('Location: photoshoots.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
