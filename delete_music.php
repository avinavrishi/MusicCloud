<?php
// Include necessary files
require_once 'db_connect.php';
require_once 'functions.php';

// Check if music ID is provided
if (isset($_GET['id'])) {
    $music_id = $_GET['id'];
    
    // Delete music record from database
    if (deleteMusicById($music_id)) {
        // Redirect to admin dashboard with success message
        header("Location: admin_dashboard.php?message=success&content=Music deleted successfully.");
        exit();
    } else {
        // Redirect to admin dashboard with error message
        header("Location: admin_dashboard.php?message=error&content=Failed to delete music. Please try again.");
        exit();
    }
} else {
    // Redirect to admin dashboard with error message
    header("Location: admin_dashboard.php?message=error&content=Invalid request. Music ID not provided.");
    exit();
}
?>
