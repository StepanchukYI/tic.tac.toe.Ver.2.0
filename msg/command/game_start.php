<?php
require("../classes/Application.php");
require("../classes/Client.php");

$who = $_REQUEST["who"];
$opponent = $_REQUEST["opponent"];
$app = new Application();
if($app->Game_start_select($who,$opponent) == 0){
    $who_fract = rand ( 0 , 1 );
    if($who_fract == 0){
        $who_fract = "X";
        $who_turn = "true";
    }
    else{
        $who_fract = "O";
        $who_turn = "false";
    }

    $app->Game_start_insert($who,$who_fract,$who_turn,$opponent);

    echo json_encode(new Client($who,$who_fract,$who_turn,$opponent));

}
else{
    if($who_fract == "X"){
        $who_fract = "O";
        $who_turn = "false";
    }
    else{
        $who_fract = "X";
        $who_turn = "true";
    }
    echo json_encode(new Client($opponent,$who_fract,$who_turn,$who));
}
