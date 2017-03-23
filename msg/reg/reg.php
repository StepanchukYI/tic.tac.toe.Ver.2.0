<?php
include_once("../dbconfig.php");

$login = $_REQUEST['login'];
$password1 = $_REQUEST['password1'];
$password2 = $_REQUEST['password2'];
$email = $_REQUEST['email'];

$sql_query = "SELECT login FROM clients WHERE login='" . $login . "'";
$result_set = mysqli_query($h, $sql_query);
$row = mysqli_fetch_row($result_set);

if (preg_match("/[!@#$%№₴\[\]\{'~\}\|\/`^&*():;\",<\\\>'\s]/", $login) == false && $login != "" && strlen($login) >= 1 && strlen($login) <= 19) {
    if ((strlen($email) >= 6) && (preg_match("~^([a-z0-9_\-\.])+@([a-z0-9_\-\.])+\.([a-z0-9])+$~i", $email) == true)) {
        if ($password1 != "" && strlen($password1) >= 6 && strlen($password1) <= 32) {
            if ($password1 == $password2) {
                if ($row[0] != $login) {
                    $sql_query = "SELECT email FROM clients WHERE email='" . $email . "'";
                    $result_set = mysqli_query($h, $sql_query);
                    $row = mysqli_fetch_row($result_set);
                    if ($row[0] != $email) {
                        $sql_query = "INSERT INTO clients(login,password,email,banned) VALUES('$login', '$password1', '$email','false')";
                        mysqli_query($h, $sql_query);
                        echo "User created";
                    } else {
                        echo "Email already using";
                    }
                } else {
                    echo "Login already using";
                }
            } else {
                echo "Passwords are different";
            }
        } else {
            echo "Incorrect password";
        }
    } else {
        echo "Incorrect email";
    }
} else {
    echo "Incorrect login";
}