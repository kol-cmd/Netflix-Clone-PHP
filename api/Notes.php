<?php
session_start();
include '../includes/db_connection.php';

if (!isset($_SESSION['user_id'])) {
    die("Error: Not logged in");
}

if (isset($_POST['movie_id'])) {
    $userId = $_SESSION['user_id'];
    $movieId = $_POST['movie_id'];

    // Check if already in list
    $check = mysqli_query($conn, "SELECT * FROM notes WHERE user_id='$userId' AND movie_id='$movieId'");
    
    if (mysqli_num_rows($check) > 0) {
        echo "Already in list";
    } else {
        $sql = "INSERT INTO notes (user_id, movie_id) VALUES ('$userId', '$movieId')";
        if (mysqli_query($conn, $sql)) {
            echo "Success";
        } else {
            echo "Error";
        }
    }
}
?>