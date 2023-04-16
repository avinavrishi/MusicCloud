<?php
session_start();
// Include the necessary files
require_once 'db_connect.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $music_id = $_POST['music_id'];
    $user_id = $_SESSION['user_id'];
    $comment_text = $_POST['comment'];
    $parent_comment_id = isset($_POST['parent_comment_id']) ? $_POST['parent_comment_id'] : null; // Get parent comment ID if provided

    // Insert the comment into the database
    $sql = "INSERT INTO comments (user_id, music_id, comment_text, parent_comment_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $user_id, $music_id, $comment_text, $parent_comment_id);
    if ($stmt->execute()) {
        // Comment added successfully
        header("Location: view_music.php?id=" . $music_id); // Redirect back to music details page
        exit();
    } else {
        // Error adding comment
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close database connection
$conn->close();
?>
