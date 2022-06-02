<div class="bg-white w-full h-[50px] flex content-center px-10  rounded-xl">
                <?php $classActive = 'text-dark-green text-cream border-b-4 border-cream h-[50px] flex items-center font-semibold  cursor-pointer';
                    $classDiss = 'text-dark-green hover:text-cream hover:border-b-4 hover:border-cream h-[50px] flex items-center font-semibold  cursor-pointer' ?>
                <ul class="flex items-center gap-x-8">
                    <li class="<?php $_SERVER['REQUEST_URI'] == '/websocket/web-chat-room/frontend/pages/daftarRequest.php' ? $classActive : $classDiss; ?>">
                        <a href="mentor_approve.php"><p>Session</p></a>
                    </li>
                    <a href="mentor.php"><li class="<?php $_SERVER['REQUEST_URI'] == '/websocket/web-chat-room/frontend/pages/index.php' ? 'text-dark-green text-cream border-b-4 border-cream h-[50px] flex items-center font-semibold  cursor-pointer' : $classDiss ?>">
                         Booking 
                    </li></a>
                </ul>
            </div>

            