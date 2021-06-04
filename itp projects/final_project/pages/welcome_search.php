<?php
session_start();
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
        <script src="../js/ajax.js"></script>
        <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/check.css?t=1">
        <title>SCList Search Page</title>
        <script type="text/javascript">
                window.onload = function () {
                        ajaxPage("deal_search.php");
                }
        </script>
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
                                <a class="nav-link" href="welcome_search.php">Welcome, <?php echo $_SESSION["username"]; ?>!</a>
                                <a class="nav-link active" href="welcome_search.php">Search</a>
                                <a class="nav-link" href="welcome_insert.php">Add</a>
                                <a class="nav-link" href="logout.php">Log out</a>
                        </div>
                </div>
        </div>
</nav>

<div class="p text-center bg-lightblue" id="header">
        <h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
        <h2>A good place to look up your schedule!</h2>
</div>

<div class="container d-con">
        <div class="row">
                <div id="test-output"></div>
                <h1 class="col-12 mt-3" style="font-size: 24px;">To-Do List Search</h1>
        </div> 

        <div class="row">
                <div class='d-from'>
                        <div class="slist">
                                <span class="fromtit">Event name:</span>
                                <div class="search search_bar">
                                        <form>
                                                <input type="text" placeholder="Enter event name here" id="search_name" name="search_name">
                                                <button type="button" id="search-events" onclick="search_infos()"></button>
                                        </form>
                                </div>
                        </div>
                        <div class="slist">
                                <span class="fromtit1">Urgency Level: </span>
                                <select class="form_select" id="search_urgency_id" name="search_urgency_id">
                                        <option value="0">---Select One---</option>
                                        <option value="1">Most Urgent</option>
                                        <option value="2">More Urgent</option>
                                        <option value="3">Urgent</option>
                                        <option value="4">Less Urgent</option>
                                        <option value="5">Normal Urgent</option>
                                </select>
                        </div>
                </div>
        </div>

        <div class="res" style="min-height: 50vh;">
                <div class="box">
                        <div class="content">
                                <h1 class="col-12 mt-3" style="font-size: 24px;text-align: left;">To-Do List Results</h1>
                                <table id="tb" class="table">
                                        <thead>
                                        <tr>
                                                <th>ID</th>
                                                <th>Event Name</th>
                                                <th>Urgency Level</th>
                                                <th>Operations</th>
                                        </tr>
                                        </thead>
                                        <tbody id="show_tbody"></tbody>
                                </table>

                                <div class="page">
                                        <div class="pagel">
                                                Showing <span id="records"></span> from your SCList.
                                        </div>
                                        <div class="pager" id="pager"></div>
                                </div>
                        </div>
                </div>
        </div>
</div>
<script src="../js/ajax.js?t=1"></script>
<script>
        function deal_del(param) {
                let requestData = 'id=' + param + '&a=del';
                ajaxPost('deal_del.php', requestData);
        }

        function show_infos(cur_page, name, uid, actions) {
                let requestData = 'cur_page=' + cur_page + '&name=' + name + '&urgency_id=' + uid + '&a=' + actions;
                ajaxPage('deal_search.php', requestData);
        }

        function search_infos() {
                let search_name = document.getElementById('search_name').value;
                let search_urgency_id = document.getElementById('search_urgency_id').value;
                let requestData = 'name=' + search_name + '&urgency_id=' + search_urgency_id + '&a=search';
                ajaxPage('deal_search.php', requestData);
        }

        function change_infos(id, urgency_id) {
                let row_name_obj = document.getElementById('row_name_' + id);
                let row_level_obj = document.getElementById('row_level_' + id);
                let change_click_obj = document.getElementById('change_click_' + id);

                let row_name_txt = document.getElementById('row_name_' + id).textContent;

                let select_html = '';
                select_html += '<select style="width: 200px;display: inline;height: 42px;padding-left: 10px;" id="upd_urgency_id_' + id + '" name="upd_urgency_id_' + id + '">';
                if (urgency_id == 1) {
                        select_html += '<option value="1" selected>Most Urgent</option>';
                } else {
                        select_html += '<option value="1">Most Urgent</option>';
                }
                if (urgency_id == 2) {
                        select_html += '<option value="2" selected>More Urgent</option>';
                } else {
                        select_html += '<option value="2">More Urgent</option>';
                }
                if (urgency_id == 3) {
                        select_html += '<option value="3" selected>Urgent</option>';
                } else {
                        select_html += '<option value="3">Urgent</option>';
                }
                if (urgency_id == 4) {
                        select_html += '<option value="4" selected>Less Urgent</option>';
                } else {
                        select_html += '<option value="4">Less Urgent</option>';
                }
                if (urgency_id == 5) {
                        select_html += '<option value="5" selected>Normal Urgent</option>';
                } else {
                        select_html += '<option value="5">Normal Urgent</option>';
                }
                select_html += '</select><div id="level-warn" class="update-form-warn"></div>';

                row_name_obj.innerHTML = '<input style="width: 50%;" id="upd_name_' + id + '" name="upd_name_' + id + '" type="text" value="' + row_name_txt + '"><div id="name-warn" class="update-form-warn"></div>';
                row_level_obj.innerHTML = select_html;

                let deal_click_html = '<a onclick="deal_edit(' + id + ');" href="javascript:void(0);" class="edit" id="deal-update" name="deal-update">update</a>';
                change_click_obj.innerHTML = '';
                change_click_obj.innerHTML = deal_click_html;

                let edit_disabled_obj = document.getElementsByName("edit-disabled");
                let edit_disabled_obj_len = edit_disabled_obj.length;
                for (let j = 0; j < edit_disabled_obj_len; j++) {
                        document.getElementsByName("edit-disabled")[j].removeAttribute("onclick");
                }

                let del_disabled_obj = document.getElementsByName("del-disabled");
                let del_disabled_len = del_disabled_obj.length;
                for (let j = 0; j < del_disabled_len; j++) {
                        document.getElementsByName("del-disabled")[j].removeAttribute("onclick");
                }
        }

        function deal_edit(id) {
                if (document.getElementById('upd_name_' + id).value.trim() == '') {
                        document.getElementById('name-warn').textContent = "Please enter new event name.";
                        return false;
                } else {
                        document.getElementById('name-warn').textContent = "";
                }

                let upd_name = document.getElementById("upd_name_" + id).value;
                let upd_urgency_id = document.getElementById("upd_urgency_id_" + id).value;
                let requestData = '?id=' + id + '&name=' + encodeURIComponent(upd_name) + '&urgency_id=' + upd_urgency_id + '&a=edit';

                if (upd_name && upd_urgency_id) {
                        ajaxGet('deal_update.php' + requestData);
                        return false;
                }
        }
</script>
</body>
</html>