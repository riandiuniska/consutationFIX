<?php 

require("db/Users.php");
session_start();

if(!isset($_SESSION['user'])){
    header("location: login.php");
}

$obj = new Users;
$users = $obj->getAllUser();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="w-10/12 mx-auto flex flex-col items-center py-10 gap-y-4">
        <h1 class="text-center text-4xl font-semibold">Chat Room</h1>
        <p class="text-center font-lg mt-10">Daftar User</p>
        <table class="border mx-auto">
            <thead>
                <th>Name</th>
                <!-- <th>Email</th> -->
                <th>Last Login</th>
                <th>Status</th>
            </thead>
            
            <tbody>
                <?php 
                    foreach($users as $key => $users) { 
                        $loginStatus = '';
                        if($users['login_status'] == 1) {
                            $loginStatus = "Online";
                        } else {
                            $loginStatus = "Offline";
                        }
                        if($users['email'] !== $_SESSION['user']) {
                ?>
                            <tr>
                                <?php
                                    echo "<input type='hidden' name='userId' id='userId' value='" . $users['user_id'] . "'>";
                                    echo "<td>" . $users['name'] . "</td>";
                                    // echo "<td>" . $users['email'] . "</td>"; 
                                    echo "<td>" . $users['last_login'] . "</td>";
                                    echo "<td>" . $loginStatus . "</td>";
                                ?>
                            </tr>
                    
                <?php 
                        }
                    } 
                ?>
            </tbody>
        </table>

        <a class="bg-red-500 px-4 py-1 text-white rounded-lg mx-auto" href="logout.php">Logout</a>

        <div class="w-full">
            <div class="bg-gray-200 w-8/12 h-[400px] mx-auto mt-10 p-4 flex flex-col gap-y-2 overflow-y-scroll" id="chat-container">
                <div class="bg-yellow-200 rounded-lg px-4 py-2 max-w-fit mx-auto">
                    <p>Mohon gunakan bahasa yang sopan!</p>
                </div>
            </div>
            <form class="w-8/12 mx-auto flex" action="" method="POST">
                <input class="px-2 py-1 flex-1 border border-gray-400 outline-none" type="text" name="message" id="message" placeholder="Enter messages...">
                <button class="px-4 py-1 bg-blue-500 text-white" type="submit" name="send" id="send">Kirim</button>
            </form>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            var conn = new WebSocket('ws://localhost:8080');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };

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

            $("#send").click(function(event) {
                event.preventDefault();
                var msg = $("#message").val();
                var uid = $("#userId").val();

                var data = {
                    user_id: uid,
                    msg: msg
                };
                conn.send(JSON.stringify(data));

                $("#message").val("");
            })
        })
    </script>
</body>
</html>