<?php
include_once ("../dbconfig.php");

$login = $_REQUEST['login'];
$password = $_REQUEST['password'];
$from = $_REQUEST['from'];

$sql_query = "SELECT login, password FROM clients WHERE login='" . $login . "'";

$result_set = mysqli_query($h, $sql_query);

$row = mysqli_fetch_row($result_set);
if ($login != "") {
    if ($password != "") {
        if ($row[1] == $password) {

            $sql_query = "SELECT login,xo_online,chat_online FROM clients WHERE login='" . $login . "'";

            $result_set = mysqli_query($h, $sql_query);

            $row = mysqli_fetch_row($result_set);

            if ($from == "xo") {
                if ($row[1] != "true") {

                    $sql_query = "UPDATE clients SET xo_online = 'true' WHERE login='" . $login . "'";

                    $result_set = mysqli_query($h, $sql_query);
                    setrawcookie('xo_auth_log', $login, time() + 86400, '/');


                    echo "OK";
                } else {
                    echo "User already online";
                }
            } else if ($from == "chat") {
                if ($row[2] != "true") {

                    $sql_query = "UPDATE clients SET chat_online = 'true' WHERE login='" . $login . "'";

                    $result_set = mysqli_query($h, $sql_query);
                    setrawcookie('xo_auth_log', $login, time() + 86400, '/');


                    echo "OK";
                } else {
                    echo "User already online";
                }
            }
        } else {
            echo "Failed password";
        }
    } else {
        echo "Failed password";
    }
} else {
    echo "Failed login";
}

