<?php

session_start();
require '../config/config.php';

if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        if (isset($_POST['username']) && isset($_POST['password'])) {
                if (empty($_POST['username']) || empty($_POST['password'])) {
                        $error = "Please enter username and password.";
                } else {
                        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        if ($mysqli->connect_errno) {
                                echo $mysqli->connect_error;
                                exit();
                        }
                        $passwordInput = hash("sha256", $_POST['password']);

                        $sql = "SELECT * FROM account_info WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordInput . "';";

                        $results = $mysqli->query($sql);

                        if (!$results) {
                                echo $mysqli->error;
                                exit();
                        }

                        if ($results->num_rows > 0) {
                                $account_res = $results->fetch_assoc();
                                $_SESSION["account_id"] = $account_res["id"];
                                $_SESSION["username"] = $_POST["username"];
                                $_SESSION["logged_in"] = true;
                                header("Location: ../pages/welcome_search.php");
                        } else {
                                $error = "Invalid username and password combination.";
                        }
                }
        }
} else {
        header("Location: ../pages/welcome_search.php");
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
        <link rel="stylesheet" type="text/css" href="../css/check.css">
        <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container-fluid">
                <a class="navbar-brand" href="index.php">SCList</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
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
                        <form class="submit-form validate-form" id="login-form" action="login.php" method="POST">
                                <span class="form-title">Log in to SCList</span>
                                <p class="dp">Prepare to Welcome a New Life!</p>
                                <div class="row mb-3">
                                        <div class="text-danger d-flex justify-content-center" id="warn">
                                                <?php
                                                if (isset($error) && !empty($error)) {
                                                        echo $error;
                                                }
                                                ?>
                                        </div>
                                </div>
                                <div class="input-wrapper validate-input" data-validate="Please enter your username">
                                        <span class="myinput">Username</span>
                                        <input class="input-info" onfocus="hideMsg(1)" type="text" id="username" name="username" placeholder="Please enter your username" autocomplete="off">
                                </div>
                                <div id="name-warn" class="">&nbsp;</div>
                                <div class="input-wrapper validate-input" data-validate="Please enter your password">
                                        <span class="myinput">Password</span>
                                        <input class="input-info"   onfocus="hideMsg(2)" type="password" id="password" name="password" placeholder="Please enter your password">
                                </div>
                                <div id="pass-warn" class="">&nbsp;</div>
                                <div class="form-button-container">
                                        <div class="form-button-wrapper">
                                                <div class="form-button-animation"></div>
                                                <button class="form-button" type="submit">Log in</button>
                                        </div>
                                </div>
                                <div class="transition flex-col-c">
                                        <a href="register.php" class="txt2">Don't have an account already? Register here!</a>
                                </div>
                        </form>
                </div>
        </div>
</div>
<footer>
        © 2021 SCList
</footer>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/ajax.js"></script>
<script>
        document.querySelector("form").onsubmit = function (event) {
                event.preventDefault();
                if (document.querySelector('#username').value.trim().length == 0) {
                        document.querySelector('#name-warn').textContent = "Please enter username.";
                        document.querySelector('#name-warn').classList.add('login-form-warn');
                        return false;
                } else {
                        document.querySelector('#name-warn').textContent = "";
                        document.querySelector('#name-warn').classList.remove('login-form-warn');
                }

                if (document.querySelector('#password').value.trim().length == 0) {
                        document.querySelector('#pass-warn').textContent = "Please enter password.";
                        document.querySelector('#pass-warn').classList.add('login-form-warn');
                        return false;
                } else {
                        document.querySelector('#pass-warn').textContent = "";
                        document.querySelector('#pass-warn').classList.remove('login-form-warn');
                }
                document.querySelector("form").submit();
        }

        function hideMsg(i) {
            switch (i) {
                case 1:
                    document.querySelector('#name-warn').textContent ="";
                    break;
                case 2:
                    document.querySelector('#pass-warn').textContent ="";
                    break;
            }

        }
</script>
</body>
</html>