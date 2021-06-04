<?php

if ($_POST["a"] == "del") {
        if (isset($_POST['id'])) {
                require '../config/config.php';
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $search_del_sql = "select * from events where id={$_POST['id']}";
                $search_res = $mysqli->query($search_del_sql);

                if ($search_res->num_rows > 0) {
                        $del_sql = "delete FROM events where id={$_POST['id']}";
                        $del_res = $mysqli->query($del_sql);

                        if ($del_res) {
                                $msg_infos = ['code' => 0, 'msg' => 'Deleted succeed!'];
                        } else {
                                $msg_infos = ['code' => 1, 'msg' => 'Deleted failed!'];
                        }
                        echo json_encode($msg_infos);
                        exit;
                }
        }
}


