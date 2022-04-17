<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("location: login.php");
}

require "./db/Users.php";
require("./db/Chats.php");


$objUsers = new Users;
$objUsers->setEmail($_SESSION['user']);
$user = $objUsers->getUserByEmail();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group Chat</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>

    <style>
        body {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Wellcome to chat, <?= $user['name'] ?> </h1>

        <h3>Bimbingan yang tersedia untuk anda</h3>

        <div class="card" style="width: 18rem;">
            <img src="..." class="card-img-top" alt="...">
            <div class="text-center">
                <a href="#" data-toggle="modal" data-target="#exampleModal">
                    <h3>Materi 1</h3>
                </a>
            </div>
            <div class="card-body">
                <p>Member</p>
                <p>Member 1</p>
                <p>Member 2</p>
                <p>Member 3</p>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chat</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php

                            $chats = new Chats;
                            $chat = $chats->getAllChat();

                            foreach ($chat as $key => $chat) {
                                $objUser = new Users;
                                $objUser->setEmail($_SESSION['user']);
                                $userData = $objUser->getUserByEmail();
                                $userId = $userData['user_id'];

                                $styleBox = '';

                                if ($chat['user_id'] == $userId) {
                                    $styleBox = 'float-right';
                                    $chat['name'] = "Me";
                                } else {
                                    $styleBox = 'float-left';
                                }

                                echo '<div class="max-w-fit ' . $styleBox . ' rounded-xl px-4 py-2 ..."><small class="font-semibold">' . $chat['name'] .
                                    '</small><p class="">' . $chat['message'] .
                                    '</p><p class="text-right text-xs text-gray-400 ">' . $chat['created_at'] .
                                    '</p></div>';
                            }

                            ?>
                        </div>
                        <form class="mx-auto flex" action="" method="POST">
                            <input class="px-2 py-1 flex-1 border border-gray-400 outline-none" type="text" name="message" id="message" placeholder="Enter messages...">
                            <button class="w-[80px] bg-blue-500" type="submit" name="send" id="send">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>



        </div>

    </div>

    <script>
        $(document).ready(function() {
            // Initialize new websocket connection
            var conn = new WebSocket('ws://localhost:8080');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };

            // Receive sent message
            conn.onmessage = function(e) {
                console.log(e.data);
                data = JSON.parse(e.data);

                var styleBox = '';

                if(data.from == "Me") {
                    styleBox = 'bg-red-200 text-right ml-auto';
                } else {
                    styleBox = 'bg-green-200 text-left';
                }
                
                var box = '<div class="' + styleBox + ' max-w-fit rounded-xl px-4 py-2 ..."><small class="font-semibold">' + data.from + 
                '</small><p class="">' + data.msg + 
                '</p><p class="text-right text-xs text-gray-400 ">' + data.dt + 
                '</p></div>';

                $("#chat-container").append(box);

            };

            // Trigger button for send message
            $("#send").click(function(event) {
                event.preventDefault();
                var msg = $("#message").val();
                var uid = $("#userId").val();

                var data = {
                    user_id: uid,
                    msg: msg
                };

                // Sent message
                conn.send(JSON.stringify(data));

                $("#message").val("");
            })
        })
    </script>


</body>

</html>