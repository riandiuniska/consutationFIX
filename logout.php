<?php

require "./db/Users.php";
session_start();

// Create object for class user
$objUser = new Users;
$objUser->setEmail($_SESSION['user']);
$user = $objUser->getUserByEmail();
$objUser->setId($user['user_id']);
$objUser->setLoginStatus(0);
$objUser->setLastLogin($user['last_login']);
$objUser->updateLoginStatus();

// Unset and destroy session user
unset($_SESSION['user']);
session_destroy();
// Redirect user to login page
header("location: login.php");

