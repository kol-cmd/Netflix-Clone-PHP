<?php
session_start();

// --- CRITICAL FIX: TURN OFF HTML ERROR REPORTING ---
// This prevents the "<br /><b>" error text from breaking your JSON
error_reporting(0); 
ini_set('display_errors', 0);

// Force the browser to read this as JSON
header('Content-Type: application/json');

include '../includes/db_connection.php';

// 1. Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]); // Return empty list
    exit;
}



$userId = $_SESSION['user_id'];
$myList = [];

// SECURE QUERY (Prepared Statement)
$sql = "SELECT movies.* FROM notes 
        JOIN movies ON notes.movie_id = movies.id 
        WHERE notes.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId); // "i" means integer
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $myList[] = $row;
}

echo json_encode($myList);