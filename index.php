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
    <script type="text/javascript" src="msg/command/jquery-3.2.0.min.js"></script>
</head>
<body>
<div class="frame">
    <nav>
        <ul class="lable">
            <li class="vhod">Вход</li>
            <li>
                <div id="pass_msg" class="msg"></div>
            </li>
        </ul>
        <ul class="auth">
            <li>
                <div>
                    <input type="text" class="txt_login" id="txt_login" placeholder="Ваше имя"/>
                </div>
            </li>
            <li>
                <div>
                    <input type="password" class="txt_pass" id="txt_pass" placeholder="Пароль"/>
                </div>
            </li>
            <li><input type="button" class="btn_auth" id="btn_auth" value="Войти"
                       onclick="Auth(txt_login.value, txt_pass.value)"/></li>
            <li>
                <ul class="social_a">
                    <li><a href="<?= $path; ?>" class="auth auth_fb">Войти через ФБ</a></li>
                    <li><a href="<?= $gg; ?>" class="auth auth_gg">Войти через гугл</a></li>
                </ul>
            </li>
        </ul>
        <ul class="link">
            <a id="link reg" href="register.html">Первый раз на сайте?</a>
            <a id="link pwd" href="forgot_pass.html">Забыли пароль?</a>
        </ul>
    </nav>
</div>
<!--<div class="tooltip">
    <div class="tooltip tooltip_password">Textbox for password</div>
    <div class="tooltip tooltip_login">Textbox for login</div>
    <div class="tooltip tooltip_email">Textbox for email</div>
    <div class="tooltip tooltip_repass">Textbox for repassword</div>
</div>
-->
</body>
</html>

