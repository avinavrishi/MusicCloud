<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Music</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    .container {
      max-width: 400px;
      margin: 100px auto;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
      padding: 20px;
      border-radius: 5px;
    }

    h1 {
      text-align: center;
    }

    form {
      margin-top: 20px;
    }

    input[type="submit"] {
      width: 100%;
    }
  </style>
</head>
<body>
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

<div class="container">


  <h1>Add Music</h1>

  <!-- Add Music Form -->
  <form action="add_music.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="form-group">
      <label for="artist">Artist:</label>
      <input type="text" class="form-control" id="artist" name="artist" required>
    </div>
    <div class="form-group">
      <label for="genre">Genre:</label>
      <input type="text" class="form-control" id="genre" name="genre" required>
    </div>
    <div class="form-group">
      <label for="album">Album:</label>
      <input type="text" class="form-control" id="album" name="album">
    </div>
    <div class="form-group">
      <label for="release_date">Release Date:</label>
      <input type="date" class="form-control" id="release_date" name="release_date">
    </div>
    <div class="form-group">
      <label for="cover_image">Cover Image:</label>
      <input type="file" class="form-control" id="cover_image" name="cover_image">
    </div>
    <div class="form-group">
      <label for="file_path">File Path:</label>
      <input type="file" class="form-control" id="file_path" name="file_path">
    </div>
    <input type="submit" class="btn btn-primary" value="Add Music">
  </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
