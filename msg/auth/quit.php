<?php
include_once ("../dbconfig.php");

if (!isset($_COOKIE['xo_auth_log'])) {
    $login = $_REQUEST['login'];
} else {
    $login = $_COOKIE['xo_auth_log'];
}

//$login = $_REQUEST['login'];
$from = $_REQUEST['from'];

if ($from == "xo") {
    $sql_query = "UPDATE clients SET xo_online = 'false' WHERE login='" . $login . "'";
    setcookie('xo_auth_log', '', time() + 86400, '/');
} else if ($from == "chat") {
    $sql_query = "UPDATE clients SET chat_online = 'false' WHERE login='" . $login . "'";
    setcookie('xo_auth_log', '', time() + 86400, '/');
}

mysqli_query($h, $sql_query);

echo "Logout";