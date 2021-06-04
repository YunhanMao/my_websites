<?php
if ($_GET["a"] == "edit") {
        if (isset($_GET['name']) && isset($_GET['id']) && isset($_GET['urgency_id'])) {
                require '../config/config.php';
                $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $upd_sql = "update events set name='{$_GET['name']}',urgency_id={$_GET['urgency_id']} where id={$_GET['id']}";

                $upd_res = $mysqli->query($upd_sql);

                if ($upd_res) {
                        $msg_infos = ['code' => 0, 'msg' => 'Updated succeed!'];
                } else {
                        $msg_infos = ['code' => 1, 'msg' => 'Updated failed!'];
                }
                echo json_encode($msg_infos);
                exit;
        }
}