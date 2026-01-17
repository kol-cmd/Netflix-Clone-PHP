<?php
session_start();
include '../includes/db_connection.php';
if (!isset($_SESSION['user_id'])) die("Unauthorized");

// SECURITY: Only allow these specific images
$allowed_avatars = [
    'AAAABQYlg7rw1jw8D4qZVkZSRxxRxXOwsY6wiZLThDOU9YkDTz8PyAUd1_98emUrSzgoPSTjDiMgattAyGUJoEnjCeNkH-3rlvE4Tg.png',
    '✨my history teacher✨.jpeg',
    'movie board.jpeg',
    'Player 456.jpeg',
    'kids.jpg',
    'avatar1.png', 
    'avatar2.png'
];

$userId = $_SESSION['user_id'];
$name = $_POST['profile_name']; // No need for manual escape when using prepare()
$img = $_POST['profile_img'];

if (empty($name)) die("Name Required");

// Verify the image is in our allowed list
if (!in_array($img, $allowed_avatars)) {
    // Ideally, uncomment the line below to strictly enforce this
    die("Invalid Image"); 
}

// --- SECURE INSERT (Prepared Statement) ---
// We use ? placeholders instead of putting variables directly in the query
$stmt = $conn->prepare("INSERT INTO profiles (user_id, profile_name, profile_img) VALUES (?, ?, ?)");

// "iss" stands for: Integer (user_id), String (name), String (img)
$stmt->bind_param("iss", $userId, $name, $img);

if ($stmt->execute()) {
    echo "Success";
} else {
    // Log the error for yourself, but just say "Error" to the user
    error_log("Profile Error: " . $stmt->error);
    echo "Error";
}

$stmt->close();
?>