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
        <div class="w-9/12 h-screen bg-yellow-200">
            <div class="w-full h-[90%] mx-auto p-4 flex flex-col gap-y-2 overflow-y-scroll" id="chat-container">

            </div>
            <form class="w-9/12 fixed bottom-0 flex mb-0 h-[10%]" action="" method="POST">
                <input class="px-4 py-1 flex-1 border border-gray-200 outline-none" type="text" name="message" id="message" placeholder="Enter messages...">
                <button class="w-[80px] bg-blue-500 text-white" type="submit" name="send" id="send">Kirim</button>
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
                        data = JSON.parse(e.data);

                        var styleBox = '';

                        if(data.from == "Me") {
                            styleBox = 'bg-red-200 text-right ml-auto';
                        } else {
                            styleBox = 'bg-green-200 text-left';
                        }
                        
                        if(data.group_id == id) {
                            var box = '<div class="' + styleBox + ' max-w-fit rounded-xl px-4 py-2 ..."><small class="font-semibold">' + data.from + 
                            '</small><p class="">' + data.msg + 
                            '</p><p class="text-right text-xs text-gray-400 ">' + data.dt + 
                            '</p></div>';

                            $("#chat-container").append(box);
                        }
                        
                    }

                    $("#send").click(function(e) {
                        e.preventDefault();
                        let message = document.getElementById("message").value;
                        let uid = document.getElementById("userId").value;

                        let chatData = {
                            user_id: uid,
                            msg: message,
                            group_id: id,
                        };

                        conn.send(JSON.stringify(chatData));

                        document.getElementById("message").value = "";
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