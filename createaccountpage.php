<?php
    require_once "config.php";

    $username = "";
    $password = "";
    $confirmPassword = "";
    $adminPassword = "";
    $userError = "";
    $passwordError = "";
    $confirmPasswordError = "";
    $adminPasswordError = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["username"]))){
            $userError = "Please enter a username.";
        }
        elseif(!preg_match('/^[a-zA-Z0-9]+$/', trim($_POST["username"]))){
            $userError = "Username can only contain letters and numbers.";
        }
        else{
            // Prepare a select statement
            $sqlUserCheckStatement = "SELECT id FROM USERS WHERE username=?";
            
            if($submitStatement = mysqli_prepare($link, $sqlUserCheckStatement)){
                //Bind Variables to statment
                mysqli_stmt_bind_param($submitStatement, "s", $submitCheckUsername);
                
                //Prepare Statment Variable
                $submitCheckUsername = trim($_POST["username"]);
                
                //Submit SQL Statment
                if(mysqli_stmt_execute($submitStatement)){
                    mysqli_stmt_store_result($submitStatement);
                    if(mysqli_stmt_num_rows($submitStatement) == 1){
                        $usernameError = "This username is already taken.";
                    } 
                    else{
                        $username = trim($_POST["username"]);
                    }
                } 
                else{
                    echo "Error Occured.";
                }
                mysqli_stmt_close($submitStatement);
            }
        }
           
    // Validate password
    if(empty(trim($_POST["password"]))){
        $passwordError = "Please enter a password.";     
    } 
    elseif(strlen(trim($_POST["password"])) < 4){
        $passwordError = "Password must have atleast 4 characters.";
    } 
    else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirmPassword"]))){
        $confirmPasswordError = "Please confirm password.";     
    } 
    else{
        $confirmPassword= trim($_POST["confirmPassword"]);
        if(empty($passwordError) && ($password != $confirmPassword)){
            $confirmPasswordError = "Password did not match.";
        }
    }

    //Check for Admin Password

    /**
     * TODO - 
     * INSTRUCTIONS TO LEAVE ADMIN BLANK IF UNKNOWN
     * ERROR STATEMENT IF ADMIN FIELD IS FILLED BUT WRONG
     * ADMIN ACCOUNT CREATED MESSAGE IF CORRECT
     */

    if(empty(trim($_POST["adminPassword"]))){
        $adminPasswordBool = 0;
    }
    else{
        $submitAdminPassword = trim($_POST["adminPassword"]);
        if ($submitAdminPassword == "BrightBurger"){
            $adminPasswordBool = 1;
        }
        else{
            $adminPasswordBool = 0;
            $adminPasswodError = "Admin Password Incorrect";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($usernameError) && empty($passwordError) && empty($confirmPasswordError)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO USERS (username, password, admin) VALUES (?, ?, ?)";
         
        if($insertStatement = mysqli_prepare($link, $sql)){
            // Bind variables
            mysqli_stmt_bind_param($insertStatement, "ssi", $submitFinalUsername, $submitFinalPassword, $submitAdminBool);
            
            // Set variables
            $submitFinalUsername = $username;
            $submitFinalPassword = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $submitAdminBool = $adminPasswordBool;

            //Attempt to execute the prepared statement
            if(mysqli_stmt_execute($insertStatement)){
                mysqli_stmt_close($insertStatement);
                //If the statement executes successfully, create a new statement to retrieve newly created ID value.
                $sqlAccountInfoSelect = "SELECT id, admin FROM USERS WHERE username=?";
                
                if($accountSelectStatement = mysqli_prepare($link, $sqlAccountInfoSelect)){
                    //Bind Variables to statment
                    mysqli_stmt_bind_param($accountSelectStatement, "s", $submitFinalUsername);
                    
                    //Submit SQL Statment
                    if(mysqli_stmt_execute($accountSelectStatement)){
                        mysqli_stmt_store_result($accountSelectStatement);
                        mysqli_stmt_bind_result($accountSelectStatement, $id, $adminBool);
                        if (mysqli_stmt_fetch($accountSelectStatement)){
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedIn"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["admin"] = $adminBool;
                            $_SESSION["gameNumber"] = 0;  
                            // Redirect to homepage
                            header("location: homepage.php");
                        }
                        else{
                            echo "Error: " . mysqli_error($link);
                        }
                        mysqli_stmt_close($accountSelectStatement);
                    }
                    else {echo mysqli_error($link);}
                } 
                else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            // Close statement
            mysqli_stmt_close($insertStatement);
            }
        }
    //Close connection
    mysqli_close($link);
    }
}
?>

<!DOCTYPE HTML>
<html lang = "en">
    <head>
        <title>Create Account Page</title>
        <meta charset = "utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href = "createaccountpage.css"/>
    </head>
    <body>
        <div class="bg">
            <nav class="create-account-nav">
			    <ul class="ca-nav-content">
                    <li class="homepage">
                        <a href="homepage.php">
                            Home
                        </a>
                    </li>
                </ul>
            </nav>
            <div>
                <img class="logo" src="site-images/HandTracker-Logo.png" alt="Logo">
            </div>
            <div class="createAccount">
                <!--New Account Submission Form-->
                <form id="submission" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <!--New Username Section-->
                    <label>Create New Username:</label>
                    <input type="text" id="newUsername" name="username"><br>
                    <span class="submitFeedback"><?php echo $usernameError; ?></span>

                    <!--New Password Section-->
                    <label>Create New Password:</label>
                    <input type="text" id="newPassword" name="password"><br>
                    <span class="submitFeedback"><?php echo $passwordError; ?></span>

                    <!--Confirm Password Section-->
                    <label>Confirm Your New Password:</label>
                    <input type="text" id="confirmNewPassword" name="confirmPassword"><br>
                    <span class="submitFeedback"><?php echo $confirmPasswordError; ?></span>

                    <!--Admin Password Section-->
                    <label>Enter admin code to create admin account:</label>
                    <input type="text" id="adminPassword" name="adminPassword"><br>
                    <span class="submitFeedback"><?php echo $adminPasswordError; ?></span>

                    <input type="submit" class="button" id="submitBtn" value="Submit"><br>
                </form>
                <label>Already have an account?</label><br>
                <button id="loginPage" onclick="window.location.href='loginpage.php';">Go to Login</button>
            </div>
        </div>
    </body>
</html>