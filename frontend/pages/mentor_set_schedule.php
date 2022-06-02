<?php

include_once '../../db/Acceptance.php';
include_once '../../db/Availability.php';

// var_dump($_SERVER['REQUEST_URI']); die();


session_start();

$loginPath = "../../login.php";
if (!isset($_COOKIE['X-LUMINTU-REFRESHTOKEN'])) {
    unset($_SESSION['user_data']);
    header("location: " . $loginPath);
}
if (!isset($_SESSION['user_data'])) {
    header('location:' . $loginPath);
}

$user = $_SESSION['user_data']->user;

switch ($_SESSION['user_data']->{'user'}->{'role_id'}) {
        // KONDISI KETIKA USER MEMASUKI HALAMAN NAMUN LOGIN SEBAGAI ADMIN
    case 1:
        echo "
        <script>

            location.replace('admin.php');
        </script>
        ";
        break;
        // KONDISI KETIKA USER MEMASUKI HALAMAN NAMUN LOGIN SEBAGAI STUDENT
    case 3:
        echo "
        <script>

            location.replace('index.php');
        </script>
        ";
        break;
    default:
        break;
}

// var_dump($user);

// availability
$objAva = new Availability;
$dataAva = $objAva->getDataById($user->user_id);
// var_dump($dataAva);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Schedule</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <!-- Tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/index.min.css" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        montserrat: ["Montserrat"],
                    },
                    colors: {
                        "dark-green": "#1E3F41",
                        "light-green": "#659093",
                        "cream": "#DDB07F",
                        "cgray": "#F5F5F5",
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar #username_logo {
            display: none;
        }

        #profil_image {
            display: none !important;
        }

        .responsive-top {
            display: none;
        }

        .active {
            color: #DDB07F !important;
            border-bottom: solid 4px #DDB07F;
        }

        .in-active {
            width: 80px !important;
            padding: 20px 15px !important;
            transition: .5s ease-in-out;
        }

        .in-active ul li p {
            display: none !important;
        }

        .in-active ul li a {
            padding: 15px !important;
        }

        .in-active h2,
        .in-active h4,
        .in-active .logo-smk {
            display: none !important;
        }

        .hidden {
            display: none !important;
        }

        .sidebar {
            transition: .5s ease-in-out;
        }

        @media screen and (max-width: 414px) {
            .responsive-top {
                display: block;
            }

            #profil_image {
                display: flex !important;
            }

            .logo-smk {
                display: none !important;
            }

            .assignment-table th,
            .assignment-table td {
                font-size: 9px;
            }

            .assignment-table img {
                width: 45%;
            }

            .sidebar h2,
            .sidebar h4,
            .sidebar .logo-incareer,
            .sidebar hr,
            .sidebar #btnToggle {
                display: none !important;
            }

            .sidebar #username_logo {
                display: block;
                margin: 0;
            }

            .breadcrumb ul {
                font-size: .5rem;
            }

            .topic-title p {
                font-size: 1.35rem;
            }

            .mentor-profile img {
                width: 20%;
            }

            .mentor-profile p {
                font-size: .5rem;
            }

            .direction p {
                font-size: .5rem;
            }

            .tab-menu ul {
                font-size: .6rem;
            }

            .in-active {
                width: 80px !important;
                padding: 10px 15px !important;
                transition: .5s ease-in-out;
            }


            .sidebar {
                position: absolute;
                z-index: 1;
            }

            .rightbar {
                margin-left: 80px;
            }


        }
    </style>

</head>

<body>
    <div class="responsive-top p-5">
        <div class="container flex flex-column justify-between mt-4 mb-4">
            <img class="w-[150px] logo-smk1" src="../src/logo_lumintu.png" alt="Logo SMK">
            <img src="Img/icons/toggle_icons.svg" alt="toggle_dashboard" class="w-8 cursor-pointer" id="btnToggle2">
        </div>
    </div>
    <div class="flex items-center">
        <!-- Left side (Sidebar) -->
        <?php
        include 'partial/mentor/_sidebar.php';
        ?>


        <!-- Right side -->
        <div class="bg-cgray w-full h-screen px-10 py-6 flex flex-col gap-y-6 overflow-y-scroll rightbar">
            <!-- Header / Profile -->
            <div class="flex items-center gap-x-4 justify-end">
                <img class="w-10" src="./Img/icons/default_profile.svg" alt="Profile Image">
                <p class="text-dark-green font-semibold"><?= $user->user_username ?></p>
            </div>

            <!-- Breadcrumb -->
            <div>
                <ul class="flex items-center gap-x-4">
                    <li>
                        <a class="text-light-green" href="#">Beranda</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green" href="#">Konsultasi</a>
                    </li>
                    <li>
                        <span class="text-light-green">/</span>
                    </li>
                    <li>
                        <a class="text-light-green font-semibold" href="#">Tambah Jadwal</a>
                    </li>
                </ul>
            </div>
            <!-- navbar -->
            <?php
            include 'partial/mentor/_navbar.php';
            ?>
            <div class="flex flex-row-reverse ...">
                <button onclick='openModal(<?= $user->user_id ?>,"<?= $user->user_username ?>")' class="px-4 py-2 text-sm font-medium text-center text-blue-700 hover:text-white border border-blue-700 rounded-lg hover:bg-blue-800 mb-2 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" data-modal-toggle="defaultModal">Atur
                    jadwal</button>
            </div>

            <?php

            if (isset($_GET['message']) and ($_GET['message'] = 'success')) {
                echo '<div class="p-4 mb-4 text-md text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert">
                        <span class="font-medium">Success alert!</span>
                    </div>';
            }

            ?>


            <div>
                <table class="shadow-lg bg-white rounded-xl" style="width: 100%">
                    <colgroup>
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">

                    </colgroup>
                    <thead>
                        <tr class="text-dark-green">
                            <th class="border-b text-center px-4 py-2">Waktu Mulai</th>
                            <th class="border-b text-center px-4 py-2">Waktu Selesai</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($dataAva as $data) { ?>
                            <tr>
                                <td class="border-b px-4 py-2 text-center"><?= $data['start_time'] ?></td>
                                <td class="border-b px-4 py-2 text-center"><?= $data['end_time'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal form mentor -->
        <div id="defaultModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full mt-5">
            <div class="relative p-4 w-full max-w-md h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex justify-between items-start rounded-t border-b dark:border-gray-600">
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <form class="mt-4 px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" action="../../action/sendTime.php" method="post">
                            <h3 class="text-xl font-medium text-gray-900 text-center dark:text-white">Set Your
                                Schedule</h3>

                            <!-- Mentor -->
                            <div class="flex gap-x-4 py-1 px-10 rounded-xl">
                                <img class="w-14" src="./Img/icons/default_profile.svg" alt="Profile Image">
                                <div class="">
                                    <p class="text-dark-green text-base font-semibold" id="mentorName">Edwina Christy
                                    </p>
                                    <p class="text-light-green">Mentor System Analyst</p>
                                </div>
                            </div>


                            <div>
                                <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Waktu
                                    Mulai</label>
                                <div class="timepicker relative form-floating mb-3 w-full" id="input-toggle-timepicker" data-mdb-toggle-button="false">
                                    <input type="datetime-local" step="0.001" name="timeStart" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 -mb-4 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select a time" />
                                </div>
                            </div>
                            <div>
                                <label for="text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Waktu
                                    Selesai</label>
                                <div class="timepicker relative form-floating mb-3 w-full" id="input-toggle-timepicker" data-mdb-toggle-button="false">
                                    <input type="datetime-local" step="0.001" name="timeEnd" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 -mb-4 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select a time" />
                                </div>
                                <input type="text" name="user_id" value="<?= $user->user_id ?>" hidden>
                            </div>
                            <div class="text-center">
                                <button type="submit" class=" items-center focus:outline-none border border-yellow-400 text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:focus:ring-yellow-900">Accept
                                </button>

                                <button data-modal-toggle="defaultModal" type="button" class="text-yellow-400 hover:text-white border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-yellow-300 dark:text-yellow-300 dark:hover:text-white dark:hover:bg-yellow-400 dark:focus:ring-yellow-900">Cancel
                                </button>
                            </div>

                    </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>

    <script>
        function openModal(id, uname) {

            $('#mentorName').html(uname);

            console.log(uname)
            $.ajax({
                method: "POST",
                data: {
                    user_id: id,
                    send: true
                },
                url: '../../action/schedule.php',
                success: function(data, status) {

                    console.log(JSON.parse(data));

                    let user = JSON.parse(data);

                    let name = user.name;

                    $('#mentorName').html(uname);


                }


            })

            function sendForm(id) {
                console.log(id)
                $.ajax({
                    method: "POST",
                    data: {
                        user_id: id
                    },
                    url: '../../action/sendTime.php',
                    success: function(data, status) {

                    }
                })
            }

        }
    </script>

    <script src="https://unpkg.com/flowbite@1.4.2/dist/flowbite.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/index.min.js"></script>
    <script>
        let btnToggle = document.getElementById('btnToggle');
        let sidebar = document.querySelector('.sidebar');
        btnToggle.onclick = function() {
            sidebar.classList.toggle('in-active');
        }
        btnToggle2.onclick = function() {
            sidebar.classList.toggle('in-active');
        }
    </script>

    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.2/dist/flowbite.min.css" />

</body>

</html>