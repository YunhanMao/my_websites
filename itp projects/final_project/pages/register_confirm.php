<?php

require '../config/config.php';

if (!isset($_POST['username']) || empty($_POST['username']) || ctype_space($_POST['username'])
        || !isset($_POST['password']) || empty($_POST['password']) ||
        !isset($_POST['recheck_password']) || empty($_POST['recheck_password'])) {
        $error = "Please fill out all required fields.";
} else if ($_POST['password'] != $_POST['recheck_password']) {
        $error = "Please correctly reconfirm your password!";
} else {
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_errno) {
                echo $mysqli->connect_error;
                exit();
        }

        $sql_registered = "SELECT * FROM account_info WHERE username = '" . $_POST["username"] . "';";

        $results_registered = $mysqli->query($sql_registered);
        if (!$results_registered) {
                echo $mysqli->error;
                exit();
        }

        if ($results_registered->num_rows > 0) {
                $error = "Username is already taken. Please try again.";
        } else {
                $password = hash("sha256", $_POST["password"]);
                $sql = "INSERT INTO account_info(username, password) VALUES('" . $_POST["username"] . "','" . $password . "');";

                $results = $mysqli->query($sql);
                if (!$results) {
                        echo $mysqli->error;
                        exit();
                }
        }
        $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login | SCList</title>

        <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
        <script src="../bootstrap/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
                <a class="navbar-brand" href="index.php">SCList</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
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
                        <?php if (isset($error) && !empty($error)) : ?>
                                <span class="form-title"><?php echo $error; ?></span>
                                <br>
                                <div class="form-button-container">
                                        <div class="form-button-wrapper">
                                                <div class="form-button-animation"></div>
                                                <a href="register.php" class="form-button" style="text-decoration:none;">Take me back to register page!</a>
                                        </div>
                                </div>
                        <?php else : ?>
                                <span class="form-title">Welcome on board, Captain <?php echo $_POST['username']; ?> !</span>
                                <br>
                                <div class="form-button-container">
                                        <div class="form-button-wrapper">
                                                <div class="form-button-animation"></div>
                                                <a href="login.php" class="form-button" style="text-decoration:none;">I am ready to go!</a>
                                        </div>
                                </div>
                        <?php endif; ?>
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