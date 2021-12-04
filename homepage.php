<?php
    session_start();
?>

<!DOCTYPE HTML>
<html lang = "en">
    <head>
        <title>Home Page</title>
        <meta charset = "utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href = "homepage.css"/>
    </head>
    <body>
        <div class="bg">
            <!-- Header HTML-->
            <nav class="homepage-nav">
                <ul class="hp-nav-content">
                    <li class="homepage-pokertool">
                        <a href="homepage.php">
                            Home
                        </a>
                    </li>
                    <li class="homepage-pokertool">
                        <a href="pokertool.html">
                            Poker Tool
                        </a>
                    </li>
                    <?php
                    if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){
                        echo "<li class=\"account\">";
                        echo "<a href=\"accountsettings.php\">Welcome, ".htmlspecialchars($_SESSION["username"])."!</a>";
                        echo "</li>";
                        echo "<li class=\"account\">";
                        echo "<a href=\"logoutpage.php\">Logout</a>";
                        echo "</li>";
                        if (isset($_SESSION["admin"]) && $_SESSION["admin"] == 1){
                            echo "<li class=\"account\">";
                            echo "<a href=\"admin.php\">Admin</a>";
                            echo "</li>";
                        }
                    }
                    else {
                        echo "<li class=\"account\">";
                        echo "<a href=\"createaccountpage.php\">Create Account</a>";
                        echo "</li>";
                        echo "<li class=\"account\">";
                        echo "<a href=\"loginpage.php\">Login</a>";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </nav>
            <!-- End header HTML-->
            <div>
                <img class="logo" src="site-images/HandTracker-Logo.png" alt="Logo">
            </div>
            <hgroup>
                <h1>A FREE and SIMPLE Poker Statistics Tool</h1>
            </hgroup>
            <main>
                <div class="features">
                    <p>
                        Hand Tracker keeps track of the hands you had from your previous games, as well
                        as the frequency of cards you drew for those games.
                    </p>
                </div>
                <div class="features">
                    <p>
                        Hand Tracker provides statistics on hands you have drawn, their odds of winning,
                        and whether or not you won with that hand. In addition, it stores the ratio of 
                        wins and losses for all games played.
                    </p>
                </div>
                <div class="features">
                    <p>
                        Hand Tracker is 100% free. No payments or subscription fees are necessary.
                        Create an account now to gain access to all of our features.
                    </p>
                </div>
            </main>
        </div>
    </body>
</html>