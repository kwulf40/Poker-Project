<?php
    require_once "config.php";

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
            <div class="current-game">
                <div class="game-table">
                    <img class="table" src="site-images/game-table.png" alt="gameTable">
                    <div class="table-card" id="flopOne">
                        <img src="poker-cards/10_of_clubs.png">
                    </div>
                    <div class="table-card" id="flopTwo">
                        <img src="poker-cards/10_of_clubs.png">
                    </div>
                    <div class="table-card" id="flopThree">
                        <img src="poker-cards/10_of_clubs.png">
                    </div>
                    <div class="table-card" id="turn">
                        <img src="poker-cards/10_of_clubs.png">
                    </div>
                    <div class="table-card" id="river">
                        <img src="poker-cards/10_of_clubs.png">
                    </div>
                    <div class="hand-card" id="cardOne">
                        <img src="poker-cards/10_of_clubs.png">
                    </div>
                    <div class="hand-card" id="cardTwo">
                        <img src="poker-cards/10_of_clubs.png">
                    </div>
                </div>
                <div class="cards">
                    <form id="gameSubmit" name="gameSubmit" action="" method="post"> 
                    <div>
                        <label>Please enter your cards on hand:</label>
                        <select name="handCardValues1" id="handCardValues1">
                            <option value="Ace">Ace</option>
                            <option value="Two">Two</option>
                            <option value="Three">Three</option>
                            <option value="Four">Four</option>
                            <option value="Five">Five</option>
                            <option value="Six">Six</option>
                            <option value="Seven">Seven</option>
                            <option value="Eight">Eight</option>
                            <option value="Nine">Nine</option>
                            <option value="Jack">Jack</option>
                            <option value="Queen">Queen</option>
                            <option value="King">King</option>
                        </select>
                        <select name="handCardSuits1" id="handCardSuits1">
                            <option value="Diamond">Diamond</option>
                            <option value="Heart">Heart</option>
                            <option value="Spade">Spade</option>
                            <option value="Club">Club</option>
                        </select>
                        <select name="handCardValues2" id="handCardValues2">
                            <option value="Ace">Ace</option>
                            <option value="Two">Two</option>
                            <option value="Three">Three</option>
                            <option value="Four">Four</option>
                            <option value="Five">Five</option>
                            <option value="Six">Six</option>
                            <option value="Seven">Seven</option>
                            <option value="Eight">Eight</option>
                            <option value="Nine">Nine</option>
                            <option value="Jack">Jack</option>
                            <option value="Queen">Queen</option>
                            <option value="King">King</option>
                        </select>
                        <select name="handCardSuits2" id="handCardSuits2">
                            <option value="Diamond">Diamond</option>
                            <option value="Heart">Heart</option>
                            <option value="Spade">Spade</option>
                            <option value="Club">Club</option>
                        </select>
                        <button type="submit" id="submitHandCards" onclick="">Enter Cards</button>
                        <!--update cards on table-->
                    </div>
                    <div>
                        <label>Please enter the first/next card on the table:</label>
                        <input type="text" id="BoardCards" name="CardsOnTable">
                        <button type="submit" id="submitTableCard" onclick="">Enter Card</button>
                    </div>
                    <div>
                        <button type="button" id="endGameBtn" onclick="">End Game</button>
                    </div>
                </form>
                </div>
            </div>
            <div class="prev-games">
                <div class="gameHistory">
                    <label id="historyLabel">Search for a game in your history:</label>
                    <input type="number" id="historySearch" name="historySearch">
                    <button type="button" id="searchButton" name="historySearch">Search</button>
                </div>
                <div>
                    Game: 1 <br>
                    Hand: AD 9H <br>
                    Table: 5C 7D KD 3S 7H <br>
                </div>
                <div>
                    Game: 2 <br>
                    Hand: 3C 6S <br>
                    Table: JH QD JD 7H 8S <br>
                </div>
                <div>
                    Game: 3 <br>
                    Hand: 10S 10H <br>
                    Table: 8H 10D 9H 7H 10C <br>
                </div>
                <div>
                    Game: 4 <br>
                    Hand: 4H AC <br>
                    Table: 5S 10H <br>
                </div>
                <div>
                    Game: 5 <br>
                    Hand: 2S 7J <br>
                    Table: NA <br>
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
    </body>
</html>
