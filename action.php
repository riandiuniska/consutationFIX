<?php

    require "./db/Ports.php";
    require "./db/Chats.php";
    require "./db/Users.php";
    require "api/get_request.php";

    // require ".db/Groups.php";
    
    // PORT
    $objPort = new Ports;
    $objPort->set_group_id($_POST['group_id']);
    $portsData = $objPort->get_port_by_group_id();

    

    if(!empty($portsData)) {
        // echo $portsData['value'];
        $chats = new Chats;
        $chat = $chats->getChatByGroup($_POST['group_id']);

        
        // var_dump($chat);
        // die();

        // $objUser = new Users;
        // $objUser->setEmail($_POST['user_email']);
        // $userData = $objUser->getUserByEmail();

        // $userData = json_decode(file_get_contents('https://i0ifhnk0.directus.app/items/user?filter={"user_email":"' .$_POST['user_email'].'"}'), true);
        // $data = $userData['data'];
        // $userId = $data[0]['user_id'];

        $token = $_COOKIE['X-LUMINTU-REFRESHTOKEN'];
        $users = (json_decode(http_request_with_auth("https://account.lumintulogic.com/api/users.php", $token))->{'user'});



        for($i=0;$i<count($chat);$i++){
            for($j = 0; $j<count($users);$j++){
                if($chat[$i]['user_id'] == (int)($users[$j]->user_id)){
                    $chat[$i]['username'] = $users[$j]->user_username;
                }
            }
        }


        // $chat[0]['nama'] = 'alba';
        // var_dump($chat); 
        // die();

        for($i=0;$i<count($users); $i++){
            if($users[$i]->user_email == $_POST['user_email'] ){
                $userData = $users[$i];
                $userId = $userData->user_id;
                break;
            }
        }
    
        // echo json_encode($chat);

        $arr = [
            'portData' => $portsData['value'],
            'message' =>$chat,
            'userId' =>$userId
        ];

        echo json_encode($arr);
    } else {
        $objPort->set_status(0);
        $port = $objPort->get_all_free_port();
        
        if(!empty($port)) {
            foreach($port as $key => $port) {
                if($port['status'] == 0) {
                    $freePort = $port['value'];
                    break;
                }
            }
            $objPort->set_status(1);
            $objPort->set_group_id($_POST['group_id']);
            $objPort->set_value($freePort);
            $objPort->update_port_status();
            echo $freePort;
        } else {
            echo "Port is full!";
        }
    }

    ?>
