<?php
// Initialize the session
session_start(); 

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}
// Check if the user is an admin, if not then return to home page
if($_SESSION["admin"] !== 1){
    header("location: home");
    exit;
}

require_once "config.php";

//delets all messages, and resets autonumber for tweet IDs back to 0
mysqli_query($link,'TRUNCATE TABLE tweets');
?>