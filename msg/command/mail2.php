<?php
require("../classes/Application.php");

$email = $_REQUEST['email'];
$app = new Application();

$row = $app->Mail_send($email);

$sub = "Password recovery!";

$msg = "Dear " . $row[0]['login'] . " Thank you for using the services of our development team! \r\n 
This is the password of your account: " . $row[0]['password'] . " \r\n
Thank you for being with us! \r\n";

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'From: Your name <info@address.com>' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


if ($email != "" && $email == $row[0]['email']) {
    mail($email, $sub, $msg, $headers);
    echo "send";
}
else {
    echo "nihua ne send";
}