<!DOCTYPE html>
<html>
<head>
    <title>Music Hub - Search</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
    margin-top: 50px;
    max-width: 800px;
}

.music-item {
    margin: 10px;
    padding: 10px;
    background-color: #f8f9fa;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
}

.grid-view {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.grid-view .music-item {
    flex: 0 0 calc(25% - 20px);
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
        <h1 class="text-center">Music Hub - Search</h1>
        <form action="search.php" method="POST">
            <div class="form-group">
                <input type="text" name="keywords" placeholder="Enter keywords to search for music" class="form-control">
            </div>
            <input type="submit" value="Search" class="btn btn-primary">
        </form>

        <?php
        // Check if the form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Get the search keywords from the form submission
            $keywords = $_POST['keywords'];

            include('db_connect.php');

            // Prepare the SQL query to search for music based on keywords
            // You would need to modify the query based on your specific schema
            $query = "SELECT * FROM musicitems WHERE title LIKE '%$keywords%' OR artist LIKE '%$keywords%' OR genre LIKE '%$keywords%' OR album LIKE '%$keywords%'";
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                // Display the search results in a grid view
                echo "<h2 class='text-center'>Search Results</h2>";
                echo "<div class='grid-view'>";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='music-item'>";
                    echo "<img src='uploads/" . $row['cover_image'] . "' alt='" . $row['title'] . "' class='img-fluid'>";
                    echo "<h3>" . $row['title'] . "</h3>";
                    echo "<p>Artist: " . $row['artist'] . "</p>";
                    echo "<p>Genre: " . $row['genre'] . "</p>";
                    echo '<a href="view_music.php?id=' . $row['music_id'] . '" class="btn btn-primary btn-sm">View</a>';
                    // Add other relevant information and preview option as needed
                    echo "</div>";
                }
                echo "</div>";
            } else {
                // Handle error if the query fails
                echo "Error occurred while searching for music: " . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
        }
        ?>

    </div>
    <div class="container mt-5">
    <h1>Music Playlist - Music Hub</h1>

    <?php
    // Include database connection and query for music items
    include('db_connect.php');

    // Prepare the SQL query to retrieve unique genres from musicitems table
    // You would need to modify the query based on your specific schema and table names
    $query = "SELECT DISTINCT genre FROM musicitems";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Loop through each genre and display music items in separate rows
        while ($row = mysqli_fetch_assoc($result)) {
            $genre = $row['genre'];
            echo "<h3 class='mt-4'>" . $genre . "</h3>";
            echo "<div class='card-columns'>";
            // Prepare another SQL query to retrieve music items based on genre
            $query2 = "SELECT * FROM musicitems WHERE genre = '$genre'";
            $result2 = mysqli_query($conn, $query2);
            if ($result2) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    echo "<div class='card'>";
                    echo "<img src='uploads/" . $row2['cover_image'] . "' alt='" . $row2['title'] . "' class='card-img-top'>";
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . $row2['title'] . "</h5>";
                    echo "<p class='card-text'>Artist: " . $row2['artist'] . "</p>";
                    echo "<p class='card-text'>Album: " . $row2['album'] . "</p>";
                    echo "<p class='card-text'>Release Date: " . $row2['release_date'] . "</p>";
                    echo '<a href="view_music.php?id=' . $row2['music_id'] . '" class="btn btn-primary btn-sm">View</a>';
                    // Add other relevant information and preview option as needed
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                // Handle error if the query fails
                echo "Error occurred while retrieving music items for genre '$genre': " . mysqli_error($conn);
            }
            echo "</div>";
        }
    } else {
        // Handle error if the query fails
        echo "Error occurred while retrieving unique genres: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

</body>
</html>
