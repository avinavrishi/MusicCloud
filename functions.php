<?php
// functions.php
require_once 'db_connect.php';
// Function to get all music items from the database
function getMusicItems() {
    // Include your database connection file
    include('db_connect.php');

    // Query to retrieve music items from the database
    $sql = "SELECT * FROM musicitems";
    $result = $conn->query($sql);

    // Check if query is successful
    if ($result) {
        // Fetch all rows as an associative array
        $musicItems = $result->fetch_all(MYSQLI_ASSOC);
        return $musicItems;
    } else {
        // Return empty array if query fails
        return array();
    }
}

// function to handle file upload
function uploadFile($fileInputName) {
  $targetDir = "uploads/"; // specify the target directory for file uploads
  $fileName = basename($_FILES[$fileInputName]["name"]); // get the name of the uploaded file
  $targetFilePath = $targetDir . $fileName; // get the target file path

  // Check if file already exists
  if (file_exists($targetFilePath)) {
    echo "File already exists.";
    return "";
  }

  // Check file size (optional)
  /*if ($_FILES[$fileInputName]["size"] > 500000) {
    echo "File is too large.";
    return "";
  }*/

  // Allow certain file formats (optional)
  $allowedFileTypes = array("jpg", "jpeg", "png", "mp3"); // specify allowed file types
  $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
  if (!in_array($fileType, $allowedFileTypes)) {
    echo "Invalid file type. Allowed file types are: jpg, jpeg, png, mp3.";
    return "";
  }

  // Upload file
  if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFilePath)) {
    
    return $fileName;
  } else {
    echo "Error uploading file.";
    return "";
  }
}

// Function to get music item by ID
function getMusicById($musicId)
{
    // Create a new database connection
    include('db_connect.php');

    // Prepare the SQL statement with a placeholder for the music ID
    $stmt = $conn->prepare("SELECT * FROM musicitems WHERE music_id = ?");
    $stmt->bind_param("i", $musicId); // Bind the music ID to the placeholder
    $stmt->execute(); // Execute the SQL statement
    $result = $stmt->get_result(); // Get the result set

    // Fetch the music item data from the result set
    $musicItem = $result->fetch_assoc();

    // Close the database connection
    $stmt->close();
    $conn->close();

    // Return the music item data
    return $musicItem;
}



// Function to update music item
function updateMusic($musicId, $title, $artist, $genre, $album, $releaseDate, $coverImage, $filePath)
{
    // Create a new database connection
    include('db_connect.php');

    // Prepare the SQL statement with placeholders for the music item data
    $stmt = $conn->prepare("UPDATE musicitems SET title = ?, artist = ?, genre = ?, album = ?, release_date = ?, cover_image = ?, file_path = ? WHERE music_id = ?");
    $stmt->bind_param("sssssssi", $title, $artist, $genre, $album, $releaseDate, $coverImage, $filePath, $musicId); // Bind the music item data to the placeholders
    $stmt->execute(); // Execute the SQL statement

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        // Music item updated successfully
        $stmt->close();
        $conn->close();
        return true;
    } else {
        // Music item update failed
        $stmt->close();
        $conn->close();
        return false;
    }
}
// functions.php

// Delete music record from database by ID
// functions.php

// Delete music record from database by ID
function deleteMusicById($music_id)
{
    include('db_connect.php');
    
    // Delete corresponding records from playlistitems table
    $stmt = $conn->prepare("DELETE FROM playlistitems WHERE music_id = ?");
    $stmt->bind_param("i", $music_id);
    $stmt->execute();
    
    // Prepare and bind the DELETE statement
    $stmt = $conn->prepare("DELETE FROM musicitems WHERE music_id = ?");
    $stmt->bind_param("i", $music_id);
    
    // Execute the DELETE statement
    if ($stmt->execute()) {
        // Delete successful
        return true;
    } else {
        // Delete failed
        return false;
    }
    
    // Close statement
    $stmt->close();
}

//get comment by music id

function getCommentsByMusicId($music_id, $parent_comment_id = null) {
    global $conn;
    $comments = array();

    $sql = "SELECT comments.comment_id, comments.user_id, comments.comment_text, comments.comment_date, users.username 
            FROM comments
            INNER JOIN users ON comments.user_id = users.user_id
            WHERE comments.music_id = ? AND comments.parent_comment_id " . ($parent_comment_id ? "= $parent_comment_id" : "IS NULL") . "
            ORDER BY comments.comment_date ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $music_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $comment = array(
            'comment_id' => $row['comment_id'],
            'user_id' => $row['user_id'],
            'username' => $row['username'],
            'comment_text' => $row['comment_text'],
            'comment_date' => $row['comment_date']
        );

        // Fetch and append replies to comments
        $comment['replies'] = getCommentsByMusicId($music_id, $comment['comment_id']);

        $comments[] = $comment;
    }
    $stmt->close();

    return $comments;
}




?>

