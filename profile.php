<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
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
    <?php
    require_once 'db_connect.php'; // Include the database connection file

    // Check if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Retrieve user profile information from Profiles table based on user ID
        $sql = "SELECT p.*, u.username, u.email FROM profiles p
                INNER JOIN users u ON p.user_id = u.user_id
                WHERE u.user_id = ?";
                
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            ?>
            <div class="row mt-4">
                <div class="col-md-4">
                    <img src="uploads/<?php echo $row['profile_picture']; ?>" alt="Profile Picture" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <h4>Username: <?php echo $row['username']; ?></h4>
                    <p>Email: <?php echo $row['email']; ?></p>
                    <p>Full Name: <?php echo $row['full_name']; ?></p>
                    <p>Age: <?php echo $row['age']; ?></p>
                    <p>Gender: <?php echo $row['gender']; ?></p>
                    <p>Bio: <?php echo $row['bio']; ?></p>
                </div>
            </div>
            <?php
        } else {
            echo "No profile found.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "User not logged in.";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
