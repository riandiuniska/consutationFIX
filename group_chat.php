<?php

session_start();
require("db/Users.php");


if(!isset($_SESSION['user'])) {
    header("location: login.php");
}

$objUser = new Users;
$objUser->setEmail($_SESSION['user']);
$user = $objUser->getUserByEmail();
echo "<input type='hidden' name='userId' id='userId' value='" . $user['user_id'] . "'>"; 


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
                    require "./db/Groups.php";
                    $objGroup = new Groups;
                    $groups = $objGroup->get_all_groups();

                    foreach($groups as $key => $group) {                                                    
                
                ?>
                    <div onclick="requestChat(<?=$group['group_id'];?>)">
                        <div class="flex items-center space-x-4 bg-gray-200 h-[80px] px-2 cursor-pointer border-b-2">
                            <img class="w-[50px] h-[50px] rounded-full" src="./img/dummy/people.jpg" alt="Profile Image">
                            <div class="flex flex-col">
                                <span class="font-semibold"><?=$group['group_name']?></span>
                            </div>
                        </div>
                        <hr class="border border-gray-300">
                    </div>

                <?php 
                    }
                ?>
            </div>
        </div>
        <!-- Right Side  -->
        <div class="flex-grow h-screen bg-yellow-200">
            <form class="" action="" method="POST">
                <input class="" type="text" name="message" id="message" placeholder="Enter messages...">
                <button class="" type="submit" name="send" id="send">Kirim</button>
            </form>
        </div>
    </div>

    <script>
        function requestChat(id) {
            $.ajax({
                method: "POST",
                data: {
                    group_id: id
                },
                url: "action.php",
                success: function(data, status) {
                    // console.log(data);
                    requestNewWSConnection(data);
                    var conn = new WebSocket("ws://localhost:" + data);
                    conn.onopen = function(e) {
                        console.log("Connection Establish...");
                    }

                    conn.onmessage = function(e) {
                        console.log(e.data);
                    }

                    $("#send").click(function(e) {
                        e.preventDefault();
                        let message = document.getElementById("message").value;
                        let uid = document.getElementById("userId").value;

                        var data = {
                            user_id: uid,
                            msg: message
                        };

                        conn.send(JSON.stringify(data));
                    })
                }
            })
        }

        function requestNewWSConnection(data) {
            $.post("./bin/chat-server.php", {
                data: data
            }, function(data, status) {
                console.log(data);
            })
        }
            
    </script>
</body>
</html>