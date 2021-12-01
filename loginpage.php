<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){
    header("location: homepage.php");
    exit;
}

?>

<!DOCTYPE HTML>
<html lang = "en">
    <head>
        <title>Login Page</title>
        <meta charset = "utf-8" />
        <link rel="stylesheet" type="text/css" href = "loginpage.css"/>
        <script src="loginpage.js"></script>
    </head>
    <body>
        <div class="bg">
            <nav class="login-nav">
                <ul class="login-nav-content">
                    <li class="homepage">
                        <a href="homepage.html">
                            Home
                        </a>
                    </li>
                </ul>
            </nav>
            <div>
                <img class="logo" src="HandTracker-Logo.png" alt="Logo">
            </div>
            <div class="login">
                <!-- TODO
                No actions for the form at this point.
                Create one when the database is setup. 
                -->
                <form id="submission">
                    <label>Username:</label>
                    <input type="text" id="username" name="username"><br>
                    <label>Password:</label>
                    <input type="text" id="password" name="password"><br>
                    <!-- TODO
                    Change the onclick functionality for the submit button have the js check with the database.
                    If a valid username and password is found then log them in and take them to their Poker Tool. 
                    If not then create an alert.
                    -->
                    <button type="submit" id="submit" onclick="">Submit</button><br>
                </form>
                <label>Don't have an account yet?</label><br>
                <button id="createaccount" onclick="window.location.href='createaccountpage.html';">Create Account</button>
            </div>
        </div>
    </body>
</html>