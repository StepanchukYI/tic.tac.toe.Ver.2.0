<?php
function get_token($code)
{
    $ku = curl_init();
    $query = "client_id=" . CLIENT_ID . "&redirect_uri=" . urlencode(REDIRECT) .
        "&client_secret=" . SECRET . "&code=" . $code;

    curl_setopt($ku, CURLOPT_URL, TOKEN . "?" . $query);
    curl_setopt($ku, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ku);
    if (!$result) {
        exit(curl_error($ku));
    }

    if ($i = json_decode($result)) {
        if ($i->error) {
            exit($i->error->message);

        }
    } else {
        parse_str($result, $token);
        if ($token['access_token']) {
            return $token['access_token'];
        }

    }

}

function get_data($token)
{

    $ku = curl_init();
    $query = "fields=id,email,first_name&access_token=" . $token;

    curl_setopt($ku, CURLOPT_URL, GET_DATA . "?" . $query);
    curl_setopt($ku, CURLOPT_RETURNTRANSFER, TRUE);

    $result = curl_exec($ku);
    if (!$result) {
        exit(curl_error($ku));
    }

    return json_decode($result);
}
?>

