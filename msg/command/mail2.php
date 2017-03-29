<?php
require("../classes/Application.php");

$email = $_REQUEST['email'];

$sql_query = "SELECT login, password, email FROM clients WHERE email='" . $email . "'";

$result_set = mysqli_query($h, $sql_query);

$row = mysqli_fetch_row($result_set);

$sub = "Password recovery!";

$msg = "Dear " . $row[0] . " Thank you for using the services of our development team! \r\n 
This is the password of your account: " . $row[1] . " \r\n
Thank you for being with us! \r\n";


$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: Your name <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


if ($email != "" && $email == $row[2]) {
    mail($email, $sub, $msg, $headers);
    echo "send";
} else {
    echo "nihua ne send";
}