<?php 
session_start();
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once('../task_db.php');

$tasks = get_tasks($_SESSION['maPB']);
die(json_encode($tasks));
?>