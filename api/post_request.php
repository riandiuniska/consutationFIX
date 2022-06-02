<?php

function post_request($url, $data) {
    // $ch = curl_init($url);

    // curl_setopt($ch, CURLOPT_POST, 1);
    // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // $result = curl_exec($ch);

    $ch = curl_init ($url);
    curl_setopt_array ( $ch, array (
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
    ) );
    $result = curl_exec($ch);

    if (curl_errno($ch)) { 
        print curl_error($ch); 
    } 

    curl_close($ch);

    return($result);
}

?>