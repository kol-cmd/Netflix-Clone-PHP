<?php
session_start();
include '../includes/db_connection.php';

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $profileId = $_GET['id'];
    $userId = $_SESSION['user_id'];

    // 1. Prepare a Secure Statement
    // We check: Does a profile exist with THIS ID and THIS User ID?
    $stmt = $conn->prepare("SELECT profile_img FROM profiles WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $profileId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // 2. Match Found: It's safe to switch
        $_SESSION['active_profile_id'] = $profileId;
        $_SESSION['active_profile_img'] = $row['profile_img'];
        echo "Success";
    } else {
        // 3. No Match: The profile belongs to someone else (or doesn't exist)
        // Do NOT update the session.
        exit("Error: Unauthorized Access");
    }
}
?>