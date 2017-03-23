<?php
include_once ("dbconfig.php");

$receiver = $_REQUEST['receiver'];

$sql_query = "SELECT sender,header,body FROM messages_xo WHERE receiver = '" . $receiver . "'";
$result_set = mysqli_query($h, $sql_query);

class Message
{
    public $sender;
    public $header;
    public $body;

    function __construct($sender, $header, $body)
    {
        $this->sender = $sender;
        $this->header = $header;
        $this->body = $body;
    }
}
if(mysqli_num_rows($result_set) > 0)
{
    $messages = array();

    while($row = mysqli_fetch_row($result_set))
    {
        array_push($messages, new Message($row[0], $row[1], $row[2]));
    }

    echo json_encode($messages);

    $sql_query = "DELETE FROM messages_xo WHERE receiver = '" . $receiver . "'";
    mysqli_query($h, $sql_query);
}
else
{
    echo 0;
}
