<!DOCTYPE html>
<html>
<head>
    <title>MusicHub - Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            background-image: url('https://images.unsplash.com/photo-1523821741446-edb2b68bb7a0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80');
            background-size: cover;
          background-repeat: no-repeat;
          background-position: center center;
        }


        .login-container {
            margin-top: 150px;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .login-container h2 {
            text-align: center;
        }

        .login-container img {
            width: 100px;
            height: auto;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .login-container form {
            margin-top: 20px;
        }

        .login-container form .form-group {
            margin-bottom: 20px;
        }

        .login-container form .btn {
            width: 100%;
        }

        .login-container .signup-link {
            text-align: center;
        }

        .login-container .signup-link a {
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="login-container">
                <center><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLROJy3YCIzkoRWD6hkK0MUVcvLnPRR17g9g&usqp=CAU" alt="MusicHub Icon"></center>
                <h2>MusicHub</h2>
                
                <form action="login_process.php" method="post">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                <div class="signup-link">
                    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-5">
            <img src="https://images.unsplash.com/photo-1619983081563-430f63602796?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=387&q=80" alt="Big Image" class="img-fluid">
        </div>
    </div>
</div>

</body>
</html>
