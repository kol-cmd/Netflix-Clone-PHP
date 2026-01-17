<?php
session_start();

// FIX 1: Point to the 'includes' folder (Go up one level with ../)
include '../includes/db_connection.php';

// Get POST data securely
$email = $_POST['email'];
$password = $_POST['password'];
$action = $_POST['action'];

if ($action == 'signup') {
    // 1. SECURE CHECK: Does user exist?
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email); 
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // FIX 2: Redirect path needs '../' to go back to root
        echo "<script>alert('Email already registered!'); window.location.href='../login.php';</script>";
    } else {
        // 2. HASH PASSWORD
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // 3. SECURE INSERT
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashed_password);

        if ($stmt->execute()) {
            $new_user_id = $stmt->insert_id;
            $_SESSION['user_id'] = $new_user_id; 
            $_SESSION['user'] = $email;          
            
            // FIX 3: Redirect to Root index.php
            header("Location: ../index.php"); 
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
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $email;      
            $_SESSION['user_id'] = $user['id']; 
            
            // FIX 4: Redirect to Root index.php
            header("Location: ../index.php");
            exit();
        } else {
            // Wrong Password - FIX path
            echo "<script>alert('Invalid Password!'); window.location.href='../login.php';</script>";
        }
    } else {
        // User not found - FIX path
        echo "<script>alert('Email not found!'); window.location.href='../login.php';</script>";
    }
    $stmt->close();
}

$conn->close();
?>