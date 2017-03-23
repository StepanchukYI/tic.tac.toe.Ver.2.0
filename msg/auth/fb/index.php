<?php
require "config.php";
require "functions.php";


$path = URL_AUTH . "?" . "client_id=" . CLIENT_ID . "&redirect_uri=" . urlencode(REDIRECT) . "&response_type=code";

?>

<a href="<?= $path; ?>"> Adasdasd</a>