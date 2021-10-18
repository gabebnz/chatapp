<?php
require_once "config.php";

session_start();
 
$sql = "SELECT tweetid, userid, DATE_FORMAT(posted, '%d/%m/%y | %l:%i%p'), msg FROM tweets";
        
if($stmt = mysqli_prepare($link, $sql)){
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        
        if(mysqli_stmt_num_rows($stmt) > 0){                    
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $tweetid, $userid, $posted, $msg);
            $tweets = array('length' => mysqli_stmt_num_rows($stmt), "tweets" => array());
            while(mysqli_stmt_fetch($stmt)){
                $username = "";
                $admin = "0";

                $sql = "SELECT fullname, username, admin FROM users WHERE id = ?";
        
                if($stmt2 = mysqli_prepare($link, $sql)){
                    mysqli_stmt_bind_param($stmt2, "s", $param_id);
                    
                    $param_id = $userid;
                    if(mysqli_stmt_execute($stmt2)){
                        mysqli_stmt_store_result($stmt2);
                        if(mysqli_stmt_num_rows($stmt2) == 1){ 
                            mysqli_stmt_bind_result($stmt2, $fullname, $username, $admin);
                            mysqli_stmt_fetch($stmt2);
                        }
                    }
                }

                // Close statement
                mysqli_stmt_close($stmt2);

                $tweet = array("tweetid" => $tweetid, "fullname" => $fullname, "username" => $username, "userid" => $userid, "posted" => $posted, "msg" => $msg, "admin" => $admin);
                array_push($tweets["tweets"], $tweet);
            }
            echo json_encode($tweets);
        } else{
            echo '{"error": "no tweets yet"}';
        }
    } else{
        echo '{"error": "mysql error"}';
    }
}

// Close statement
mysqli_stmt_close($stmt);

?>