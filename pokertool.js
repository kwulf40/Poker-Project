var handIn = 0
var tableIn = 0

window.onload = document.addEventListener("DOMContentLoaded", initializeValues);

function initializeValues() {
    document.getElementById("logoutBtn").addEventListener("click", logout);
    document.getElementById("submitHandCards").addEventListener("click", submitHand);
    document.getElementById("submitTableCard").addEventListener("click", submitTable);
    document.getElementById("endGameBtn").addEventListener("click", endGame);
}

function logout() {
    document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    
    window.location.replace("homepage.html");
}

function submitHand() {
    var handString = document.getElementById("HandCards").value;

    /*
    Validate the incoming string to ensure correct format.

    Then, pass the hand over PHP to be stored in the database.
    This should also trigger a refresh of the stats on the board in case the new values changed the stats.
    */
   
    /* If submit and refresh are successful, handIn = 1 */
}

function submitTable() {
    var phase = 1;
    var tableString = document.getElementById("HandCards").value;

    /*
    Validate the incoming string to ensure correct format.
    Phase 1 indicates the flop, requiring 3 cards.
    Phases 2 and 3 indicate the turn and the river, requiring one card.
    
    Stats should be updated at each phase.

    */

    /* If the river is submitted at phase 3, or the end game button is pushed at any time, tableIn = 1 */
}

function endGame() {
    if (handIn == 1 && tableIn == 1){
        /* 
        Submit the full game info to the database in a string block to add to the users match history.

        Refresh the game state and prepare for new card entry.
        */
       handIn = 0;
       tableIn = 0;
    }
    else if (handIn == 1 && tableIn != 1){
        /*
        Game ended early.
        Fill in missing info in string block, and then submit to match history.

        Refresh the game state and prepare for new card entry
        */
    }
    else {
        /*
        Throw submission error, hand must be entered to submit game to match history.
        */
    }
}

