<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging out…</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/app.css">
</head>
<body class="app-body">
    <div class="app-shell bg-body-tertiary min-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="card app-card app-logout-card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="spinner-border" role="status" aria-hidden="true"></div>
                                <div>
                                    <div class="fw-semibold">Logging you out…</div>
                                    <div class="text-body-secondary small">Redirecting to login</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

        session_start();

        session_unset();//free session variables (remove value)
        session_destroy();//destroy/remove session

        //Redirect to the Login Page (index.php)
        header("location:index.php");
        exit();
    ?>
</body>
</html>