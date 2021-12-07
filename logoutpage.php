<?php
    session_start();
    //Destroy all variables
    $_SESSION = array();
    //Destroy the session
    session_destroy();
    // Redirect to login page
    header("location: homepage.php");
exit;
?>