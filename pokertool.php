<?php
    require_once "config.php";
    
    session_start();

    $sqlUserGameInformationStatement = "SELECT * FROM GAMES WHERE user_id=?";

    if($userGameInformationStatement = mysqli_prepare($link, $sqlUserGameInformationStatement)){
        $gameHistoryGamesArray = Array();
        mysqli_stmt_bind_param($userGameInformationStatement, "i", $_SESSION["id"]);
        if(mysqli_stmt_execute($userGameInformationStatement)){
            $gameHistory = mysqli_stmt_get_result($userGameInformationStatement);
            $gameHistoryRows = mysqli_num_rows($gameHistory);
            while ($game = mysqli_fetch_row($gameHistory)) {
	            $gameInfoArray = Array();
                //Place game info in game Info array
		        foreach ($game as $gameData) {
                    array_push($gameInfoArray, $gameData);
                }
                //Place the entire game into the History array
	            array_push($gameHistoryGamesArray, $gameInfoArray);
            }
        }
        else{
            echo "Error executing game history statement";
        }
    }
    else{
        echo "Error preparing game history statement";
    }
    updateGameInfo();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (isset($_POST['handCardValues1'])){
            $handCards = $_POST['handCardValues1'] . "-" . $_POST['handCardSuits1'] . "," . $_POST['handCardValues2'] . "-" . $_POST['handCardSuits2'];

            $boardCards = $_POST['flopCardValues1'] . "-" . $_POST['flopCardSuits1'] . "," . $_POST['flopCardValues2'] . "-" . $_POST['flopCardSuits2'] . "," . $_POST['flopCardValues3'] . "-" . $_POST['flopCardSuits3'];
            if((isset($_POST['turnCardValues']) && isset($_POST['turnCardSuits'])) && ($_POST['turnCardValues'] != "none" && $_POST['turnCardSuits'] != "none")){
                $boardCards .= "," . $_POST['turnCardValues'] . "-" . $_POST['turnCardSuits'];
            }
            if((isset($_POST['riverCardValues']) && isset($_POST['riverCardSuits'])) && ($_POST['riverCardValues'] != "none" && $_POST['riverCardSuits'] != "none")){
                $boardCards .= "," . $_POST['riverCardValues'] . "-" . $_POST['riverCardSuits'];
            }

            $sqlGameInsertStatment = "INSERT INTO GAMES (user_id, game_number, board_cards, hand_cards, outcome) VALUES (?, ?, ?, ?, ?)";

            if($gameInsertStatement = mysqli_prepare($link, $sqlGameInsertStatment)){
                // Bind variables
                mysqli_stmt_bind_param($gameInsertStatement, "iisss", $id, $gameNumber, $boardCards, $handCards, $outcome);

                $id = $_SESSION["id"];
                $gameNumber = ($_SESSION["gameNumber"] + 1);

                if($_POST["outcomeValue"] == "W"){
                    $outcome = 1;
                }
                else{
                    $outcome = 0;
                }
                
                if(mysqli_stmt_execute($gameInsertStatement)){
                    //insert success
                    if($outcome == 1){
                        $sqlUpdateUserStatement = "UPDATE USERS SET total_games=total_games+1, win_count=win_count+1 WHERE username=?";
                    }
                    else{
                        $sqlUpdateUserStatement = "UPDATE USERS SET total_games=total_games+1, loss_count=loss_count+1 WHERE username=?";
                    }

                    if($updateUserStatement = mysqli_prepare($link, $sqlUpdateUserStatement)){
                        mysqli_stmt_bind_param($updateUserStatement, "s", $username);

                        $username = $_SESSION["username"];

                        if(mysqli_stmt_execute($updateUserStatement)){
                            $_SESSION["gameNumber"] += 1;
                            //success
                        }
                        else{
                            //error executing update statment
                        }
                    }
                    else{
                        echo "error executing update statment";
                    }
                }
                else{
                    echo "executing insert statment" . mysqli_error($link);
                }
            }
            else{
                //error preparing insert statment
            }
        }
        else{
            //other
        }
        updateGameInfo();
    }

    function updateGameInfo(){
        $sqlUserGameInformationStatement = "SELECT * FROM GAMES WHERE user_id=?";

        if($userGameInformationStatement = mysqli_prepare($link, $sqlUserGameInformationStatement)){
            $gameHistoryGamesArray = Array();
            mysqli_stmt_bind_param($userGameInformationStatement, "i", $_SESSION["id"]);
            if(mysqli_stmt_execute($userGameInformationStatement)){
                $gameHistory = mysqli_stmt_get_result($userGameInformationStatement);
                $gameHistoryRows = mysqli_num_rows($gameHistory);
                while ($game = mysqli_fetch_row($gameHistory)) {
                    $gameInfoArray = Array();
                    //Place game info in game Info array
                    foreach ($game as $gameData) {
                        array_push($gameInfoArray, $gameData);
                    }
                    //Place the entire game into the History array
                    array_push($gameHistoryGamesArray, $gameInfoArray);
                }
            }
            else{
                echo "Error executing game history statement";
            }
        }
        else{
            echo "Error preparing game history statement";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Poker Tool</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href = "pokertool.css"/>
        <script src="pokertool.js"></script>
    </head>
    <body>
        <nav class="pokertool-navbar">
            <ul class="poker-tool-nav">
                <li class="homepage">
                    <a class="navbar-option" href="homepage.php">
                        Home
                    </a>
                </li>
                <li class="account-settings">
                    <a href="accountsettings.php">
                        Account Settings
                    </a>
                </li>
                <!-- only if admin -->
                <li class="admin-settings">
                    <a href="admin.php">
                        Admin Settings
                    </a>
                </li>
            </ul>
        </nav>
        <main class="middle-content">
        <div id="outcomeModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>Did you hold the winning hand?</p>
                <input type="button" id="winButton" value="Yes!!">
                <input type="button" id="lossButton" value="No">
            </div>
        </div>
            <div class="current-game">
                <div class="game-table">
                    <img class="table" src="site-images/game-table.png" alt="gameTable">
                    <div class="table-card" id="flopOne">
                        <img src="poker-cards/10_of_clubs.png" id="flopOneImage" hidden>
                    </div>
                    <div class="table-card" id="flopTwo">
                        <img src="poker-cards/10_of_clubs.png" id="flopTwoImage" hidden>
                    </div>
                    <div class="table-card" id="flopThree">
                        <img src="poker-cards/10_of_clubs.png" id="flopThreeImage" hidden>
                    </div>
                    <div class="table-card" id="turn">
                        <img src="poker-cards/10_of_clubs.png" id="turnImage" hidden>
                    </div>
                    <div class="table-card" id="river">
                        <img src="poker-cards/10_of_clubs.png" id="riverImage" hidden>
                    </div>
                    <div class="hand-card" id="cardOne">
                        <img src="poker-cards/10_of_clubs.png" id="cardOneImage" hidden>
                    </div>
                    <div class="hand-card" id="cardTwo">
                        <img src="poker-cards/10_of_clubs.png" id="cardTwoImage" hidden>
                    </div>
                </div>
                <div class="cards">
                    <form id="gameSubmit" name="gameSubmit" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post"> 
                    <div>
                        <label>Please enter your cards on hand:&nbsp;</label>
                        <select name="handCardValues1" id="handCardValues1">
                            <option value="none" selected disabled hidden>Select Hand Card 1 Value</option>
                            <option value="ace">Ace</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                            <option value="9">Nine</option>
                            <option value="10">Ten</option>
                            <option value="jack">Jack</option>
                            <option value="queen">Queen</option>
                            <option value="king">King</option>
                        </select>
                        <select name="handCardSuits1" id="handCardSuits1">
                        <option value="diamonds">Diamond</option>
                            <option value="none" selected disabled hidden>Select Hand Card 1 Suit</option>
                            <option value="hearts">Heart</option>
                            <option value="spades">Spade</option>
                            <option value="clubs">Club</option>
                        </select>
                        <label>&nbsp;</label>
                        <select name="handCardValues2" id="handCardValues2">
                            <option value="none" selected disabled hidden>Select Hand Card 2 Value</option>
                            <option value="ace">Ace</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                            <option value="9">Nine</option>
                            <option value="10">Ten</option>
                            <option value="jack">Jack</option>
                            <option value="queen">Queen</option>
                            <option value="king">King</option>
                        </select>
                        <select name="handCardSuits2" id="handCardSuits2">
                            <option value="none" selected disabled hidden>Select Hand Card 2 Suit</option>                            
                            <option value="diamonds">Diamond</option>
                            <option value="hearts">Heart</option>
                            <option value="spades">Spade</option>
                            <option value="clubs">Club</option>
                        </select>
                    </div>
                    <div>
                        <label>Please enter the three cards in the flop:&nbsp;</label>
                        <select name="flopCardValues1" id="flopCardValues1">
                            <option value="none" selected disabled hidden>Select Flop Card 1 Value</option>
                            <option value="ace">Ace</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                            <option value="9">Nine</option>
                            <option value="10">Ten</option>
                            <option value="jack">Jack</option>
                            <option value="queen">Queen</option>
                            <option value="king">King</option>
                        </select>
                        <select name="flopCardSuits1" id="flopCardSuits1">
                            <option value="none" selected disabled hidden>Select Flop Card 1 Suit</option>
                            <option value="diamonds">Diamond</option>
                            <option value="hearts">Heart</option>
                            <option value="spades">Spade</option>
                            <option value="clubs">Club</option>
                        </select>
                        <label>&nbsp;</label>
                        <select name="flopCardValues2" id="flopCardValues2">
                            <option value="none" selected disabled hidden>Select Flop Card 2 Value</option>
                            <option value="ace">Ace</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                            <option value="9">Nine</option>
                            <option value="10">Ten</option>
                            <option value="jack">Jack</option>
                            <option value="queen">Queen</option>
                            <option value="king">King</option>
                        </select>
                        <select name="flopCardSuits2" id="flopCardSuits2">
                            <option value="none" selected disabled hidden>Select Flop Card 2 Suit</option>
                            <option value="diamonds">Diamond</option>
                            <option value="hearts">Heart</option>
                            <option value="spades">Spade</option>
                            <option value="clubs">Club</option>
                        </select>
                        <label>&nbsp;</label>
                        <select name="flopCardValues3" id="flopCardValues3">
                            <option value="none" selected disabled hidden>Select Flop Card 3 Value</option>
                            <option value="ace">Ace</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                            <option value="9">Nine</option>
                            <option value="10">Ten</option>
                            <option value="jack">Jack</option>
                            <option value="queen">Queen</option>
                            <option value="king">King</option>
                        </select>
                        <select name="flopCardSuits3" id="flopCardSuits3">
                            <option value="none" selected disabled hidden>Select Flop Card 3 Suit</option>
                            <option value="diamonds">Diamond</option>
                            <option value="hearts">Heart</option>
                            <option value="spades">Spade</option>
                            <option value="clubs">Club</option>
                        </select>
                    </div>
                    <div id="turnDiv" hidden>
                        <label>Please enter the turn card:</label>
                        <select name="turnCardValues" id="turnCardValues">
                            <option value="none" selected disabled hidden>Select Turn Card Value</option>
                            <option value="ace">Ace</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                            <option value="9">Nine</option>
                            <option value="10">Ten</option>
                            <option value="jack">Jack</option>
                            <option value="queen">Queen</option>
                            <option value="king">King</option>
                        </select>
                        <select name="turnCardSuits" id="turnCardSuits">
                            <option value="none" selected disabled hidden>Select Turn Card Suit</option>
                            <option value="diamonds">Diamond</option>
                            <option value="hearts">Heart</option>
                            <option value="spades">Spade</option>
                            <option value="clubs">Club</option>
                        </select>
                    </div>
                    <div id="riverDiv" hidden>
                        <label>Please enter the river card:</label>
                        <select name="riverCardValues" id="riverCardValues">
                            <option value="none" selected disabled hidden>Select River Card Value</option>
                            <option value="ace">Ace</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                            <option value="4">Four</option>
                            <option value="5">Five</option>
                            <option value="6">Six</option>
                            <option value="7">Seven</option>
                            <option value="8">Eight</option>
                            <option value="9">Nine</option>
                            <option value="10">Ten</option>
                            <option value="jack">Jack</option>
                            <option value="queen">Queen</option>
                            <option value="king">King</option>
                        </select>
                        <select name="riverCardSuits" id="riverCardSuits">
                            <option value="none" selected disabled hidden>Select River Card Suit</option>
                            <option value="diamonds">Diamond</option>
                            <option value="hearts">Heart</option>
                            <option value="spades">Spade</option>
                            <option value="clubs">Club</option>
                        </select>
                    </div>
                    <div>
                        <input type="button" id="continueToTurn" value="Continue to the Turn">
                        <input type="button" id="continueToRiver" value="Continue to the River" hidden>
                        <input type="button" id="endGameBtn" value="Submit Game Info">
                        <input type="button" id="cardReset" value="Reset">
                    </div>
                    <input type="hidden" id="outcomeValue" name="outcomeValue" value="">
                    <p id="submitError"></p>
                    </form>
                </div>
            </div>
            <div class="prev-games">
                <div class="gameHistory">
                    <label id="historyLabel">Search for a game in your history:</label>
                    <input type="number" id="historySearch" name="historySearch">
                    <button type="button" id="searchButton" name="historySearch">Search</button>
                </div>
            </div>
        </main>
        <footer class="stats-table">
            <div>
                Game: 1 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
            <div>
                Game: 2 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
            <div>
                Game: 3 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
            <div>
                Game: 4 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
            <div>
                Game: 5 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
            <div>
                Game: 6 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
            <div>
                Game: 7 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
            <div>
                Game: 8 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
            <div>
                Game: 9 <br>
                HAND STATS: TBD <br>
                GAME STATS: TBD <br>
            </div>
        </footer>
        <script>
            var gameDataArray = <?php echo json_encode($gameHistoryGamesArray); ?>;
            var numberOfHistoryGames = <?php echo $gameHistoryRows; ?>;
        </script>
    </body>
</html>
