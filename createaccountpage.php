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
            $sqlStatement = "SELECT id FROM USERS WHERE username=?";
            
            if($submitStatement = mysqli_prepare($link, $sqlStatement)){
                //Bind Variables to statment
                mysqli_stmt_bind_param($submitStatement, "s", $submitUsername);
                
                //Prepare Statment Parameter
                $submitUsername = trim($_POST["username"]);
                
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
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssi", $submitFinalUsername, $submitFinalPassword, $submitAdminBool);
            
            // Set parameters
            $submitFinalUsername = $username;
            $submitFinalPassword = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $submitAdminBool = $adminPasswordBool;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: homepage.html");
            } 
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    //Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE HTML>
<html lang = "en">
    <head>
        <title>Create Account Page</title>
        <meta charset = "utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href = "createaccountpage.css"/>
        <!--script src="createaccountpage.js"></script-->
    </head>
    <body>
        <div class="bg">
            <nav class="create-account-nav">
				<ul class="ca-nav-content">
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
            <div class="createAccount">
                <!-- TODO
                No actions for the form at this point.
                Create one when the database is setup. -->
                <form id="submission" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label>Create New Username:</label>
                    <input type="text" id="newUsername" name="username"><br>
                    <label>Create New Password:</label>
                    <input type="text" id="newPassword" name="password"><br>
                    <label>Confirm Your New Password:</label>
                    <input type="text" id="confirmNewPassword" name="confirmPassword"><br>
                    <label>Enter admin code to create admin account:</label>
                    <input type="text" id="adminPassword" name="adminPassword"><br>
                    <!-- TODO
                    Change the onclick functionality for the submit button have the js check with the database.
                    If the username and password passed is not already there, then save them. If there are then create an alert.
                    -->
                    <input type="submit" class="button" id="submitBtn" value="Submit"><br>
                </form>
                <label>Already have an account?</label><br>
                <button id="loginPage" onclick="window.location.href='loginpage.html';">Go to Login</button>
            </div>
        </div>
    </body>
</html>