<?php
// Initialize the session
session_start(); 

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login");
    exit;
}
require_once "config.php";
?>

<!doctype hmtl>
<html>
<head> 
    <!--Random Icon-->              <link rel="icon" type="image/x-icon" href="images/ico/favicon_<?php echo rand(1,9); ?>.ico"/>
                                    <title>Chat - home</title>
    <!--Google Fonts-->             <link href="https://fonts.googleapis.com/css?family=Finger+Paint|Knewave|Oxygen&display=swap" rel="stylesheet">
    <!--Viewport info for mobile--> <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!--Bootstrap css-->            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--Custom css-->               <link rel="stylesheet" href="css/main.css">
                                    <link rel="stylesheet" href="css/home.css">
    <!--Ajax JS-->                  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.js"></script>
</head>
    <body class="d-flex flex-column"> 
        <div class="bad">
            <div class="homecontent row">
                <div id="navbar" style="display:none">
                    <a onclick="toggleMenu()" class="close"></a>
                    <!--Gets users name from session-->
                    <h1><?php echo $_SESSION["fullname"]; ?></h1> 
                    <h2>@<?php echo $_SESSION["username"]; ?></h2>
                    <p><?php if ($_SESSION["admin"] == 1) {echo "Logged in as admin!";} ?></p>
                    <?php if ($_SESSION["admin"] == 1) {echo "<button type='button' onclick='adminredirect()' class='rightadminb submit btn btn-primary'>admin panel</button>";} ?>
                    <button type="button" onclick="location.href='logout'" class="rightb submit btn btn-primary">logout</button>
                    <h3>version: 2.3.1</h3></div>
                <div class="leftside col">
                    <img class="logo" src="images/chatlogo.png" draggable="false"></div>
                <div class="middle col-6">
                    <div class="message container">
                        <!--Form for user message entry, calls JS function to send message...
                            Also includes mobile hamburger button-->
                        <form autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="messageentry form-group <?php ?>">
                                <textarea id="tweet-input"  type="text" name="message" style="overflow:auto" style="overflow:hidden;resize:none;" class="userinput form-control ass"  placeholder="Say something (max 240 characters)" maxlength=240 rows="2 "></textarea>
                                <span class="help-block"><?php ?></span>
                            </div>
                            <div class="send text-right">
                                <a onclick="toggleMenu()">&#9776;</a>
                                <button type="button"  onclick="javascript:sendtweet();" class="submit btn btn-primary">send</button>
                            </div>
                        </form>
                    </div>
                    <!--THE MAIN CHATBOX -- This is where the messages are displayed to -- HTML for this is in the JS display tweets funcitons-->
                    <div class="tweets feed container-fluid"  id="chatbox"></div></div>
                <div class="rightside col">
                    <!--Gets users name from session-->
                    <h1><?php echo $_SESSION["fullname"]; ?></h1>
                    <h2>@<?php echo $_SESSION["username"]; ?></h2>
                    <p><?php if ($_SESSION["admin"] == 1) {echo "Logged in as admin!";} ?></p>
                    <?php if ($_SESSION["admin"] == 1) {echo "<button type='button' onclick='adminredirect()' class='rightadminb submit btn btn-primary'>admin panel</button>";} ?>
                    <button type="button" onclick="location.href='logout'" class="rightb submit btn btn-primary">logout</button>
                    <h3>version: 2.3.1</h3></div>
            </div>
        </div>
    </body>

     <!--Jquery loading from CDN--><script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script>
    //String replace function
    if (!String.prototype.format) {
        String.prototype.format = function() {
            var args = arguments;
            return this.replace(/{(\d+)}/g, function(match, number) { 
                return typeof args[number] != 'undefined'
                    ? args[number]
                    : match
                    ;
            });
        };
    }

    //Function that is called to redirect the admin to the admin page...
    function adminredirect(){
        location.href = 'adminpanel'
    }
 
    //This function grabs all of the message from the database and renders it for the user.
    function updateTweets() {
        $.ajax("/list_tweets.php").done(function(data) {
            tweets = JSON.parse(data);
            $(".tweets").html("");
            for (i in tweets.tweets.reverse()) {
                tweet = tweets.tweets[i];
                can_delete = <?php echo $_SESSION["id"] ?> == tweet.userid || <?php echo $_SESSION["admin"] ?> == 1;   
                msgg = tweet.msg
                msgg = msgg.toUpperCase();
                if (msgg.includes('@'+'<?php echo $_SESSION["username"] ?>'.toUpperCase())) {
                    tweet_html = "<div class='atted messagecontainer'><h3>{3}</h3><h1>@{0}</h1><h2>" + (tweet.admin == 1 ? "Admin" : "") + "</h2><p>{1}<p><br>{2}" + (can_delete ? "<a onclick='javascript:deletetweet(" + tweet.tweetid + ")' href='#'>delete</a>" : "") + "</div><br>";
                }
                else{
                    tweet_html = "<div class='messagecontainer'><h3>{3}</h3><h1>@{0}</h1><h2>" + (tweet.admin == 1 ? "Admin" : "") + "</h2><p>{1}<p><br>{2}" + (can_delete ? "<a onclick='javascript:deletetweet(" + tweet.tweetid + ")' href='#'>delete</a>" : "") + "</div><br>";
                }

                $(".tweets").append(tweet_html.format(tweet.username, tweet.msg, tweet.posted, tweet.fullname));
            }
        });
    }

    //THis function deletes the message after being parsed the id.
    function deletetweet(id) {
        $.ajax({type: "POST", url: "/delete_tweet.php", data: {"tweetid": id}}).done(function() {
            console.log("deleted");
            updateTweets();
        });
    }

    //This function prepares the message to be sent to the database
    function sendtweet() {
        $.ajax({type: "POST", url: "/post_tweet.php",
        data: {"id": <?php echo $_SESSION["id"]; ?>, "message": $("#tweet-input").val() }}).done(function(data) {
            updateTweets();
            $("#tweet-input").val("");
        });
    }

    //This changes how often the messages refresh on the page. 1000 = 1 second
    updateTweets();
    setInterval(() => {
        updateTweets();
    }, 5000);


    //toggle menu for the mobile hamburger
    function toggleMenu() {
        var navbar = document.getElementById('navbar');    
        if(navbar.style.display == "block") { // if is menuBox displayed, hide it
            navbar.style.display = "none";
        }
        else { // if is menuBox hidden, display it
            navbar.style.display = "block";
        }
    }
    </script>
</html> 

