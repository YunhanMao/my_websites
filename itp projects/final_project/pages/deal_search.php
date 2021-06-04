<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) {
        header("Location: ../pages/login.php");
}

$cur_page = 1;
$page_size = 5;
$total_records = 0;
$total_page = 0;
$total_records = 0;
$urgency_arr = [1 => 'Most Urgent', 2 => 'More Urgent', 3 => 'Urgent ', 4 => 'Less Urgent', 5 => 'Normal Urgent'];

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_errno) {
        echo $mysqli->connect_error;
        exit();
}

if (isset($_POST['a'])) {
        $where = ' where 1 ';
        if (isset($_POST['name'])) {
                $search_name = trim($_POST['name']);
                $where .= " and name like '%{$search_name}%' ";
        }

        if (isset($_POST['urgency_id']) && $_POST['urgency_id'] != 0) {
                $where .= " and urgency_id={$_POST['urgency_id']} ";
        }

        $search_total_sql = "select e.id,e.name,u.level from events as e left join urgency as u on u.id = e.urgency_id {$where} and e.account_info_id={$_SESSION['account_id']}  order by u.level asc ";
        $search_total_results = $mysqli->query($search_total_sql);
        $search_total_records = $search_total_results->num_rows;
        $search_total_page = ceil($search_total_records / $page_size);

        $cur_page = $_POST['cur_page'] ?? 0;
        if ($cur_page == 0) {
                $cur_page = 1;
        } else {
                $cur_page = $_POST['cur_page'];
        }
        $offset_page = ($cur_page - 1) * $page_size;

        $search_sql = "select e.id,e.name,u.level from events as e left join urgency as u on u.id = e.urgency_id  {$where} and e.account_info_id={$_SESSION['account_id']}  order by u.level asc limit {$offset_page},{$page_size} ";
        $search_event_res= array();
        $search_results = $mysqli->query($search_sql);
        if ($search_results->num_rows > 0) {
                $search_event_res = $search_results->fetch_all(MYSQLI_ASSOC);
        } else {
                $error = "errors";
        }

        $search_data_infos = array();
        $search_body_arr = array();

        foreach ($search_event_res as $ser_key => $ser_value) {
                $search_body_arr[$ser_key]['id'] = $ser_value['id'];
                $search_body_arr[$ser_key]['name'] = $ser_value['name'];
                $search_body_arr[$ser_key]['urgency_id'] = $ser_value['level'];
                $search_body_arr[$ser_key]['level'] = $urgency_arr[$ser_value['level']];
        }
        $search_data_infos['events_infos'] = $search_body_arr;
        $search_data_infos['total_records'] = $search_total_records;
        $search_data_infos['total_pages'] = $search_total_page;
        $search_data_infos['search_name'] = $search_name;
        $search_data_infos['search_uid'] = $_POST['urgency_id'];
        $search_data_infos['search_total_sql'] = $search_total_sql;
        $search_data_infos['search_sql'] = $search_sql;
        $search_data_infos['search_actions'] = 'search';
        echo json_encode($search_data_infos);
        exit;
} else {
        $load_total_sql = "select e.id,e.name,u.level from events as e left join urgency as u on u.id = e.urgency_id  where e.account_info_id={$_SESSION['account_id']}  order by u.level asc ";
        $total_results = $mysqli->query($load_total_sql);
        $total_records = $total_results->num_rows;
        $total_page = ceil($total_records / $page_size);

        $cur_page = $_POST['cur_page'] ?? 0;
        if ($cur_page == 0) {
                $cur_page = 1;
        } else {
                $cur_page = $_POST['cur_page'];
        }
        $offset_page = ($cur_page - 1) * $page_size;
        $where = '';

        $sql = "select e.id,e.name,u.level from events as e left join urgency as u on u.id = e.urgency_id   where e.account_info_id={$_SESSION['account_id']}   order by u.level asc limit {$offset_page},{$page_size} ";

        $results = $mysqli->query($sql);
        if ($results->num_rows >= 0) {
                $event_res = $results->fetch_all(MYSQLI_ASSOC);
        } else {
                $error = "errors";
        }

        $data_infos = array();
        $body_arr = array();

        foreach ($event_res as $er_key => $er_value) {
                $body_arr[$er_key]['id'] = $er_value['id'];
                $body_arr[$er_key]['name'] = $er_value['name'];
                $body_arr[$er_key]['urgency_id'] = $er_value['level'];
                $body_arr[$er_key]['level'] = $urgency_arr[$er_value['level']];
        }
        $data_infos['events_infos'] = $body_arr;
        $data_infos['total_records'] = $total_records;
        $data_infos['total_pages'] = $total_page;
        $data_infos['search_name'] = '';
        $data_infos['search_uid'] = 0;
        $data_infos['search_actions'] = '';
        echo json_encode($data_infos);
        exit;
}