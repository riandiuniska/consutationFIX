<?php

    require "../api/get_request.php";
    require "../db/Users.php";
    require "../db/Availability.php";

    session_start();


    if(!empty($_POST['send'])){
        $objUser = new Users;

        $_POST['user_id'];
    
        $objUser->setId($_POST['user_id']);
    
        // $response = json_decode(file_get_contents('https://i0ifhnk0.directus.app/items/user?filter={"user_id":"' .$_POST['user_id'].'"}'), true);
        // $userData = $response['data'];

        $token = $_COOKIE['X-LUMINTU-REFRESHTOKEN'];
        $users = (json_decode(http_request_with_auth("https://account.lumintulogic.com/api/users.php", $token))->{'user'});

        for($i=0;$i<count($users); $i++){
            if($users[$i]->user_id == $_POST['user_id'] ){
                $userData = $users[$i];
                break;
            }
        }


        $objAva = new Availability;

        $avaData = $objAva->getDataById($_POST['user_id']);

        $data = [
            'ava' => $avaData,
            'user' => $userData
        ];

        echo JSON_encode($data);
    }




?>