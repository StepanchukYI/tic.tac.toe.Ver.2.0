<?php
include_once ("dbconfig.php");

$sender = $_REQUEST['sender'];
$receiver = $_REQUEST['receiver'];
$header = $_REQUEST['header'];
$body = $_REQUEST['body'];

$sql_query = "INSERT INTO messages_xo(sender,receiver,header,body) VALUES('$sender','$receiver','$header','$body')";

mysqli_query($h, $sql_query);