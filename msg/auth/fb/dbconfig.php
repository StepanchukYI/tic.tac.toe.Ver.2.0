<?php
header('Access-Control-Allow-Origin: *');
error_reporting(0);
$host = "localhost";
$user = "root";
$password = "";
$database = "team_4";

$h = mysqli_connect($host, $user, $password);
mysqli_select_db($h, $database);