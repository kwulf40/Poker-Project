<?php
    session_start();
    /**
     * All ADMIN table logging statements
     */
    require_once "config.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if (isset($_POST['deleteText'])){
            /**
             * Add check for self account delete
             */
            $deleteUsername = trim($_POST["deleteText"]);
            $userCheck = verifyUsername($link, $deleteUsername);
            if ($userCheck == true){
                $sqlDeleteStatement = "DELETE FROM USERS WHERE username=?";
            
                if($deleteStatement = mysqli_prepare($link, $sqlDeleteStatement)){
                    mysqli_stmt_bind_param($deleteStatement, "s", $deleteUsername);
   
                    //Submit SQL Statment
                    if(mysqli_stmt_execute($deleteStatement)){
                        $deleteResultMessage="Delete Successful!";
                    }
                    else{
                        $deleteResultMessage="Error Deleting";
                    }
                    mysqli_stmt_close($deleteStatement);
                }
            }
            else{
                $deleteResultMessage="Username does not exist";
            }
        }
        elseif (isset($_POST['resetText'])){
            $id = -1;
            $resetUsername = trim($_POST["resetText"]);
            $userCheck = verifyUsernameIDReturn($link, $resetUsername, $id);
            if ($userCheck == true){
                $sqlResetStatement = "UPDATE USERS SET TOTAL_GAMES=0, WIN_COUNT=0, LOSS_COUNT=0 WHERE username=?";
            
                if($resetStatement = mysqli_prepare($link, $sqlResetStatement)){
                    mysqli_stmt_bind_param($resetStatement, "s", $resetUsername);
   
                    //Submit SQL Statment
                    if(mysqli_stmt_execute($resetStatement)){
                        mysqli_stmt_close($resetStatement);

                        $sqlHistoryDeleteStatement = "DELETE FROM GAMES WHERE user_id=?";
                        
                        if($gameDeleteStatement = mysqli_prepare($link, $sqlHistoryDeleteStatement)){
                            if ($id == -1){
                                $resetResultMessage="Error with game deletion - id.";
                            }
                            else {
                                mysqli_stmt_bind_param($gameDeleteStatement, "s", $id);
                                if(mysqli_stmt_execute($gameDeleteStatement)){
                                    $resetResultMessage="Reset Successful!";
                                }
                                else{
                                    $resetResultMessage="Error with game deletion - statement.";
                                }
                            }
                            mysqli_stmt_close($gameDeleteStatement);
                        }
                        else{
                            $resetResultMessage="Error Deleting";
                        }
                        
                    }
                    else{
                        $resetResultMessage="Error Resetting";
                    }
                }
            }
            else{
                $resetResultMessage="Username does not exist";
            }
        }
        elseif (isset($_POST['giveAdminText'])){
            /**
             * Add check for self account admin access
             */
            $giveAdminUsername = trim($_POST["giveAdminText"]);
            $userCheck = verifyUsername($link, $giveAdminUsername);
            if ($userCheck == true){
                $sqlAdminUpdateStatement = "UPDATE USERS SET ADMIN=1 WHERE username=?";
                
                if($adminStatement = mysqli_prepare($link, $sqlAdminUpdateStatement)){
                    mysqli_stmt_bind_param($adminStatement, "s", $giveAdminUsername);

                    if(mysqli_stmt_execute($adminStatement)){
                        $adminResultMessage="User Status Successfully Elevated.";

                        $sqlAdminLogStatement="INSERT INTO ADMIN (USER_ID, ACTION_NAME, ACTION_DESC, TIME) VALUES (?,?,?,NOW())";
                        if($adminLogStatement = mysqli_prepare($link, $sqlAdminLogStatement)){
                            mysqli_stmt_bind_param($adminLogStatement, "sss", $adminID, $action, $actionDesc);

                            $adminID=$_SESSION["id"];
                            $action="Give Admin";
                            $actionDesc=$_SESSION["username"]." grants admin rights to ".$giveAdminUsername;

                            if(mysqli_stmt_execute($adminLogStatement)){
                                $adminResultMessage="User Status Successfully Elevated.";
                            }
                            else{
                                $adminResultMessage="Error submitting Admin Log.";
                            }
                            mysqli_stmt_close($adminLogStatement);
                        }
                        else{
                            $adminResultMessage="Error preparing Admin Log statement.";
                        }
                    }
                    else{
                        $adminResultMessage="Error Executing Admin Statement.";
                    }
                    mysqli_stmt_close($adminStatement);
                }
            }
            else{
                $adminResultMessage="User does not exist.";
            }
        }
        elseif (isset($_POST['logSubmit'])){
            $logTableHTML = "";
            $sqlAdminLogSelectStatement = "SELECT * FROM ADMIN";

            if($tableData = mysqli_query($link, $sqlAdminLogSelectStatement, MYSQLI_USE_RESULT)){
                while ($row = mysqli_fetch_row($tableData)){
                    $logTableHTML = "<tr>";
                    for($i=0;$i<=3;$i++){
                        $logTableHTML .= "<td>".$row[$i]."</td>";
                    }
                    $logTableHTML .= "</tr>";
                }
                mysqli_free_result($tableData);
            }
            else {
                $logError = "Error Submitting Statment, or no table data.";
            }
            mysqli_close($link);
        }
        else{
            echo "Error";
        }
    }

    function verifyUsername($link, $username) {
        $sqlAccountInfoSelect = "SELECT id FROM USERS WHERE username=?";
        if($selectStatement = mysqli_prepare($link, $sqlAccountInfoSelect)){
            mysqli_stmt_bind_param($selectStatement, "s", $selectUsername);
            $selectUsername = $username;

            if(mysqli_stmt_execute($selectStatement)){
                mysqli_stmt_store_result($selectStatement);
                if(mysqli_stmt_num_rows($selectStatement) == 1){
                    return true;
                } 
                else{
                    echo "No record.";
                    return false;
                }
            } 
            else{
                echo "Error Occured.";
                return false;
            }
            mysqli_stmt_close($selectStatement);    
        }
        else{
            echo "Error Occured.";
            return false;
        }
    }
    function verifyUsernameIDReturn($link, $username, &$id) {
        $sqlAccountInfoSelect = "SELECT id FROM USERS WHERE username=?";
        if($selectStatement = mysqli_prepare($link, $sqlAccountInfoSelect)){
            mysqli_stmt_bind_param($selectStatement, "s", $selectUsername);
            $selectUsername = $username;

            if(mysqli_stmt_execute($selectStatement)){
                mysqli_stmt_store_result($selectStatement);
                if(mysqli_stmt_num_rows($selectStatement) == 1){
                    mysqli_stmt_bind_result($selectStatement, $id);
                    mysqli_stmt_fetch($selectStatement);
                    return true;
                } 
                else{
                    echo "No record.";
                    $id=-1;
                    return false;
                }
            } 
            else{
                echo "Error Occured.";
                $id=-1;
                return false;
            }
            mysqli_stmt_close($selectStatement);    
        }
        else{
            echo "Error Occured.";
            $id=-1;
            return false;
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Administrative Page</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href = "admin.css"/>
        <script src="admin.js"></script>
    </head>
    <body>
        <div class="bg">
            <!-- Header HTML-->
            <nav class="admin-nav">
                <ul class="admin-nav-content">
                    <li class="homepage">
                        <a href="homepage.php">
                            Home
                        </a>
                    </li>
                    <li class="account-settings">
                        <a href="accountsettings.html">
                            Account Settings
                        </a>
                    </li>
                    <li class ="pokertool">
                        <a href="pokertool.html">
                            Poker Tool
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- End header HTML-->
            <h1>Administrative Control</h1>
            <div class="account-control">

                <form id="deletion" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label>Enter the account you want to delete:</label>
                    <input type="text" id="deleteText" name="deleteText"><br>
                    <input type="button" id="deleteSubmit" value="Submit"><br>
                    <p class="submitFeedback"><?php echo $deleteResultMessage;?></p>
                </form>

                <form id="reset" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label>Enter the account you want to reset:</label>
                    <input type="text" id="resetText" name="resetText"><br>
                    <input type="button" id="resetSubmit" value="Submit"><br>
                    <p class="submitFeedback"><?php echo $resetResultMessage;?></p>
                </form>

                <form id="admin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <label>Enter the account you want to grant admin rights to:</label>
                    <input type="text" id="giveAdminText" name="giveAdminText"><br>
                    <input type="button" id="adminSubmit" value="Submit"><br>
                    <p class="submitFeedback"><?php echo $adminResultMessage;?></p>
                </form>

                <form id="logs" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">   
                    <label>View the admin logs here:</label>
                    <input type="submit" id="logSubmit" name="logSubmit" value="View Logs"><br>
                </form>

                <table>
                    <tbody>
                        <tr>
                            <th>Admin ID</th>
                            <th>Admin Action</th>
                            <th>Action Description</th>
                            <th>Timestamp</th>
                        </tr>
                        <?php
                            if(isset($logTableHTML)){
                                echo $logTableHTML;
                            }
                        ?>
                    </tbody>
                </table>
                <p class="submitFeedback"><?php echo $logError;?></p>
            </div>
        </div>
    </body>
</html>