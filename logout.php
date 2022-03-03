<?php

require "./db/Users.php";
session_start();

$objUser = new Users;
$objUser->setEmail($_SESSION['user']);
$user = $objUser->getUserByEmail();
$objUser->setId($user['user_id']);
$objUser->setLoginStatus(0);
$objUser->setLastLogin($user['last_login']);
$objUser->updateLoginStatus();

unset($_SESSION['user']);
session_destroy();
header("location: login.php");

