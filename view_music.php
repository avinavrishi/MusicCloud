<!DOCTYPE html>
<html>
<head>
    <title>View Music</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #222;
            color: #fff;
        }
        
       
        .col-md-6 {
            margin-top: 30px;
        }
        .col-md-6 img {
            max-height: 300px;
            margin-top: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
        }
        .btn-secondary {
            margin-top: 30px;
        }

        .comment {
              margin-bottom: 15px;
              padding: 10px;
            
              border: 1px solid #dee2e6;
              border-radius: 5px;
            }

            .comment p {
              margin-bottom: 5px;
            }

            .replies {
              margin-top: 10px;
              margin-left: 20px;
              list-style-type: none;
            }

            .reply-form textarea {
              margin-top: 10px;
            }

            .main-comment-form textarea {
              margin-top: 10px;
            }

            .main-comment-form button {
              margin-top: 10px;
            }

    </style>
</head>
<body>
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

    <div class="container">
        
        <?php
        // Include db_connect.php and functions.php to establish database connection and use functions
        require_once 'db_connect.php';
        require_once 'functions.php';
        
        // Get music record by ID
        $music_id = $_GET['id'];
        $music = getMusicById($music_id);
        
        if (!$music) {
            echo '<div class="alert alert-danger">Failed to retrieve music record.</div>';
        } else {
            ?>
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="uploads/<?php echo $music['cover_image']; ?>" alt="Cover Image" class="img-fluid mx-auto d-block">

                    <h4><?php echo $music['title']; ?></h4>
                    <p><strong>Artist: </strong><?php echo $music['artist']; ?></p>
                    <p><strong>Genre: </strong><?php echo $music['genre']; ?></p>
                    <p><strong>Album: </strong><?php echo $music['album']; ?></p>
                    <p><strong>Release Date: </strong><?php echo $music['release_date']; ?></p>

                    
                    <audio controls style="width: 100%;">
                        <source src="uploads/<?php echo $music['file_path']; ?>" type="audio/mp3">
                        Your browser does not support the audio element.
                    </audio>


                </div>

             

                <div class="col-md-6" style="max-height: 600px; overflow-y: auto;" id = "comment-section">
                    
                    <h4>Comments</h4>
                        <?php
                    require_once 'functions.php';
                    // Fetch comments for the given music_id from the database
                    $comments = getCommentsByMusicId($music_id);
                    if (!$comments) {
                        echo '<p>No comments yet.</p>';
                    } else {
                        foreach ($comments as $comment) {
                            echo '<div class="comment">';
                            echo '<p><strong>' . $comment['username'] . '</strong>: ' . $comment['comment_text'] . '</p>';
                            echo '<a href="#" class="reply-link">Reply</a>'; // Add Reply link
                            echo '<div class="reply-form-container" style="display:none;">'; // Add container for reply form with initial display none
                            // Display reply form for each comment
                            echo '<form method="post" action="add_comment.php" class="reply-form">';
                            echo '<input type="hidden" name="music_id" value="' . $music_id . '">';
                            echo '<input type="hidden" name="parent_comment_id" value="' . $comment['comment_id'] . '">'; // Include parent comment ID
                            echo '<textarea name="comment" class="form-control" placeholder="Write a reply" rows="2"></textarea>';
                            echo '<button type="submit" class="btn btn-primary mt-2">Post Reply</button>';
                            echo '</form>';
                            echo '</div>'; // End reply form container
                            if (!empty($comment['replies'])) {
                                echo '<ul class="replies">'; // Start nested list for replies
                                foreach ($comment['replies'] as $reply) {
                                    echo '<li><strong>' . $reply['username'] . '</strong>: ' . $reply['comment_text'] . '</li>';
                                }
                                echo '</ul>'; // End nested list for replies
                            }
                            echo '</div>';
                        }
                    }
                    ?>
                    <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) { ?>
                        <!-- Display the comment form if user is logged in -->
                        <form method="post" action="add_comment.php" class="main-comment-form">
                            <input type="hidden" name="music_id" value="<?php echo $music_id; ?>">
                            <textarea name="comment" class="form-control" placeholder="Write a comment" rows="3"></textarea>
                            <button type="submit" class="btn btn-primary mt-2">Post Comment</button>
                        </form>
                    <?php } else { ?>
                        <p>Please log in to post comments.</p>
                    <?php } ?>
                                </div>
                                
                            </div>

                            <a href="javascript:history.back();" class="btn btn-secondary mt-3">Back to Playlist</a>
                            <?php
                        }
                        ?>
                    </div>

                   
        
    
<script>
    // JavaScript code for toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        var replyLinks = document.getElementsByClassName('reply-link');
        for (var i = 0; i < replyLinks.length; i++) {
            replyLinks[i].addEventListener('click', function(e) {
                e.preventDefault();
                var replyFormContainer = this.nextElementSibling;
                replyFormContainer.style.display = replyFormContainer.style.display === 'block' ? 'none' : 'block';
            });
        }
    });

    function scrollToBottom() {
        var commentSection = document.getElementById('comment-section');
        commentSection.scrollTop = commentSection.scrollHeight;
    }

    // Call the function initially to scroll to the bottom on page load
    window.onload = scrollToBottom();

    
</script>



    <!-- Include Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.14/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
