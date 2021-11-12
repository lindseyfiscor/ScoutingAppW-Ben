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
              <li class="nav-item active">
                <a class="nav-link" href="index.html">Home
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">Login</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin.php">Admin</a>
              </li>
            </ul>
          </div>
        </nav>
        
        <div class="wrapper bg-secondary" style="min-height: 100%;">
            <div class="col-12">
                <div class="card col-6 offset-3 mt-5">
                    <h3>Welcome back!</h3>
                    <input class="form-control mt-4 mb-1" type="email" aria-label="Enter Username" placeholder="jane.doeling@email.com">
                    <input class="form-control" type="password" aria-label="Enter Password" placeholder="myawesomelongpassword">
                    <button class="btn btn-primary btn-block mb-2" type="button">Sign In</button>
                    <hr>
                    <button class="btn btn-secondary btn-block mt-2 mb-5"  type="button">Register</button>
                </div>
            </div>
        </div> 
        <script src="js/lib/jquery-3.6.0.min.js"></script>
        <script src="js/lib/bootstrap.bundle.min.js"></script>
        <script src="js/app.js"></script>
    </body>
</html>