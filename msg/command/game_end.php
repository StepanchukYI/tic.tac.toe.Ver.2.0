<?php
require("../classes/Application.php");

$who = $_REQUEST["who"];
$opponent = $_REQUEST["opponent"];

$sql_query = "DELETE FROM game WHERE who ='".$who."' AND opponent ='".$opponent."' OR who ='".$opponent."' AND opponent ='".$who."' ";

$result_set = mysqli_query($h, $sql_query);