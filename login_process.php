<?php
// Start session
session_start();

// Include database connection
require_once 'db_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and password from form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to check if email and password match
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    
    // Bind email parameter
    $stmt->bind_param("s", $email);

    // Execute query
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();
    
    // Fetch row
    $user = $result->fetch_assoc();

    // Check if email and password match
    if ( $user['email'] == $email && $user['password'] == $password ) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['is_admin'] = $user['is_admin'];

        // Redirect to home page or dashboard based on user's role
        if ($user['is_admin']) {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        // Redirect to login page with error message
        echo "Email and password do not match"; // Echo the error message
        header("Location: login.php?error=1");
        exit;
    }
}
?>
