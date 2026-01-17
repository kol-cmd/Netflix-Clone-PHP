<?php
// WAMP Local Settings
$servername = "localhost";
$username = "root";       // Default WAMP username
$password = "";           // Default WAMP password is empty
$dbname = "netflix_db";   // IMPORTANT: Change this to whatever you named your DB in phpMyAdmin

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>