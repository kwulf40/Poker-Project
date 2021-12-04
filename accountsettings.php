<?php
    session_start();

    require_once "config.php";

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["currentPassword"])){
        if(empty(trim($_POST["currentPassword"]))){
            $currentPasswordResultMessage = "Please enter your current Password.";
        } 
        else{
            $currentPassword = trim($_POST["currentPassword"]);
        }

        if(empty(trim($_POST["newPassword"]))){
            $newPasswordResultMessage = "Please enter a new password.";
        } 
        else{
            $newPassword = trim($_POST["newPassword"]);
        }

        if(empty(trim($_POST["newPasswordConfirm"]))){
            $newPasswordConfirmResultMessage = "Please confirm your new password.";
        }
        else{
            $newPasswordConfirm = trim($_POST["newPasswordConfirm"]);
        }

        if ($newPassword != $newPasswordConfirm){
            $newPasswordConfirmResultMessage = "New passwords do not match. Please try again.";
        }
        else{
            $sqlVerifyPassStatement = "SELECT password FROM USERS WHERE username = ?";

            if($verifyPassStatement = mysqli_prepare($link, $sqlVerifyPassStatement)){

                mysqli_stmt_bind_param($verifyPassStatement, "s", $selectUsername);
                $selectUsername = $_SESSION["username"];
                

                if(mysqli_stmt_execute($verifyPassStatement)){
                    mysqli_stmt_store_result($verifyPassStatement);

                    if(mysqli_stmt_num_rows($verifyPassStatement) == 1){                    
                        mysqli_stmt_bind_result($verifyPassStatement, $passwordHash);
                        if(mysqli_stmt_fetch($verifyPassStatement)){
                            if(password_verify($currentPassword, $passwordHash)){
                                $sqlUpdatePassStatement = "UPDATE USERS SET password=? WHERE username=?";

                                if($updatePassStatement = mysqli_prepare($link, $sqlUpdatePassStatement)){
                                    mysqli_stmt_bind_param($updatePassStatement, "ss", $newPasswordHash, $selectUsername);

                                    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                
                                    //Submit SQL Statment
                                    if(mysqli_stmt_execute($updatePassStatement)){
                                        $newPasswordConfirmResultMessage = "Password updated successfully.";
                                    }
                                    else{
                                        $newPasswordConfirmResultMessage = "Error executing update statement.";
                                    }
                                }
                                else{
                                    $newPasswordConfirmResultMessage = "Error preparing update statement.";
                                }
                            }
                            else{
                                $currentPasswordResultMessage = "Current password incorrect, please enter your current password.";
                            }
                        }
                        else{
                            $newPasswordConfirmResultMessage = "Error storing current password statement results.";
                        }
                    }
                    else{
                        $newPasswordConfirmResultMessage = "User does not exist.";
                    }
                }
                else{
                    $newPasswordConfirmResultMessage = "Error executing password select statement.";
                }
            }
            else{
                $newPasswordConfirmResultMessage = "Error preparing password select statement.";
            }
        }
    }
    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["resetAccount"])){
        $resetUsername = trim($_SESSION["username"]);
        $sqlResetStatement = "UPDATE USERS SET TOTAL_GAMES=0, WIN_COUNT=0, LOSS_COUNT=0 WHERE username=?";
        if($resetStatement = mysqli_prepare($link, $sqlResetStatement)){
            mysqli_stmt_bind_param($resetStatement, "s", $resetUsername);
            if(mysqli_stmt_execute($resetStatement)){
                mysqli_stmt_close($resetStatement);

                $sqlHistoryDeleteStatement = "DELETE FROM GAMES WHERE user_id=?";
                        
                if($gameDeleteStatement = mysqli_prepare($link, $sqlHistoryDeleteStatement)){
                    mysqli_stmt_bind_param($gameDeleteStatement, "s", $id);
                    $id = $_SESSION["id"];
                    if(mysqli_stmt_execute($gameDeleteStatement)){
                        $resetResultMessage="Reset Successful!";
                    }
                    else {
                        $resetResultMessage="Game delete failed to execute.";
                    }
                }
                else{
                    $resetResultMessage="Game delete failed to prepare.";
                }
            }
            else{
                $resetResultMessage="Reset failed to execute.";
            }
        }
        else{
            $resetResultMessage="Reset failed to prepare.";
        }
    }
?>

<!DOCTYPE HTML>
<html lang = "en">
    <head>
        <title>Account Settings Page</title>
        <meta charset = "utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href = "accountsettings.css"/>
        <script src="accountsettings.js"></script>
    </head>
    <body>
        <!-- Header HTML-->
        <div class="bg">
            <nav class="account-settings-nav">
                <ul class="as-nav-content">
                    <li class="homepage">
                        <a href="homepage.php">
                            Home
                        </a>
                    </li>
                    <li class="tool">
                        <a href="pokertool.html" hidden>
                            Poker Tool
                        </a>
                    </li>
                    <li class="admin">
                        <a href="admin.php" hidden>
                            Admin Settings
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End header HTML-->
            <h1>Account Control</h1>
            <div class="account-control">
                <label>Account Name: <?php echo $_SESSION["username"]?></label><br>
                <form id="submission" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label>Current Password:</label>
                    <input type="text" id="currentPassword" name="currentPassword"><br>
                    <p class="submitFeedback"><?php echo $currentPasswordResultMessage;?></p>
                    <label>New Password:</label>
                    <input type="text" id="newPassword" name="newPassword"><br>
                    <p class="submitFeedback"><?php echo $newPasswordResultMessage;?></p>
                    <label>Confirm New Password:</label>
                    <input type="text" id="newPasswordConfirm" name="newPasswordConfirm"><br>
                    <p class="submitFeedback"><?php echo $newPasswordConfirmResultMessage;?></p>
                    <button type="submit" id="submitBtn" name="submit">Submit</button><br>
                </form>
                <form id="reset" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <input type="submit" id="resetAccount" name="resetAccount" value="Reset Account"><br>
                    <p class="submitFeedback"><?php echo $resetResultMessage;?></p>
                </form>
                <form id="logout" action="logoutpage.php">
                    <input type="submit" id="logoutBtn" value="Logout"><br>
                </form>
            </div>
        </div>
    </body>
</html>