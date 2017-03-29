<?php
require("../classes/Application.php");

if (!isset($_COOKIE['xo_auth_log'])) {
    $login = $_REQUEST['login'];
} else {
    $login = $_COOKIE['xo_auth_log'];
}
$from = $_REQUEST['from'];

$app = new Application();

if ($from == "xo") {

    $app->Update_auth_xo($login,'false');
    setcookie('xo_auth_log', '', time() + 86400, '/');
} else if ($from == "chat") {
    $app->Update_auth_chat($login,'false');
    setcookie('xo_auth_log', '', time() + 86400, '/');
}

echo "Logout";