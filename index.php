<?php
require "msg/auth/fb/config.php";
require "msg/auth/fb/functions.php";

$path = URL_AUTH . "?" . "client_id=" . CLIENT_ID . "&redirect_uri=" . urlencode(REDIRECT) . "&response_type=code";

$client_id = '782280748456-20m3038rcmn4nk9oa735bcj2a4co6iph.apps.googleusercontent.com'; // Client ID
$client_secret = 'ql07ZKZ9O7606MmJxEI8vGbz'; // Client secret
$redirect_uri = 'http://localhost/tic.tac.toe/tic.tac.toe/msg/auth/google/index.php'; // Redirect URIs

$url = 'https://accounts.google.com/o/oauth2/auth';

$params = array(
    'redirect_uri' => $redirect_uri,
    'response_type' => 'code',
    'client_id' => $client_id,
    'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);

$gg = $url . '?' . urldecode(http_build_query($params));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tic Tac Toe</title>
    <link rel="stylesheet" type="text/css" href="msg/style/style.css">
    <script type="text/javascript" src="msg/command/command.js"></script>
</head>
<body>
<div class="frame">
    <h3 class="lb_Enter">Вход</h3>
    <div id="pass_msg" class="msg"> Something for help</div>
    <div class="auth">
        <input type="text" class="txt_login" id="txt_login" placeholder="Ваше имя"/>
        <input type="password" class="txt_pass" id="txt_pass" placeholder="Пароль"/>
        <input type="button" class="btn_auth" id="btn_auth" value="Войти"
               onclick="Auth(txt_login.value, txt_pass.value)"/>
        <ul>
            <li><a href="<?= $path; ?>" class="auth auth_fb">Войти через ФБ</a></li>
            <li><a href="<?= $gg; ?>" class="auth auth_gg">Войти через гугл</a></li>
        </ul>
    </div>
    <div class="link">
        <ul>
            <li>
                <a id="link reg" href="register.html">Первый раз на сайте?</a>
            </li>
            <li>
                <a id="link pwd" href="forgot_pass.html">Забыли пароль?</a>
            </li>
        </ul>
    </div>
</div>
</body>
</html>

