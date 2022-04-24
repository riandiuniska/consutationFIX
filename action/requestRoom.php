<?php

    require "../db/Users.php";




    if(!empty($_POST['send'])){
        $objUser = new Users;

        $_POST['user_id'];
    
        $objUser->setId($_POST['user_id']);
    
        $userData = $objUser->getUserById();

        echo JSON_encode($userData);
    }




?>