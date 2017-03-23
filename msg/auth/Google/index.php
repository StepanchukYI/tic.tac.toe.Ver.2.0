<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>Аутентификация через Google</title>
</head>
<body>

<?php

$client_id = '782280748456-20m3038rcmn4nk9oa735bcj2a4co6iph.apps.googleusercontent.com'; // Client ID
$client_secret = 'ql07ZKZ9O7606MmJxEI8vGbz'; // Client secret
$redirect_uri = 'http://localhost/tic.tac.toe/tic.tac.toe/msg/auth/google/index.php'; // Redirect URIs

$url = 'https://accounts.google.com/o/oauth2/auth';

$params = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);

$gg = $url . '?' . urldecode(http_build_query($params));

echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Google</a></p>';

if (isset($_GET['code'])) {
    $result = false;

    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );

    $url = 'https://accounts.google.com/o/oauth2/token';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token'])) {
        $params['access_token'] = $tokenInfo['access_token'];

        $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['id'])) {
            $userInfo = $userInfo;
            $result = true;
        }
    }

    if ($result) {
        $sql_query = "SELECT login,xo_online,chat_online,fb_id,google_id FROM clients WHERE fb_id='" . $userInfo['id'] . "'";
        $result_set = mysqli_query($h, $sql_query);
        $row = mysqli_fetch_row($result_set);

        if ($row[1] != "true") {
            if ($user->id == $row[3]) {
                $sql_query = "UPDATE clients SET xo_online = 'true', login = '".$userInfo['name']."'  WHERE google_id='" . $userInfo['id'] . "'";
                $result_set = mysqli_query($h, $sql_query);
                echo json_decode($row);

                setrawcookie('xo_auth_log', $userInfo['name'], time() + 86400, '/');
                setrawcookie('xo_auth_pass', $userInfo['id'], time() + 86400, '/');

                echo "OK";

                header('Location: ../../../client.html');
            } else {
                $sql_query = "INSERT INTO clients(login,password,email,banned,google_id,xo_online) VALUES('".$userInfo['name']."', '".$userInfo['id']."','".$userInfo['emaid']."','false','".$userInfo['id']."', 'true')";
                mysqli_query($h, $sql_query);
                echo "OK";

                setrawcookie('xo_auth_log', $userInfo['name'], time() + 86400, '/');
                setrawcookie('xo_auth_pass', $userInfo['id'], time() + 86400, '/');

                header('Location: ../../../client.html');
            }
        } else {
            echo "User online";

            header('Location: ../../../client.html');
        }

    }

}



?>

</body>
</html>
