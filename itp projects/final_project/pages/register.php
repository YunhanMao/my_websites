<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register | SCList</title>
        <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
        <script src="../bootstrap/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/main.css">
        <link rel="stylesheet" type="text/css" href="../css/check.css">
        <link rel="stylesheet" href="../css/style.css">
</head>
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
                                <a class="nav-link " href="login.php">Log in</a>
                                <a class="nav-link active" href="register.php">Sign up</a>
                        </div>
                </div>
        </div>
</nav>

<div class="wrapper">
        <div class="page-container" style="background-image: url('../images/background_login.jpg');">
                <div class="page-wrapper">
                        <form class="submit-form validate-form" id="register-form" action="register_confirm.php" method="POST">
                                <span class="form-title">Sign up for SCList</span>
                                <p class="dp">You are on your way to an efficient life-style!</p>
                                <div class="row mb-3">
                                        <div class="text-danger d-flex justify-content-center" id="text-danger"></div>
                                </div>
                                <div class="input-wrapper validate-input" data-validate="Please enter your username">
                                        <span class="myinput">Username</span>
                                        <input class="input-info" onfocus="hideMsg(1)" type="text" name="username" id="username" placeholder="Please create your username" autocomplete="off">
                                </div>
                                <div id="name-warn" class="">&nbsp;</div>
                                <div class="input-wrapper validate-input" data-validate="Please enter your password">
                                        <span class="myinput">Password</span>
                                        <input class="input-info"  onfocus="hideMsg(2)" type="password" name="password" id="password" placeholder="Please create your password">
                                </div>
                                <div id="pass-warn" class="">&nbsp;</div>
                                <div class="input-wrapper validate-input" data-validate="Please enter your password">
                                        <span class="myinput">Password Confirmation</span>
                                        <input class="input-info"  onfocus="hideMsg(3)" type="password" name="recheck_password" id="recheck_password" placeholder="Reconfirm your password here">
                                </div>
                                <div id="repass-warn" class="">&nbsp;</div>
                                <div class="form-button-container">
                                        <div class="form-button-wrapper">
                                                <div class="form-button-animation"></div>
                                                <button class="form-button" type="submit">Register</button>
                                        </div>
                                </div>

                                <div class="transition flex-col-c">
                                        <a href="login.php" class="txt2">Already have an account? Log in here!</a>
                                </div>
                        </form>
                </div>
        </div>
</div>
<footer>
        © 2021 SCList
</footer>
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/ajax.js?t=1"></script>
<script>
        document.querySelector("form").onsubmit = function (event) {
                event.preventDefault();
                if (document.querySelector('#username').value.trim().length == 0) {
                        document.querySelector('#name-warn').textContent = "Please enter username.";
                        document.querySelector('#name-warn').classList.add('register-form-warn');
                        return false;
                } else {
                        document.querySelector('#name-warn').textContent = "";
                        document.querySelector('#name-warn').classList.remove('register-form-warn');
                }

                if (document.querySelector('#password').value.trim().length == 0) {
                        document.querySelector('#pass-warn').textContent = "Please enter password.";
                        document.querySelector('#pass-warn').classList.add('register-form-warn');
                        return false;
                } else {
                        document.querySelector('#pass-warn').textContent = "";
                        document.querySelector('#pass-warn').classList.remove('register-form-warn');
                }

                if (document.querySelector('#recheck_password').value.trim().length == 0) {
                        document.querySelector('#repass-warn').textContent = "Please enter password.";
                        document.querySelector('#repass-warn').classList.add('register-form-warn');
                        return false;
                } else {
                        document.querySelector('#repass-warn').textContent = "";
                        document.querySelector('#repass-warn').classList.remove('register-form-warn');
                }

                let username = document.querySelector("#username").value;
                let password = document.querySelector("#password").value;
                let recheck_password = document.querySelector("#recheck_password").value;

                if (password !== recheck_password) {
                        document.querySelector('#text-danger').textContent = "Please correctly reconfirm your password.";
                        return false;
                } else {
                        document.querySelector('#text-danger').textContent = "";
                }
                document.querySelector("form").submit();
        }

        function hideMsg(i) {
            switch (i) {
                case 1:
                    document.querySelector('#name-warn').textContent =" ";
                    break;
                case 2:
                    document.querySelector('#pass-warn').textContent ="";
                    break;
                case 3:
                    document.querySelector('#repass-warn').textContent ="";
                    break;
            }
            document.querySelector('#text-danger').textContent = "";
        }
</script>
</body>
</html>