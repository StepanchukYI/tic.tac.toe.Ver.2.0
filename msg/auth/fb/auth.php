<?php
require "config.php";
require "functions.php";
include_once("dbconfig.php");


if ($_GET['code']) {
    $result = get_token($_GET['code']);

    if ($result) {
        $user = get_data($result);

        $sql_query = "SELECT login,xo_online,chat_online,fb_id,google_id FROM clients WHERE fb_id='" . $user->id . "'";
        $result_set = mysqli_query($h, $sql_query);
        $row = mysqli_fetch_row($result_set);

        if ($row[1] != "true") {
            if ($user->id == $row[3]) {
                $sql_query = "UPDATE clients SET xo_online = 'true', login = '$user->first_name'  WHERE fb_id='" . $user->id . "'";
                $result_set = mysqli_query($h, $sql_query);
                echo json_decode($row);

                setrawcookie('xo_auth_log', $user->first_name, time() + 86400, '/');

                echo "OK";

                header('Location: ../../../client.html');
            } else {
                $sql_query = "INSERT INTO clients(login,password,email,banned,fb_id,xo_online) VALUES('$user->first_name', '$user->id','$user->email','false', '$user->id', 'true')";
                mysqli_query($h, $sql_query);
                echo "OK";

                setrawcookie('xo_auth_log', $user->first_name, time() + 86400, '/');

                header('Location: ../../../client.html');
            }
        } else {
            echo "User online";

            header('Location: ../../../client.html');
        }
        /*
        if($row[2]!="true"){
            if($user->id == $row[3]){
                $sql_query = "UPDATE clients SET chat_online = 'true', login = '$user->first_name'  WHERE fb_id='" . $user->id . "'";
                $result_set = mysqli_query($h, $sql_query);
                echo json_decode($row);
                echo "OK";
            }
            else{
                $sql_query = "INSERT INTO clients(login,password,email,fb_id,chat_online) VALUES('$user->first_name', '$user->id','$user->email', '$user->id', 'true')";
                mysqli_query($h, $sql_query);
                echo "OK";
            }
        } else{
            echo "User online";
        }*/
    }
} else {
    exit('Error');
}