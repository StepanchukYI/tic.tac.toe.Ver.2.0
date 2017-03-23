<?php
include_once("../dbconfig.php");

$who = $_REQUEST["who"];
$opponent = $_REQUEST["opponent"];


$sql_query = "SELECT who, who_fract, who_turn, opponent, block, value FROM game WHERE who ='".$who."' AND opponent ='".$opponent."'";

$result_set = mysqli_query($h, $sql_query);

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

if(mysqli_num_rows($result_set) == 0){
    $who_fract = rand ( 0 , 1 );
    if($who_fract == 0){
        $who_fract = "X";
        $who_tutn = "true";
    }
    else{
        $who_fract = "O";
        $who_tutn = "false";
    }
    $sql_query = "INSERT INTO game(who, who_fract, who_turn, opponent ,block ,value) VALUES('$who', '$who_fract', '$who_tutn', '$opponent', '$block', '$value')";
    $result_set = mysqli_query($h, $sql_query);

    echo json_encode(new Client($who,$who_fract,$who_tutn,$opponent));

}
else{
    if($who_fract == "X"){
        $who_fract = "O";
        $who_tutn = "false";
    }
    else{
        $who_fract = "X";
        $who_tutn = "true";
    }
    echo json_encode(new Client($opponent,$who_fract,$who_tutn,$who));
}
