<?php
session_start();
require '../config/config.php';
if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        header("Location: ../pages/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="../bootstrap/bootstrap.min.js"></script>
        <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/check.css?t=1">
        <title>SCList Insert Page</title>
</head>

<body class="bodybg">
<nav class="navbar navbar-expand-md navbar-dark bg-dark" style="padding-left: 0;">
        <div class="container-fluid">
                <a class="navbar-brand" href="index.php">SCList</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                                <a class="nav-link" aria-current="page" href="index.php">Home</a>
                                <a class="nav-link" href="welcome_insert.php">Welcome, <?php echo $_SESSION["username"]; ?>!</a>
                                <a class="nav-link " href="welcome_search.php">Search</a>
                                <a class="nav-link active" href="welcome_insert.php">Add</a>
                                <a class="nav-link" href="logout.php">Log out</a>
                        </div>
                </div>
        </div>
</nav>

<div class="p text-center bg-lightblue" id="header">
        <h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
        <h2>A good place to update your schedule!</h2>
</div>

<div class="container d-con">
        <div class="row">
                <div id="test-output"></div>
                <h1 class="col-12 mt-3" style="font-size: 24px;">To-Do List Insert</h1>
        </div>

        <div class="row">
                <div class='d-from'>
                        <div class="slist">
                                <span class="fromtit fromtit1">Event name:</span>
                                <div class="search insert_bar">
                                        <form>
                                                <input type="text" placeholder="Enter event name here" id="name" name="name">
                                                <button type="button" id="deal-insert" onclick="dealInsert()"></button>
                                        </form>
                                </div>
                                <div id="name-warn" style="color: red;font-size: 14px;margin: 10px 0px 0px 0px;position: absolute;"></div>
                        </div>
                        <div class="slist">
                                <span class="fromtit">Urgency Level: </span>
                                <select class="form_select" id="urgency_id" name="urgency_id">
                                        <option value="0">---Select One---</option>
                                        <option value="1">Most Urgent</option>
                                        <option value="2">More Urgent</option>
                                        <option value="3">Urgent</option>
                                        <option value="4">Less Urgent</option>
                                        <option value="5">Normal Urgent</option>
                                </select>
                                <div id="level-warn" style="color: red;font-size: 14px;margin: 10px 0px 0px 0px; position: absolute;"></div>
                        </div>
                </div>
        </div>
</div>

<script src="../js/ajax.js?t=1"></script>
<script>
        function dealInsert() {
                if (document.getElementById('name').value.trim() == '') {
                        document.getElementById('name-warn').textContent = "Please enter new event name.";
                        return false;
                } else {
                        document.getElementById('name-warn').textContent = "";
                }

                if (document.getElementById('urgency_id').value == 0) {
                        document.getElementById('level-warn').textContent = "Please select new urgency level.";
                        return false;
                } else {
                        document.getElementById('level-warn').textContent = "";
                }

                let name = document.getElementById("name").value;
                let urgency_id = document.getElementById("urgency_id").value;

                let requestData = 'name=' + encodeURIComponent(name) + '&urgency_id=' + urgency_id;
                if (name && urgency_id) {
                        ajaxPost('deal_insert.php', requestData);
                }
        }
</script>
</body>
</html>