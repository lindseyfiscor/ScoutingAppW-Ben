<?php


?>
<html>
    <head>
        <title>ScoutFRC - Login</title>
        <link rel="stylesheet" href="css/lib/cosmo.min.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body >
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
          <a class="navbar-brand" href="#">Scout<span class="text-bold">FRC</span></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="index.html"><i class="fas fa-home mr-2"></i>Home</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="#"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin.php"><i class="fas fa-tools mr-2"></i>Admin</a>
              </li>
            </ul>
          </div>
        </nav>
        
        <div class="wrapper bg-secondary" style="min-height: 100%;">
            <div class="col-12 pt-5">
                <div class="card col-6 offset-3 mt-5">
                    <h3 class="mt-3">Welcome back!</h3>
                    <input class="form-control mt-4 mb-1" type="email" aria-label="Enter Username" placeholder="jane.doeling@email.com">
                    <input class="form-control mb-2" type="password" aria-label="Enter Password" placeholder="myawesomelongpassword">
                    <button class="btn btn-primary btn-block mb-1" type="button">Sign In</button>
                    <hr>
                    <button class="btn btn-secondary btn-block mt-1 mb-4"  type="button">Register</button>
                </div>
            </div>
        </div> 
        <script src="https://kit.fontawesome.com/ee41ca2f02.js" crossorigin="anonymous"></script>
        <script src="js/lib/jquery-3.6.0.min.js"></script>
        <script src="js/lib/bootstrap.bundle.min.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>