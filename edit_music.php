<?php
// Include db_connect.php and functions.php
require_once('db_connect.php');
require_once('functions.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get music data from form
  $id = $_POST['id'];
  $title = $_POST['title'];
  $artist = $_POST['artist'];
  $genre = $_POST['genre'];
  $album = $_POST['album'];
  $release_date = $_POST['release_date'];
  $cover_image = $_POST['cover_image'];
  $file_path = $_POST['file_path'];

  // Update music data in the database
  $result = updateMusic($id, $title, $artist, $genre, $album, $release_date, $cover_image, $file_path);

  // Check if update was successful
  if ($result) {
    // Redirect to dashboard with success message
    header('Location: admin_dashboard.php?success=1');
    exit;
  } else {
    // Redirect to dashboard with error message
    header('Location: admin_dashboard.php?error=1');
    exit;
  }
}

// Get music ID from query string
$id = $_GET['id'];

// Get music data from database
$music = getMusicById($id);

// Check if music exists
if (!$music) {
  // Redirect to dashboard with error message
  header('Location: admin_dashboard.php?error=2');
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Music</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
   <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">MusicHub</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto"> <!-- Updated to mx-auto to center align the list -->
            
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="search.php">Search</a>
            </li>
           
        </ul>
        <ul class="navbar-nav ml-auto">
            <?php
            session_start();
            // Check if user is logged in
            if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
                // User is logged in, display welcome and logout option
                echo '<li class="nav-item">
                        <a class="nav-link" href="profile.php">Welcome ' . $_SESSION['username'] . '</a>
                      </li>';
                echo '<li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                      </li>';

                if ($_SESSION['is_admin'] == 1) {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="admin_dashboard.php">Admin</a>
                          </li>';
                }
            } else {
                // User is not logged in, display login and signup option
                echo '<li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                      </li>';
                echo '<li class="nav-item">
                        <a class="nav-link" href="signup.php">Signup</a>
                      </li>';
            }
            ?>
        </ul>
    </div>
</nav>


  <h1>Edit Music</h1>

  <!-- Edit Music Form -->
  <form action="edit_music.php" method="post">
  <input type="hidden" name="id" value="<?php echo $music['music_id']; ?>">
  <div class="form-group">
    <label for="title">Title:</label>
    <input type="text" class="form-control" id="title" name="title" value="<?php echo $music['title']; ?>" required>
  </div>
  <div class="form-group">
    <label for="artist">Artist:</label>
    <input type="text" class="form-control" id="artist" name="artist" value="<?php echo $music['artist']; ?>" required>
  </div>
  <div class="form-group">
    <label for="genre">Genre:</label>
    <input type="text" class="form-control" id="genre" name="genre" value="<?php echo $music['genre']; ?>" required>
  </div>
  <div class="form-group">
    <label for="album">Album:</label>
    <input type="text" class="form-control" id="album" name="album" value="<?php echo $music['album']; ?>">
  </div>
  <div class="form-group">
    <label for="release_date">Release Date:</label>
    <input type="date" class="form-control" id="release_date" name="release_date" value="<?php echo $music['release_date']; ?>">
  </div>
  <div class="form-group">
    <label for="cover_image">Cover Image:</label>
    <input type="file" class="form-control" id="cover_image" name="cover_image" value="<?php echo $music['cover_image']; ?>">
  </div>
  <div class="form-group">
    <label for="file_path">File Path:</label>
    <input type="file" class="form-control" id="file_path" name="file_path" value="<?php echo $music['file_path']; ?>">
  </div>
  <input type="submit" class="btn btn-primary" value="Update Music">
  <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
</form>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>

