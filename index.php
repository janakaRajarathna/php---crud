<?php
//Sessions store data on server side
//More secure than cookies
//No data limit
//when the browser closed data will removed
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/app.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" ></script>
    <script src="js/bootstrap.min.js" ></script>
</head>
<body class="app-body">
    <div class="app-shell bg-body-tertiary min-vh-100 d-flex flex-column">
        <nav class="navbar navbar-expand-lg app-navbar border-bottom">
            <div class="container">
                <a class="navbar-brand fw-semibold" href="index.php">SLIATE</a>
            </div>
        </nav>

        <main class="app-main app-login-main flex-grow-1 d-flex align-items-center py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8 col-lg-5">
                        <div class="card app-card app-login-card shadow-sm border-0">
                            <div class="card-body p-4 p-md-5">
                                <div class="d-flex align-items-start justify-content-between gap-3 mb-4">
                                    <div>
                                        <h1 class="h4 mb-1">Welcome back</h1>
                                        <p class="text-body-secondary mb-0">Sign in to continue</p>
                                    </div>
                                    <?php
                                    $uname="";
                                    if(isset($_COOKIE["username"])){
                                        echo '<span class="badge text-bg-light border">Hi, '.$_COOKIE["username"].'</span>';
                                        $uname=$_COOKIE["username"];
                                    }
                                    ?>
                                </div>

                                <!-- Submit form data to the Current Page -->
                                <!-- Filter to avoid Cross-site scripting (XSS) attacks-->
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="vstack gap-3">
                                    <div>
                                        <label class="form-label" for="user_name">User name</label>
                                        <input class="form-control" type="text" name="user_name" id="user_name" value="<?php echo $uname; ?>" autocomplete="username">
                                    </div>
                                    <div>
                                        <label class="form-label" for="pass">Password</label>
                                        <input class="form-control" type="password" name="pass" id="pass" autocomplete="current-password">
                                    </div>
                                    <div class="d-grid pt-1">
                                        <input class="btn btn-primary btn-lg" type="submit" name="btnLogin" value="Login">
                                    </div>
                                </form>

                                <?php

                                //import dbConfig
                                require_once("dbConnection.php");

                                if(isset($_POST["btnLogin"])){
                                    $userName = htmlspecialchars($_POST["user_name"]);
                                    $password = htmlspecialchars($_POST["pass"]);

                                    $query ="SELECT password,role FROM users WHERE name='$userName'";
                                    $result = mysqli_query($con,$query);

                                    if(mysqli_num_rows($result) > 0){
                                        $dbUser = mysqli_fetch_assoc($result);
                                        if($result && password_verify($password,$dbUser["password"])){

                                            setcookie("username",$userName,time() + 60,"/");// 30 Seconds
                                            $_SESSION["name"] = $userName;
                                            $_SESSION["role"] = $dbUser["role"];
                                            header("location:dashboard.php");
                                            exit();
                                        }
                                        else{
                                            echo '<div class="alert alert-danger mt-4 mb-0" role="alert">Please enter the valid password</div>';
                                        }
                                    }
                                    else{
                                        echo '<div class="alert alert-danger mt-4 mb-0" role="alert">Please enter the valid user name</div>';
                                    }
                                }
                                    
                                ?>
                            </div>
                        </div>
                        <p class="app-footer-text text-center text-body-secondary small mt-3 mb-0">
                            © <?php echo date("Y"); ?> SLIATE
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>