<?php

function http_request_with_auth($url, $token) {

    $auth = "Authorization: Bearer " . $token;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $auth));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    $out = curl_exec($ch);
    curl_close($ch);

    if (curl_errno($ch)) { 
        print curl_error($ch); 
    } 

    return $out;
}