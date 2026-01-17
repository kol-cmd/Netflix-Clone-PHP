<?php
session_start();
include '../includes/db_connection.php';

if (!isset($_SESSION['user_id'])) die("[]");

$userId = $_SESSION['user_id'];
$profiles = [];

$sql = "SELECT * FROM profiles WHERE user_id = '$userId'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    $profiles[] = $row;
}

echo json_encode($profiles);
?>