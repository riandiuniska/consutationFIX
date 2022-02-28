<?php 

require "db/Users.php";

if(isset($_POST['join'])) {

    session_start();

    $objUser = new Users;

    $objUser->setName($_POST['username']);
    $objUser->setEmail($_POST['email']);
    $objUser->setLoginStatus(1);
    $objUser->setLastLogin(date("Y-m-d h:i:s"));

    $userData = $objUser->getUserByEmail();

    if(is_array($userData) && count($userData) > 0) {
        $objUser->setId($userData['user_id']);
        if($objUser->updateLoginStatus()) {
            $_SESSION['user'][$userData['user_id']] = $userData;
            header("location: chatroom.php");
            echo "User berhasil masuk";
        } else {
            echo "User gagal masuk";
        }
    } else {
        if($objUser->insertData()) {
            echo "Data tersimpan";
            $_SESSION['user'][$userData['user_id']] = (array) $objUser;
            var_dump($_SESSION['user']);
            header("location: chatroom.php");
        } else {
            echo "Data tidak tersimpan";
        }
    }

    
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
</head>
<body>
    <h1>This is a Chat Room</h1>
    <br>
    <form action="" method="POST">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username">
        <label for="email">Email: </label>
        <input type="text" name="email" id="email">
        <button type="submit" name="join">Join</button>
    </form>
</body>
</html>