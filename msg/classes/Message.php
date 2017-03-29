<?php
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