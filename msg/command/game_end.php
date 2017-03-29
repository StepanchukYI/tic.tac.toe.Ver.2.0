<?php
require("../classes/Application.php");

$who = $_REQUEST["who"];
$opponent = $_REQUEST["opponent"];
$app = new Application();
$app->Game_end($who,$opponent);
