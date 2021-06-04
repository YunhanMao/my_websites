<?php
	session_start();
	session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logout | SCList</title>
	
	<link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
    <script src="../bootstrap/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/main.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

	<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php">SCList</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link " aria-current="page" href="index.php">Home</a>
              <a class="nav-link active" href="login.php">Log in</a>
              <a class="nav-link" href="register.php">Sign up</a>
            </div>
          </div>
        </div>
      </nav>

	<div class="wrapper">
		<div class="page-container" style="background-image: url('../images/background_login.jpg');">
			<div class="page-wrapper">
			<span class="form-title">You are now logged out</span>
					<p class="dp">Hope to see you again soon!</p>
					<div class="form-button-container">
						<div class="form-button-wrapper">
							<div class="form-button-animation"></div>
					<a href="index.php" class="form-button" style="text-decoration:none;" >Back to main page</a>
					</div>
					</div>
			</div>
		</div>
	</div>
		<footer>
        © 2021 SCList
      </footer>
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/main.js"></script>
</body>
</html>