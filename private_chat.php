<?php

session_start();
require "./db/Users.php";

if(!isset($_SESSION['user'])) {
    header("location: login.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Chat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="flex items-center">
        <div class="w-3/12 bg-blue-200 h-screen">
            <!-- Left Side -->
            <div class="py-5 bg-gray-200">
                <h1 class="text-center font-bold text-2xl">Welcome to Private Chat</h1>
            </div>
            <hr class="border border-gray-200 my-4 mx-2">
            <div class="px-2 overflow-scroll-y">
                <!-- Contact -->
                <?php 
                    $objUser = new Users;
                    $users = $objUser->getAllUser();

                    foreach($users as $key => $user) {
                        if($user['email'] !== $_SESSION['user']) {
                            $status_login = "";
                            if($user['login_status'] == 1) {
                                $status_login = "Online";
                            } else {
                                $status_login = "Offline";
                            }
                                                    
                
                ?>
                    <div>
                        <div class="flex items-center space-x-4 bg-gray-200 h-[80px] px-2 cursor-pointer border-b-2">
                            <img class="w-[50px] h-[50px] rounded-full" src="./img/dummy/people.jpg" alt="Profile Image">
                            <div class="flex flex-col">
                                <span class="font-semibold"><?=$user['name']?></span>
                                <small class="text-sm"><?=$status_login?></small>
                            </div>
                        </div>
                        <hr class="border border-gray-300">
                    </div>

                <?php 
                        }
                    }
                ?>
            </div>
        </div>
        <!-- Right Side  -->
        <div class="flex-grow h-screen bg-yellow-200">

        </div>
    </div>
</body>
</html>