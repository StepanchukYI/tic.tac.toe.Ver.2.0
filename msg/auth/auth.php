<?php
require("../classes/Application.php");

$login = $_REQUEST['login'];
$password = $_REQUEST['password'];
$from = $_REQUEST['from'];

$errorArr = array();

$app = new Application();

if ($login == "") array_push($errorArr,"Failed login");
if ($password == "") array_push($errorArr,"Failed password");


$row = $app->Auth_Select($login);

if (count($row) == 0) {
    array_push($errorArr, "Failed login");
}else{
    if ($password != $row[0]['password']) array_push($errorArr, "Failed password");
    if ($row[0]['xo_online'] == "true") array_push($errorArr, "User already online");
}

if(count($errorArr) == 0) {
    if ($from == "xo") {

        $app->Update_Auth_xo($login, 'true');

        setrawcookie('xo_auth_log', $login, time() + 86400, '/');

        echo json_encode("OK");
    } else if ($from == "chat") {

        $app->Update_Auth_chat($login, 'true');

        setrawcookie('chat_auth_log', $login, time() + 86400, '/');
        echo json_encode("OK");
    }
}else {
    echo json_encode($errorArr[0]);
    unset($errorArr);
}


