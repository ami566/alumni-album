<?php
include 'database.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: html/login.html');
    exit();
}


header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=alumni_data.csv');


$query = "SELECT * FROM alumni";
$result = $conn->query($query);

$output = fopen('php://output', 'w');
fputcsv($output, array('ID', 'User ID', 'Group', 'Potok Number', 'Major', 'Graduation Year'));

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
exit();
?>
