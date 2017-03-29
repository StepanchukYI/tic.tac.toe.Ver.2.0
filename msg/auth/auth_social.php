<?php
require("../classes/Application.php");


 $where = $_REQUEST['where'];
 $from = $_REQUEST['from'];
 $id = $_REQUEST['id'];
 $email = $_REQUEST['email'];
 $login = $_REQUEST['login'];


if($from == "xo") {

    if ($where == "fb") {

        $sql_query = "SELECT login,xo_online,fb_id FROM clients WHERE fb_id='" . $id . "'";

        $result_set = mysqli_query($h, $sql_query);

        $row = mysqli_fetch_row($result_set);
        if ($row[1] != "true") {
            if ($id == $row[2]) {

                $sql_query = "UPDATE clients SET xo_online = 'true', login='" . $login . "'  WHERE fb_id='" . $id . "'";
                $result_set = mysqli_query($h, $sql_query);
                echo json_decode($row);
                echo "OK";
            } else {

                $sql_query = "INSERT INTO clients(login,password,email,fb_id,xo_online) VALUES(' $login', '$id',' $email', '$id', 'true')";
                $result_set = mysqli_query($h, $sql_query);
                echo "OK";

            }
        } else {
            echo "User already online";
        }
    }
    elseif ($where == "google") {
        $sql_query = "SELECT login,xo_online,google_id FROM clients WHERE google_id='" . $id . "'";

        $result_set = mysqli_query($h, $sql_query);

        $row = mysqli_fetch_row($result_set);

        if ($id == $row[2]) {
            if ($row[1] != "true") {

                $sql_query = "UPDATE clients SET chat_online = 'true', login='" . $login . "'  WHERE google_id='" . $id . "'";
                $result_set = mysqli_query($h, $sql_query);
                echo json_decode($row);
                echo "OK";

            } else {

                $sql_query = "INSERT INTO clients(login,password,email,google_id,chat_online) VALUES('$login', '$id',' $email', '$id', 'true')";
                $result_set = mysqli_query($h, $sql_query);
                echo "OK";

            }
        }
    }
    else {
        echo "User online";
    }
}
elseif ($from == "chat") {
    if ($where == "fb") {

        $sql_query = "SELECT login,fb_id,google_id FROM clients WHERE fb_id='" . $id . "'";

        $result_set = mysqli_query($h, $sql_query);

        $row = mysqli_fetch_row($result_set);

        if ($id == $row[1]) {

            $sql_query = "UPDATE clients SET chat_online = 'true', login='" . $login . "'  WHERE fb_id='" . $id . "'";
            $result_set = mysqli_query($h, $sql_query);
            echo "OK";

        } else {
            $sql_query = "INSERT INTO clients(login,password,email,banned,fb_id,chat_online) VALUES(' $login', '$id',' $email','false', '$id', 'true')";
            $result_set = mysqli_query($h, $sql_query);
            echo "OK";
        }
    }elseif ($where == "google") {

        $sql_query = "SELECT login,fb_id,google_id FROM clients WHERE google_id='" . $id . "'";

        $result_set = mysqli_query($h, $sql_query);

        $row = mysqli_fetch_row($result_set);

        if ($id == $row[2]) {

            $sql_query = "UPDATE clients SET chat_online = 'true', login='" . $login . "'  WHERE google_id='" . $id . "'";
            $result_set = mysqli_query($h, $sql_query);
            echo "OK";

        } else {

            $sql_query = "INSERT INTO clients(login,password,email,banned,google_id,chat_online) VALUES('$login', '$id',' $email', 'false','$id', 'true')";
            $result_set = mysqli_query($h, $sql_query);
            echo "OK";

        }
    }

}

