<?php
require("../classes/Application.php");
require("../classes/Sqr.php");

$who = $_REQUEST["who"];
$opponent = $_REQUEST["opponent"];

$app = new Application();

$row = $app->Game_check($who,$opponent);

$max = count($row);

$sqr = new Sqr();

if(mysqli_num_rows($result_set) > 0) {

    while ($row = mysqli_fetch_row($result_set)) {

        if($row[2] == "1"){
            $sqr->sqr1 = $row[3];
        }
        if($row[2] == "2"){
            $sqr->sqr2 = $row[3];
        }
        if($row[2] == "3"){
            $sqr->sqr3 = $row[3];
        }
        if($row[2] == "4"){
            $sqr->sqr4 = $row[3];
        }
        if($row[2] == "5"){
            $sqr->sqr5 = $row[3];
        }
        if($row[2] == "6"){
            $sqr->sqr6 = $row[3];
        }
        if($row[2] == "7"){
            $sqr->sqr7 = $row[3];
        }
        if($row[2] == "8"){
            $sqr->sqr8 = $row[3];
        }
        if($row[2] == "9"){
            $sqr->sqr9 = $row[3];
        }
    }

    check($sqr, $max);
    echo json_encode($sqr);
}

function check(Sqr $sqr, $max){

    if ($sqr->sqr1 == $sqr->sqr2 && $sqr->sqr2 == $sqr->sqr3 && $sqr->sqr3 != "")
    {
        $sqr->game_res = $sqr->sqr3 . " WIN!";
    } else if ($sqr->sqr4 == $sqr->sqr5 && $sqr->sqr4 == $sqr->sqr6 && $sqr->sqr6 != "")
    {
        $sqr->game_res = $sqr->sqr4 . " WIN!";
    } else if ($sqr->sqr7 == $sqr->sqr8 && $sqr->sqr8 == $sqr->sqr9 && $sqr->sqr9 != "")
    {
        $sqr->game_res = $sqr->sqr9 . " WIN!";
    } else if ($sqr->sqr1 == $sqr->sqr5 && $sqr->sqr5 == $sqr->sqr9 && $sqr->sqr9 != "")
    {
        $sqr->game_res = $sqr->sqr9 . " WIN!";
    } else if ($sqr->sqr1 == $sqr->sqr4 && $sqr->sqr4 == $sqr->sqr7 && $sqr->sqr7 != "")
    {
        $sqr->game_res = $sqr->sqr7 . " WIN!";
    } else if ($sqr->sqr2 == $sqr->sqr5 && $sqr->sqr5 == $sqr->sqr8 && $sqr->sqr8 != "")
    {
        $sqr->game_res = $sqr->sqr8 . " WIN!";
    } else if ($sqr->sqr3 == $sqr->sqr6 && $sqr->sqr6 == $sqr->sqr9 && $sqr->sqr9 != "")
    {
        $sqr->game_res = $sqr->sqr9 . " WIN!";
    } else if ($sqr->sqr1 == $sqr->sqr5 && $sqr->sqr5 == $sqr->sqr9 && $sqr->sqr9 != "")
    {
        $sqr->game_res = $sqr->sqr9 . " WIN!";
    } else if ($sqr->sqr3 == $sqr->sqr5 && $sqr->sqr5 == $sqr->sqr7 && $sqr->sqr7 != "")
    {
        $sqr->game_res = $sqr->sqr7 . " WIN!";
    } else if($max== 10)
    {
        $sqr->game_res = "Draw";
    }
    else{
        $sqr->game_res = "";
    }
}


