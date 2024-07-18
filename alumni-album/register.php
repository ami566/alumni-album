<?php
    include 'database.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $role = $_POST['role'];

    $group_number = isset($_POST['group_number']) ? (int)$_POST['group_number'] : null;
    $potok_number = isset($_POST['potok_number']) ? (int)$_POST['potok_number'] : null;
    $major = isset($_POST['major']) ? $_POST['major'] : null;
    $graduation_year = isset($_POST['graduation_year']) ? (int)$_POST['graduation_year'] : null;


    $stmt = $conn->prepare("INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $password, $email, $role);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        if ($role == 'alumni') {
            $alumni_stmt = $conn->prepare("INSERT INTO alumni (user_id, group_number, potok_number, major, graduation_year) VALUES (?, ?, ?, ?, ?)");
            $alumni_stmt->bind_param("iiisi", $user_id, $group_number, $potok_number, $major, $graduation_year);
            if ($alumni_stmt->execute()) {
                header('Location: html/login.html');
                exit();
            } else {
                echo "Error: " . $alumni_stmt->error;
            }
            $alumni_stmt->close();
        } else {
            header('Location: html/login.html');
            exit();
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
