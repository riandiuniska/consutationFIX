<?php

include_once '../../db/Acceptance.php';

session_start();

$user = $_SESSION['user_data']->user;

$loginPath = "../../login.php";
if (!isset($_COOKIE['X-LUMINTU-REFRESHTOKEN'])) {
    unset($_SESSION['user_data']);
    header("location: " . $loginPath);
}
if (!isset($_SESSION['user_data'])) {
    header('location:' . $loginPath);
}

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

// acceptance
$acc = new Acceptance;
$acceptances = $acc->getApprove($user->user_id);


// foreach($mentors as $mentor){
//     echo $mentor['name']; echo '<br>';

// }


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Approvement</title>
    <link href="Img/icons/logo_lumintu1.ico" rel='icon' />

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Tailwindcss -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.4.2/dist/flowbite.min.css" />
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
                        <a class="text-light-green font-semibold" href="#">Sesi</a>
                    </li>
                </ul>
            </div>
            <!-- navbar -->
            <?php
            include 'partial/mentor/_navbar.php';
            ?>
            <div>
                <table class="shadow-lg bg-white rounded-xl" style="width: 100%">
                    <colgroup>
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 10%">
                        <col span="1" style="width: 5%">
                    </colgroup>
                    <thead>
                        <tr class="text-dark-green">
                            <th class="border-b text-left items-center px-4 py-2">Nama</th>
                            <th class="border-b text-center px-4 py-2">Waktu Pengajuan</th>
                            <th class="border-b text-center px-4 py-2">Topik</th>
                            <th class="border-b text-center px-4 py-2">Status</th>
                            <th class="border-b text-center px-4 py-2">Keterangan</th>
                    </thead>
                    <tbody>
                        <?php foreach ($acceptances as $acceptance) { ?>
                            <tr>
                                <td class="border-b px-4 py-2"><?= $acceptance['name'] ?></td>
                                <td class="border-b px-4 py-2 text-center"><?= $acceptance['time'] ?></td>
                                <td class="border-b px-4 py-2 text-center"><?= $acceptance['topic'] ?></td>
                                <td class="border-b px-4 py-2 text-center">
                                    <?php if ($acceptance['status'] == 'disable') { ?>
                                        <button type="button" class="px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 mb-2 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="changeStatus(<?= $acceptance['acceptance_id'] ?>, 'approve')">Approve</button>
                                        <button type="button" class="text-red-700 ml-1 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900 " onclick="changeStatus(<?= $acceptance['acceptance_id'] ?>, 'reject')">Not Approve</button>
                                    <?php } elseif ($acceptance['status'] == 'active') { ?>
                                        <button disabled type="button" class="px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 mb-2 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="changeStatus(<?= $acceptance['acceptance_id'] ?>)">Approved</button>
                                    <?php } else { ?>
                                        <button disabled type="button" class="text-red-700 ml-1 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-3 py-2 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">Rejected</button>
                                    <?php } ?>
                                </td>
                                <td class="border-b px-4 py-2 text-center">

                                    <?php if ($acceptance['status'] == 'active') { ?>
                                        <a href="../../group_chat.php"><button type="button" class="px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Konsultasi</button></a>
                                    <?php } else { ?>
                                        <p>Reject</p>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>

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

</body>

</html>