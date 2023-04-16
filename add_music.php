<!-- add_music.php -->

<?php
// Include the database connection and functions file
require_once 'db_connect.php'; // Update this with your own file name
require_once 'functions.php'; // Update this with your own file name

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $title = $_POST['title'];
  $artist = $_POST['artist'];
  $genre = $_POST['genre'];
  $album = $_POST['album'];
  $release_date = $_POST['release_date'];
  
  // Upload cover image and file
  $cover_image = uploadFile('cover_image'); // Update this with your own function to handle file uploads
  $file_path = uploadFile('file_path'); // Update this with your own function to handle file uploads
  
  // Insert new music item into the music items table
  $query = "INSERT INTO musicitems (title, artist, genre, album, release_date, cover_image, file_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("sssssss", $title, $artist, $genre, $album, $release_date, $cover_image, $file_path);
  if ($stmt->execute()) {
    // Display success message
    echo "Music item added successfully!";
    header("Location: admin_dashboard.php");
  } else {
    // Display error message
    echo "Error adding music item: " . $stmt->error;
  }
  
  // Close statement and connection
  $stmt->close();
  $conn->close();
}
?>
