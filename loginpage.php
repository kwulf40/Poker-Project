<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true){
    header("location: homepage.php");
    exit;
}

require_once "config.php";

$username = "";
$password = "";
$userError = "";
$passwordError = "";
$loginError = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
        //Check if username is empty
        if(empty(trim($_POST["username"]))){
            $usernameError = "Please enter username.";
        } else{
            $username = trim($_POST["username"]);
        }
        
        //Check if password is empty
        if(empty(trim($_POST["password"]))){
            $passwordError = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }

        if(empty($usernameError) && empty($passwordError)){
            //Prepare a select statement
            $sql = "SELECT id, username, password FROM USERS WHERE username = ?";
            
            if($submitStatement = mysqli_prepare($link, $sql)){
                //Bind variables to the statement
                mysqli_stmt_bind_param($submitStatement, "s", $submitUsername);
                
                //Set parameters
                $submitUsername = $username;
                
                //Attempt to execute the statement
                if(mysqli_stmt_execute($submitStatement)){
                    //Store result
                    mysqli_stmt_store_result($submitStatement);
                    
                    //Check if username exists, if yes then verify password
                    if(mysqli_stmt_num_rows($submitStatement) == 1){                    
                        //Bind result variables
                        mysqli_stmt_bind_result($submitStatement, $id, $username, $passwordHash);
                        
                        if(mysqli_stmt_fetch($submitStatement)){
                            if(password_verify($password, $passwordHash)){
                                // Password is correct, so start a new session
                                session_start();
                                
                                // Store data in session variables
                                $_SESSION["loggedIn"] = true;
                                $_SESSION["id"] = $id;
                                $_SESSION["username"] = $username;                            
                                
                                // Redirect user to welcome page
                                header("location: homepage.php");
                            } else{
                                // Password is not valid, display a generic error message
                                $loginError = "Invalid username or password.";
                            }
                        }
                    } else{
                        // Username doesn't exist, display a generic error message
                        $loginError = "Invalid username or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
                // Close statement
                mysqli_stmt_close($submitStatement);
            }
        }   
    // Close connection
    mysqli_close($link);
}

?>

<!DOCTYPE HTML>
<html lang = "en">
    <head>
        <title>Login Page</title>
        <meta charset = "utf-8" />
        <link rel="stylesheet" type="text/css" href = "loginpage.css"/>
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
                <img class="logo" src="site-images/HandTracker-Logo.png" alt="Logo">
            </div>
            <div class="login" >
                <?php 
                if(!empty($loginError)){
                    echo '<div class="emptyLoginError">' . $loginError . '</div>';
                }        
                ?>

                <form id="submission" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <!--New Username Section-->
                    <label>Username:</label>
                    <input type="text" id="username" name="username"><br>
                    <span class="submitFeedback"><?php echo $usernameError; ?></span>
                    
                    <!--New Username Section-->
                    <label>Password:</label>
                    <input type="text" id="password" name="password"><br>
                    <span class="submitFeedback"><?php echo $passwordError; ?></span>

                    <button type="submit" id="submit" onclick="">Submit</button><br>
                </form>
                <label>Don't have an account yet?</label><br>
                <button id="createaccount" onclick="window.location.href='createaccountpage.php';">Create Account</button>
            </div>
        </div>
    </body>
</html>