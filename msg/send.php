<?php
require("classes/Application.php");

$sender = $_REQUEST['sender'];
$receiver = $_REQUEST['receiver'];
$header = $_REQUEST['header'];
$body = $_REQUEST['body'];

$app = new Application();

$app->Send($sender,$receiver,$header,$body);