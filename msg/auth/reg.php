<?php
require("../classes/Application.php");

$login = $_REQUEST['login'];
$password1 = $_REQUEST['password1'];
$password2 = $_REQUEST['password2'];
$email = $_REQUEST['email'];
$app = new Application();

$row = $app->Registration($login,$email);

$errorArr = array();

if (preg_match("/[!@#$%№₴\[\]\{'~\}\|\/`^&*():;\",<\\\>'\s]/", $login) != false && $login == "" && strlen($login) >= 1 && strlen($login) <= 19) {
    array_push($errorArr,"Incorrect login");
}
if ((strlen($email) <= 6) && (preg_match("~^([a-z0-9_\-\.])+@([a-z0-9_\-\.])+\.([a-z0-9])+$~i", $email) != true)) {
    array_push($errorArr,"Incorrect email");
}
if ($password1 == "" && strlen($password1) <= 6 && strlen($password1) >= 32) {
    array_push($errorArr,"Incorrect password");
}
if ($password1 != $password2) {
    array_push($errorArr,"Passwords are different");
}

if(count($errorArr) == 0 && count($row)== 0)
{
    $app->Registration_created($login, $password1, $email);
    echo "User created";
}
else
{
    if ($row[0]['login'] == $login) array_push($errorArr,"Login already using");
    if ($row[0]['email'] == $email) array_push($errorArr,"Email already using");

    echo count($errorArr);
    echo json_encode($errorArr);
    unset($errorArr);

}


