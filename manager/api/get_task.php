<?php 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once('../task_db.php');
$tasks = get_tasks();
die(json_encode($tasks));
?>