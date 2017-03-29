<?php
class Client{
    public $who;
    public $who_fract;
    public $who_turn;
    public $opponent;

    function __construct($who, $who_fract, $who_turn,$opponent)
    {
        $this->who = $who;
        $this->who_fract = $who_fract;
        $this->who_turn = $who_turn;
        $this->opponent = $opponent;
    }
}