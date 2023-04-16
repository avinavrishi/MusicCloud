<?php
require_once 'db_connect.php'; // Include the database connection file
require_once 'functions.php';
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check if profile picture is uploaded
    if (isset($_FILES["profile_picture"])) {
        // Upload profile picture
        $profilePicture = uploadFile("profile_picture");
    } else {
        echo "Profile picture is required.";
        exit;
    }

    // Insert user data into Users table
    $sql = "INSERT INTO users (username, email, password, profile_picture) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $password, $profilePicture);
    if (mysqli_stmt_execute($stmt)) {
        $userId = mysqli_insert_id($conn); // Get the auto-generated user ID
        // Create user profile
        $profileSql = "INSERT INTO profiles (user_id, bio) VALUES (?, '')"; // Assumes the profiles table has a user_id column and a bio column
        $profileStmt = mysqli_prepare($conn, $profileSql);
        mysqli_stmt_bind_param($profileStmt, "i", $userId);
        if (mysqli_stmt_execute($profileStmt)) {
            echo "User registered successfully.";
            // Redirect to login page or profile page
            // header("Location: login.php"); // Uncomment this line to redirect to login page
            // header("Location: profile.php"); // Uncomment this line to redirect to profile page
            exit;
        } else {
            echo "Error creating user profile: " . mysqli_error($conn);
        }
        mysqli_stmt_close($profileStmt);
    } else {
        echo "Error registering user: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>