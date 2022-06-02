<div class="bg-white w-[350px] h-screen px-8 py-6 flex flex-col justify-between sidebar in-active">

    <!-- Top nav -->
    <div class="flex flex-col gap-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4 px-2">
            <img src="Img/icons/toggle_icons.svg" alt="toggle_dashboard" class="w-8 cursor-pointer" id="btnToggle">
            <img class="logo-smk  w-[150px] " src="../src/logo_lumintu.png" alt="Logo SMK">
        </div>

        <hr class="border-[1px] border-opacity-50 border-[#93BFC1]">


        <!-- List Menus -->
        <div>
            <ul class="flex flex-col gap-y-1">
                <li>
                    <a href="https://account.lumintulogic.com/" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="./Img/icons/home_icon.svg" alt="Dashboard Icon">
                        <p class="font-semibold">Beranda</p>
                    </a>
                </li>
                <li>
                    <a href="https://lessons.lumintulogic.com/auth.php?token=<?= $_COOKIE['X-LUMINTU-REFRESHTOKEN'] ?>&expiry=<?= $_SESSION['expiry'] ?>" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="./Img/icons/course_icon.svg" alt="Course Icon">
                        <p class="font-semibold">Materi</p>
                    </a>
                </li>
                <li>
                    <a href="https://assignment.lumintulogic.com/auth.php?token=<?= $_COOKIE['X-LUMINTU-REFRESHTOKEN'] ?>&expiry=<?= $_SESSION['expiry'] ?>&page=index" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="./Img/icons/assignment_icon.svg" alt="Course Icon">
                        <p class="font-semibold">Penugasan</p>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 bg-cream">
                        <img class="w-5" src="./Img/icons/consult_icon.svg" alt="Consult Icon">
                        <p class="text-white font-semibold">Konsultasi</p>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                        <img class="w-5" src="./Img/icons/schedule_icon.svg" alt="Schedule Icon">
                        <p class="font-semibold">Jadwal</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Bottom nav -->
    <div>
        <ul class="flex flex-col ">
            <li>
                <a class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                    <img class="w-5" src="./Img/icons/help_icon.svg" alt="Help Icon">
                    <p class="font-semibold">Bantuan</p>
                </a>
            </li>
            <li>
                <a href="../../logout.php" class="flex items-center gap-x-4 h-[50px] rounded-xl px-4 hover:bg-cream text-dark-green hover:text-white">
                    <img class="w-5" src="./Img/icons/logout_icon.svg" alt="Log out Icon">
                    <p class="font-semibold">Keluar</p>
                </a>
            </li>
        </ul>
    </div>
</div>

