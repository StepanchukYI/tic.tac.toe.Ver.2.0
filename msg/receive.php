<?php
require("classes/Application.php");
$app = new Application();
$receiver = $_REQUEST['receiver'];

$row = $app->Receive($receiver);

if(count($row) > 0) {
    $messages = array();

    while ($row) {
        array_push($messages, new Message($row[0]['sender'], $row[0]['header'], $row[0]['body']));
    }

    echo json_encode($messages);

    $app->Receiver_delete($receiver);
}
else
{
    echo 0;
}
