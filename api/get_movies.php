<?php
session_start();
// Disable error printing to avoid breaking JSON
error_reporting(0); 
ini_set('display_errors', 0);

header('Content-Type: application/json');

include '../includes/db_connection.php'; // Uses your fixed connection

$movies = [];

// Select random movies (or specific ones) for the Hero section
$sql = "SELECT * FROM movies ORDER BY RAND() LIMIT 5";
$result = mysqli_query($conn, $sql);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $movies[] = $row;
    }
}

echo json_encode($movies);
?>