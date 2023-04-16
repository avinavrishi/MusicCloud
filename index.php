<!DOCTYPE html>
<html>
<head>
    <title>MusicHub</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file -->
</head>
<body>
    <!-- Header section with logo, site name, and navigation menu -->
    <header>
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


    </header>
    <main>
        <div class="container">
            <h1>Welcome to MusicHub</h1>
            <div class="row">
                <div class="col-md-12">
                    <h2>Latest Music</h2>
                    <!-- Display latest music items from the database -->
                    <?php
                        // Connect to your database
                        require_once 'db_connect.php';

                        // Fetch latest music items from the database
                        $sql = "SELECT * FROM musicitems ORDER BY release_date DESC LIMIT 10";
                        $result = mysqli_query($conn, $sql);

                        // Display latest music items
                        if (mysqli_num_rows($result) > 0) {
                            echo "<div class='row'>";
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<div class='col-md-3'>";
                                echo "<div class='card'>";
                                echo "<img src='uploads/" . $row["cover_image"] . "' alt='" . $row["title"] . "' class='card-img-top'>";
                                echo "<div class='card-body'>";
                                echo "<h5 class='card-title'>" . $row["title"] . "</h5>";
                                echo "<p class='card-text'>Artist: " . $row["artist"] . "</p>";
                                echo "<p class='card-text'>Album: " . $row["album"] . "</p>";
                                echo "<p class='card-text'>Genre: " . $row["genre"] . "</p>";
                                echo "<p class='card-text'>Release Date: " . $row["release_date"] . "</p>";
                                echo '<a href="view_music.php?id=' . $row['music_id'] . '" class="btn btn-primary btn-sm">View</a>';
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                            echo "</div>";
                        } else {
                        echo "<p>No music items found.</p>";
                        }
                                            // Close database connection
                    mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
</main>

<!-- Content Section -->
<section class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <h2>Welcome to MusicHub</h2>
            <p>
                MusicHub is your ultimate destination for discovering and enjoying your favorite music! With a vast collection of songs from various genres and artists, MusicHub offers a seamless listening experience that caters to all music enthusiasts.
            </p>
            <p>
                Whether you're into rock, pop, hip-hop, electronic, classical, or any other genre, MusicHub has something for everyone. Our easy-to-use interface allows you to search for your favorite songs, create playlists, and customize your listening experience to suit your mood and preferences.
            </p>
            <p>
                Join MusicHub today and embark on a musical journey like never before. Discover new artists, revisit old favorites, and immerse yourself in the world of music with MusicHub!
            </p>
        </div>
        <div class="col-md-6">
            <img src="https://cdn.dribbble.com/users/2760285/screenshots/12019007/dribbble_1.png" alt="MusicHub Homepage Image" class="img-fluid">
        </div>
    </div>
</section>
<!-- End Content Section -->

<footer style="background-color: #222; color: #fff; padding: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>Contact Us</h5>
                <p>Email: info@musichub.com</p>
                <p>Phone: +1-123-456-7890</p>
                <p>Address: 123 Music Avenue, City, State ZIP</p>
            </div>
            <div class="col-md-6">
                <h5>Follow Us</h5>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                    <li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.15.6/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>