<?php
require("../classes/Application.php");

$who = $_REQUEST["who"];
$opponent = $_REQUEST["opponent"];
$block = $_REQUEST["block"];
$app = new Application();
if($app->Game_make_num($who,$opponent,$block) == 0) {

// не работает!!! ОБРАТИ ВНИМАНИЕ!!!
    $app->Game_make_select($who,$opponent);

        if($who == $row[0]['who']){
            if($row[0]['who_turn']=="true"){
                $app->Game_make_insert($who,$row[0]['who_fract'], "false", $opponent, $block, $row[0]['who_fract'] );
            }
            else {
                echo "Wait your turn";
            }
        }
        if($who == $row[0]['opponent']){
            if($row[0]['who_turn']=="false") {
                if ($row[0]['who_fract'] == "X") {
                    $fract = "O";
                }
                else {
                    $fract = "X";
                }
                $app->Game_make_insert($row[0]['who'],$row[0]['who_fract'], "true", $opponent, $block, $fract );
            }
            else {
                echo "Wait your turn";
            }
        }
}
else
{
    echo "Take another one!)";
}


