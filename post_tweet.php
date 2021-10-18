<?php
session_start();

require_once "config.php";

/*
This is a very important check. This checks when the user requests this function, that the user is actually logged
in. This is to prevent attacks from users that are not logged in, that are able to send requests to modify the 
database without sufficient permissions.
*/
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    die();
}

/* 
This is the spam protection section. This checks that the user is not spamming the chat with their messages.
In combination with the session check function, it prevents spam attacks from users, and bots (requests
from applications suck as Postman). This limits users to send one message every 3 seconds.

This works by checking the time of the last call that the user has made, and compares it against the new one.
*/
if (isset($_SESSION['LAST_CALL'])) {
  $last = strtotime($_SESSION['LAST_CALL']);
  $curr = strtotime(date("Y-m-d h:i:s"));
  $sec =  abs($last - $curr);
  if ($sec <= 3) {
    $data = 'OOOWWWW!!!!! Rate limit exceded! Slow down, fool.';  // rate limit
    header('Content-Type: application/json');
    die (json_encode($data));       
  }
}
$_SESSION['LAST_CALL'] = date("Y-m-d h:i:s");

if ($_SESSION["id"] != $_POST["id"]) {
    die();
}

// normal usage if user passes all tests
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["message"]))){
        echo "please enter a message";
    } elseif(empty(trim($_POST["id"]))) {
        echo "please enter a userid";
    } else{
        $sql = "INSERT INTO tweets (userid, msg) VALUES (?, ?)";
         
        if($stmt = $link->prepare($sql)){
            $stmt->bind_param("ss", $param_userid, $param_message);
            
            $param_userid = trim($_POST["id"]);
            $param_message = trim($_POST["message"]);
            $param_message = htmlentities($param_message, ENT_QUOTES | ENT_IGNORE, "UTF-8");

            if($stmt->execute()){
                echo "done";
            } else{
                echo "unknown MySQL error";
            }
        }
        
        $stmt->close();
    }
} else {
    echo "bad request";
}
?>
