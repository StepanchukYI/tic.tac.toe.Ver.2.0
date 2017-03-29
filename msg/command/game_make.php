<?php
require("../classes/Application.php");

$who = $_REQUEST["who"];
$opponent = $_REQUEST["opponent"];
$block = $_REQUEST["block"];

$sql_query = "SELECT who,opponent, block FROM game WHERE who ='".$who."'
              AND opponent ='".$opponent."' AND block ='".$block."' OR who ='".$opponent."'
              AND opponent ='".$who."' AND block ='".$block."'";
    $result_set = mysqli_query($h, $sql_query);

if(mysqli_num_rows($result_set) == 0) {

    $sql_query = "SELECT MAX(id) FROM game WHERE who ='".$who."' AND opponent ='".$opponent."'
                  OR who ='".$opponent."' AND opponent ='".$who."'";
    $result_set = mysqli_query($h, $sql_query);
    $max = mysqli_fetch_row($result_set);


    $sql_query = "SELECT MAX(id), who, who_fract, who_turn, opponent, block, value FROM game 
                  WHERE who ='".$who."' AND opponent ='".$opponent."' AND id ='".$max[0]."'
                  OR who ='".$opponent."' AND opponent ='".$who."' AND id ='".$max[0]."'";

    $result_set = mysqli_query($h, $sql_query);
    $row = mysqli_fetch_row($result_set);

        if($who == $row[1]){
            if($row[3]=="true"){
                $sql_query = "INSERT INTO game(who, who_fract, who_turn, opponent ,block ,value) VALUES('$who', '$row[2]', 'false', '$opponent', '$block', '$row[2]')";
                $result_set = mysqli_query($h, $sql_query);
            } else {
                echo "Wait your turn";
            }

        }
        if($who == $row[4]){
            if($row[3]=="false"){
                if($row[2] == "X"){
                    $fract = "O";
                } else{
                    $fract = "X";
                }
                $sql_query = "INSERT INTO game(who, who_fract, who_turn, opponent ,block ,value) VALUES('$row[1]', '$row[2]', 'true', '$row[4]', '$block', '$fract')";
                $result_set = mysqli_query($h, $sql_query);
            } else {
                echo "Wait your turn";
            }
        }
}else
{
    echo "Take another one!)";
}


