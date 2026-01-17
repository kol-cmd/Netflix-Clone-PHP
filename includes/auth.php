<?php
session_start();
include 'db_connection.php';

// Get POST data securely
$email = $_POST['email'];
$password = $_POST['password'];
$action = $_POST['action'];

if ($action == 'signup') {
    // 1. SECURE CHECK: Does user exist?
    // We use '?' placeholders instead of putting variables directly in query
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); // "s" means String
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already registered!'); window.location.href='login.php';</script>";
    } else {
        // 2. HASH PASSWORD (CRITICAL SECURITY)
        // Never store plain text passwords. This converts "password123" into a secure code.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 3. SECURE INSERT
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password);

        if ($stmt->execute()) {
            // Success: Log them in and redirect
            // Ideally, you should store the ID in session too
            $new_user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $new_user_id; // Good for 'My List' feature
            $_SESSION['user'] = $email;          // Keep your existing session logic
            
            header("Location: index.php"); 
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();

} else { // LOGIN LOGIC
    // 1. SECURE SELECT
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // 2. VERIFY HASHED PASSWORD
        // We check if the password they typed matches the encrypted hash in DB
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $email;      // Keep your existing logic
            $_SESSION['user_id'] = $user['id']; // Add ID for 'My List' to work!
            
            header("Location: index.php");
            exit();
        } else {
            // Wrong Password
            echo "<script>alert('Invalid Password!'); window.location.href='login.php';</script>";
        }
    } else {
        // User not found
        echo "<script>alert('Email not found!'); window.location.href='login.php';</script>";
    }
    $stmt->close();
}

$conn->close();
?>