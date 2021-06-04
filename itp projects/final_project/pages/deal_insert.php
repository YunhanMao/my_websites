<?php
session_start();
if ($_POST) {
        if (isset($_POST['name']) && isset($_POST['urgency_id'])) {
                require '../config/config.php';
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $ins_sql = "INSERT INTO events(name,account_info_id,urgency_id) 
                                        VALUES ('{$_POST['name']}',{$_SESSION["account_id"]},{$_POST['urgency_id']})";
              
                $ins_res = $mysqli->query($ins_sql);

                if ($ins_res) {
                        $msg_infos = ['code' => 0, 'msg' => 'Added succeed!'];
                } else {
                        $msg_infos = ['code' => 1, 'msg' => 'Added failed!'];
                }
                echo json_encode($msg_infos);
                exit;
        }
}