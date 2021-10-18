
<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: home");
    exit;
}

// Include config file
require_once "config.php";
?>
<!DOCTYPE HTML>
<html>

<head>
    <title>Chat.</title>
    <link rel="icon" type="image/x-icon" href="images/ico/favicon_<?php echo rand(1,9); ?>.ico"/>
    <link rel="stylesheet" type="text/css" href="css/splash.css">
        <!--Google Fonts--><link href="https://fonts.googleapis.com/css?family=Finger+Paint|Knewave|Oxygen&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/typeit#6.1.0/dist/typeit.min.js"></script>
</head>
 
<!--main part of page-->
<body>
    <div class='box hero'>
        <p class=''><strong>Chat. |</strong> <a href="login">Login</a></p>
        <h1 class='tracking-in-expand bro'>chat.</h1>
    </div>
    <div class='box bubble'>
        <img src='images/chatlogonotxt.png'>
        <p id='replaceStrings'></p>

    <div>
</body>
</html> 

<!--Javascript for the typing simulation/show at the bottom of the page-->
<script>
    new TypeIt('#replaceStrings', {
    speed: 100,
    lifeLike: true,
    breakLines: false,
    nextStringDelay: 2000,
    waitUntilVisible: true
    })
    .type('Hey.')
    .pause(2000)
    .delete(4)
    .pause(300)
    .type('How are you?')
    .pause(2000)
    .delete(12)
    .pause(300)
    .type("That's great! 🥳")
    .pause(2000)
    .delete(16)
    .pause(300)
    .type('<strong>Chat. |</strong> <a href="login">Login</a>')
    .go();
</script>
<script>
    var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName('body')[0];

    const [red, green, blue] = [1,1,1]
    const hero = document.querySelector('.hero')

    window.addEventListener('scroll', () => {
    const y = (1 + (window.scrollY || window.pageYOffset)) / ((w.innerHeight|| e.clientHeight|| g.clientHeight)/1500) 
    const [r, g, b] = [red*y, green*y, blue*y].map(Math.round)
    console.log(window.scrollY || window.pageYOffset)
    hero.style.backgroundColor = `rgb(${255-r}, ${255-g}, ${255-b})`
    })


    const [re, gree, blu] = [1,1,1]
    const bro = document.querySelector('.bro')
    window.addEventListener('scroll', () => {
    const y = 1 + (window.scrollY || window.pageYOffset) / 0.5
    const [r, g, b] = [re*y, gree*y, blu*y].map(Math.round)
    bro.style.color = `rgb(${r}, ${g}, ${b})`
    })

</script> 
