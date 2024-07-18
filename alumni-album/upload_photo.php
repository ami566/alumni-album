<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: html/login.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo'])) {
    $user_id = $_SESSION['user_id'];
    $photo = $_FILES['photo'];
    $event = $_POST['Event'];
    $potok = $_POST['Potok'];
    $major = $_POST['Major'];
    $group = $_POST['Group'];
    $upload_dir = 'uploads/';
    $file_name = basename($photo['name']);
    $target_file = $upload_dir . $file_name;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($photo['tmp_name'], $target_file)) {

        $stmt = $conn->prepare("INSERT INTO photos (user_id, photo_path, event, potok_number, major, stream) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issisi", $user_id, $target_file, $event, $potok, $major, $group);

        if ($stmt->execute()) {
            header('Location: catalog2.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
} else {
    header('Location: catalog2.php');
}
?>
