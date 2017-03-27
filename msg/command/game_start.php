<?php
require ("Application.php");

$who = $_REQUEST["who"];
$opponent = $_REQUEST["opponent"];

$app = new Application();

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
echo $app->Game_start_select($who,$opponent);

die();

if($app->Game_start_select($who,$opponent) == 0){
    $who_fract = rand ( 0 , 1 );
    if($who_fract == 0){
        $who_fract = "X";
        $who_tutn = "true";
    }
    else{
        $who_fract = "O";
        $who_tutn = "false";
    }
    $app->Game_start_insert($who,$who_fract,$who_turn,$opponent);

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
