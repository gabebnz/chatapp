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

$msgquery = mysqli_query($link, "SELECT * FROM tweets");
$msgnumber=mysqli_num_rows($msgquery);

$accquery = mysqli_query($link, "SELECT * FROM users");
$accnumber=mysqli_num_rows($accquery);
?>
 
<!doctype hmtl>
<html>
<head>
    <!--Random Icon-->              <link rel="icon" type="image/x-icon" href="images/ico/favicon_<?php echo rand(1,9); ?>.ico"/>
                                    <title>Chat - admin</title>
    <!--Google Fonts-->             <link href="https://fonts.googleapis.com/css?family=Finger+Paint|Knewave|Oxygen&display=swap" rel="stylesheet">
    <!--Viewport info for mobile--> <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Bootstrap css-->            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--Custom css-->               <link rel="stylesheet" href="css/main.css">
                                    <link rel="stylesheet" href="css/home.css">
                                    <link rel="stylesheet" href="css/admin.css">
    <!--ajax JS-->                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.js"></script>
</head>

    <body class="d-flex flex-column"> 
        <div class="bad">
            <div class="homecontent row">
                <div class="leftside col">
                </div>
                <div class="middle col-6">
                    <div class="topsection">
                        <div class="admincontent">
                            <img class="logo" src="images/chatlogo.png" draggable="false">
                            <h1>Admin Panel</h1>
                        </div>
                    </div>
                    <div class="middlesection">
                        <div class="admincontent">
                            <hr>
                            <h2><strong><?php echo $msgnumber; ?></strong> message(s) on record.</h2>
                            <br>
                            <button type="button" onclick="purge()" class="mainb submit btn btn-primary">P U R G E</button>
                            <p>//deletes all messages <strong>(cannot revert)</strong></p>
                            <hr>
                            <h2><strong><?php echo $accnumber; ?></strong> account(s) on record.</h2>
                            <table class="table table-striped">                     
                                <div class="table responsive">
                                    <thead>
                                        <tr>
                                        <th>ID#</th>
                                        <th>Fullname</th>
                                        <th>Username</th>
                                        <th>Admin</th>
                                        <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql = "SELECT * FROM users";
                                            $result = $link->query($sql);
                                            if ($result->num_rows > 0){
                                                while($row = $result->fetch_assoc()){
                                                    echo '<tr>
                                                        <td scope="row">' . $row["id"]. '</td>
                                                        <td>' . $row["fullname"] .'</td>
                                                        <td>' . $row["username"] .'</td>
                                                        <td> '. $row["admin"] .'</td>
                                                        ';
                                                    if($row["admin"] != 1){
                                                        echo "<td><a href='#' onclick='delacc(".$row["id"].")'>delete</a></td></tr>";
                                                    }
                                                    else{
                                                        echo "<td> </td></tr>";
                                                    }
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </div>
                            </table>
                            <hr>
                        </div>
                    </div>
                    <div class="bottomsection">
                        <div class="admincontent">
                            <button type="button" onclick="location.href='home'" class="homeb submit btn btn-primary">home</button>
                            <button type="button" onclick="location.href='logout'" class="logoutb submit btn btn-primary">logout</button>
                        </div>
                    </div>
                </div>
                <div class="rightside col">
                </div>
            </div>
        </div>
    </body>
 
    <script>
        //calls the purge function. This deletes ALL messages in the database from any user.
        function purge() {
            $.ajax({
                url: "./purge.php",
            });
            window.location.reload();
        }

        function delacc(id){
            $.ajax({
                type: "POST",
                url: "./delacc.php",
                data: {"accid":id}
            });
            window.location.reload();
        }
    </script>
</html> 

