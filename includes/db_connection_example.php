<?php
// WAMP Local Settings
$servername = "localhost";
$username = "YOUR_DB_USER";    // Default username
$password = "YOUR_DB_PASSWORD";           // Default  password 
$dbname = "netflix_db";   // IMPORTANT: Change this to whatever you named your DB in phpMyAdmin

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?> 