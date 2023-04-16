<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

    <div class="container mt-5">
        <h2>Music Items</h2>
        <a href="add_musicitem.php">Add</a>
        
        
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Artist</th>
                    <th>Genre</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include your database connection and functions.php file here
                include('db_connect.php');
                include('functions.php');

                // Fetch all music items from the database
                $musicItems = getMusicItems();

                // Loop through each music item and display as list item
                foreach ($musicItems as $musicItem) {
                    echo '<tr>';
                    echo '<td>' . $musicItem['title'] . '</td>';
                    echo '<td>' . $musicItem['artist'] . '</td>';
                    echo '<td>' . $musicItem['genre'] . '</td>';
                    echo '<td>
                            <a href="view_music.php?id=' . $musicItem['music_id'] . '" class="btn btn-primary btn-sm">View</a>
                            <a href="edit_music.php?id=' . $musicItem['music_id'] . '" class="btn btn-secondary btn-sm">Edit</a>
                            <a href="delete_music.php?id=' . $musicItem['music_id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this music item?\')">Delete</a>
                          </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
