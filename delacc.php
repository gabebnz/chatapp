<?php
require_once "config.php";

session_start();

/*
This is a very important check. This checks when the user requests this function, that the user is actually logged
in. This is to prevent attacks from users that are not logged in, that are able to send requests to modify the 
database without sufficient permissions.
*/ 


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    die();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["accid"]))){
        echo "please enter a accid";
    } else{
        $sql = "DELETE FROM users WHERE id=?";

        if($stmt = $link->prepare($sql)){

            $stmt->bind_param("s", $param_accid);

            $param_accid =  trim($_POST["accid"]);

            if($stmt->execute()){
                echo "done";
            } else{
                echo "unknown MySQL error";
            }
            $stmt->close();
        }

        
    }
} else {
    echo "bad request";
}

?>