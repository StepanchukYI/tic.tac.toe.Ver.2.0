<?php
require("../classes/Application.php");
require("../classes/Message.php");

if (!isset($_COOKIE['xo_auth_log'])) {
    $login = $_REQUEST['login'];
} else {
    $login = $_COOKIE['xo_auth_log'];
}

$sql_query = "SELECT login FROM clients WHERE login<>'" . $login . "' AND xo_online = 'true'";

$result_set = mysqli_query($h, $sql_query);

if (mysqli_num_rows($result_set) > 0) {

    while ($row = mysqli_fetch_all($result_set)) {

        echo json_encode($row);
    }
}