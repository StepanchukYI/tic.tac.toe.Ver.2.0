<?php
$app = new Application();
$elem = new Elements();

$lang = $_REQUEST['lang'];

$row = $app->Local($lang);


$elem->$lang = $row[0]['lang'];
$elem->$txt_login =$row[0]['txt_login'];
$elem->$txt_pass = $row[0]['txt_pass'];
$elem->$btn_auth = $row[0]['btn_auth'];
$elem->$txt_email = $row[0]['txt_email'];
$elem->$txt_pass2 = $row[0]['txt_pass2 '];
$elem->$btn_reg = $row[0]['btn_reg'];
$elem->$register = $row[0]['register'];
$elem->$vhod = $row[0]['vhod'];
$elem->$login = $row[0]['login'];
$elem->$uzhe = $row[0]['uzhe'];
$elem->$btn_refresh = $row[0]['btn_refresh'];
$elem->$btn_quit = $row[0]['btn_quit '];
$elem->$returnn = $row[0]['returnn'];
$elem->$finish = $row[0]['finish'];

echo json_encode($elem);