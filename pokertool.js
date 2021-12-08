var gameHistoryDiv = "";

window.onload = document.addEventListener("DOMContentLoaded", function(){
    initializeValues()
});

function initializeValues() {
    gameHistoryDiv = document.getElementsByClassName("gameHistory")[0];
    document.getElementById("handCardValues1").addEventListener("change", function(){
        updateCard("hand1")
    });
    document.getElementById("handCardSuits1").addEventListener("change", function(){
        updateCard("hand1")
    });
    document.getElementById("handCardValues2").addEventListener("change", function(){
        updateCard("hand2")
    });
    document.getElementById("handCardSuits2").addEventListener("change", function(){
        updateCard("hand2")
    });
    document.getElementById("flopCardValues1").addEventListener("change", function(){
        updateCard("flop1")
    });
    document.getElementById("flopCardSuits1").addEventListener("change", function(){
        updateCard("flop1")
    });
    document.getElementById("flopCardValues2").addEventListener("change", function(){
        updateCard("flop2")
    });
    document.getElementById("flopCardSuits2").addEventListener("change", function(){
        updateCard("flop2")
    });
    document.getElementById("flopCardValues3").addEventListener("change", function(){
        updateCard("flop3")
    });
    document.getElementById("flopCardSuits3").addEventListener("change", function(){
        updateCard("flop3")
    });
    document.getElementById("turnCardValues").addEventListener("change", function(){
        updateCard("turn")
    });
    document.getElementById("turnCardSuits").addEventListener("change", function(){
        updateCard("turn")
    });
    document.getElementById("riverCardValues").addEventListener("change", function(){
        updateCard("river")
    });
    document.getElementById("riverCardSuits").addEventListener("change", function(){
        updateCard("river")
    });
    document.getElementById("continueToTurn").addEventListener("click", function(){
        revealTurn()
    });
    document.getElementById("continueToRiver").addEventListener("click", function(){
        revealRiver()
    });
    document.getElementById("cardReset").addEventListener("click", function(){
        cardReset()
    });
    document.getElementById("endGameBtn").addEventListener("click", function(){
        submitValidateInfo()
    });
    document.getElementsByClassName("close")[0].addEventListener("click", function(){
        var modal = document.getElementById("outcomeModal");
        modal.style.display = "none";
    });
    window.onclick = function(event) {
        var modal = document.getElementById("outcomeModal");
        if (event.target == modal) {
          modal.style.display = "none";
        }
    }
    document.getElementById("winButton").addEventListener("click", function(){
        var gameForm = document.getElementById("gameSubmit");
        var modal = document.getElementById("outcomeModal");
        var outcomeStorage = document.getElementById("outcomeValue");
        outcomeStorage.value = "W";
        modal.style.display = "none";
        gameForm.submit();
    });
    document.getElementById("lossButton").addEventListener("click", function(){
        var gameForm = document.getElementById("gameSubmit");
        var modal = document.getElementById("outcomeModal");
        var outcomeStorage = document.getElementById("outcomeValue");
        outcomeStorage.value = "L";
        modal.style.display = "none";
        gameForm.submit();
    });

    if(gameDataArray != ""){
        generateHistory();
    }
}

function updateCard(cardName){
    updateCard = "";
    if(cardName == "hand1"){
        if(document.getElementById("handCardValues1").value != "none" && document.getElementById("handCardSuits1").value != "none"){
            var updateCard = document.getElementById("cardOneImage");
            card = prepareCard(cardName);
            cardImage = parseInputToCardImage(card);

            updateCard.src = cardImage;
        }
    }
    else if(cardName == "hand2"){
        if(document.getElementById("handCardValues2").value != "none" && document.getElementById("handCardSuits2").value != "none"){
            var updateCard = document.getElementById("cardTwoImage");
            card = prepareCard(cardName);
            cardImage = parseInputToCardImage(card);

            updateCard.src = cardImage;
        }
    }
    else if(cardName == "flop1"){
        if(document.getElementById("flopCardValues1").value != "none" && document.getElementById("flopCardSuits1").value != "none"){
            var updateCard = document.getElementById("flopOneImage");
            card = prepareCard(cardName);
            cardImage = parseInputToCardImage(card);

            updateCard.src = cardImage;
        }
    }
    else if(cardName == "flop2"){
        if(document.getElementById("flopCardValues2").value != "none" && document.getElementById("flopCardSuits2").value != "none"){
            var updateCard = document.getElementById("flopTwoImage");
            card = prepareCard(cardName);
            cardImage = parseInputToCardImage(card);

            updateCard.src = cardImage;
        }
    }
    else if(cardName == "flop3"){
        if(document.getElementById("flopCardValues3").value != "none" && document.getElementById("flopCardSuits3").value != "none"){
            var updateCard = document.getElementById("flopThreeImage");
            card = prepareCard(cardName);
            cardImage = parseInputToCardImage(card);

            updateCard.src = cardImage;
        }
    }
    else if(cardName == "turn"){
        if(document.getElementById("turnCardValues").value != "none" && document.getElementById("turnCardSuits").value != "none"){
            var updateCard = document.getElementById("turnImage");
            card = prepareCard(cardName);
            cardImage = parseInputToCardImage(card);

            updateCard.src = cardImage;
        }
    }
    else if(cardName == "river"){
        if(document.getElementById("riverCardValues").value != "none" && document.getElementById("riverCardSuits").value != "none"){
            var updateCard = document.getElementById("riverImage");
            card = prepareCard(cardName);
            cardImage = parseInputToCardImage(card);

            updateCard.src = cardImage;
        }
    }
    else{
        //Error
        return;
    }
    if(updateCard.hidden == true){
        updateCard.hidden = false;
    }
}

function prepareCard(cardName){
    if(cardName == "hand1"){
        var cardString = document.getElementById("handCardValues1").value;
        cardString += ",";
        cardString += document.getElementById("handCardSuits1").value;

        return cardString; 
    }
    else if(cardName == "hand2"){
        var cardString = document.getElementById("handCardValues2").value;
        cardString += ",";
        cardString += document.getElementById("handCardSuits2").value;

        return cardString; 
    }
    else if(cardName == "flop1"){
        var cardString = document.getElementById("flopCardValues1").value;
        cardString += ",";
        cardString += document.getElementById("flopCardSuits1").value;

        return cardString; 
    }
    else if(cardName == "flop2"){
        var cardString = document.getElementById("flopCardValues2").value;
        cardString += ",";
        cardString += document.getElementById("flopCardSuits2").value;

        return cardString; 
    }
    else if(cardName == "flop3"){
        var cardString = document.getElementById("flopCardValues3").value;
        cardString += ",";
        cardString += document.getElementById("flopCardSuits3").value;

        return cardString; 
    }
    else if(cardName == "turn"){
        var cardString = document.getElementById("turnCardValues").value;
        cardString += ",";
        cardString += document.getElementById("turnCardSuits").value;

        return cardString; 
    }
    else if(cardName == "river"){
        var cardString = document.getElementById("riverCardValues").value;
        cardString += ",";
        cardString += document.getElementById("riverCardSuits").value;

        return cardString; 
    }
    else{
        //Error
        return;
    }
}

function parseInputToCardImage(card){
    card = card.split(",");

    var newCardSource = "poker-cards/" + card[0] + "_of_" + card[1] + ".png#" + new Date().getTime();
    return newCardSource;
}

function revealTurn() {
    var turnDiv = document.getElementById('turnDiv');
    var turnCardDiv = document.getElementById('turnCardDiv');
    var turnButton = document.getElementById('continueToTurn');
    var riverButton = document.getElementById('continueToRiver');
    
    turnDiv.hidden = false;
    turnCardDiv.hidden = false;
    turnButton.hidden = true;
    riverButton.hidden = false;
}

function revealRiver() {
    var riverDiv = document.getElementById('riverDiv');
    var riverCardDiv = document.getElementById('riverCardDiv');
    var riverButton = document.getElementById('continueToRiver');
    
    riverDiv.hidden = false;
    riverCardDiv.hidden = false;
    riverButton.hidden = true;
}

function cardReset() {
    var submitErrorField = document.getElementById("submitError");
    var turnDiv = document.getElementById('turnDiv');
    var riverDiv = document.getElementById('riverDiv');
    var turnButton = document.getElementById('continueToTurn');
    var riverButton = document.getElementById('continueToRiver');
    var cardImage1 = document.getElementById("cardOneImage");
    var cardImage2 = document.getElementById("cardTwoImage");
    var cardImage3 = document.getElementById("flopOneImage");
    var cardImage4 = document.getElementById("flopTwoImage");
    var cardImage5 = document.getElementById("flopThreeImage");
    var cardImage6 = document.getElementById("turnImage");
    var cardImage7 = document.getElementById("riverImage");
    var cardForm = document.getElementById('gameSubmit');
    
    
    cardForm.reset();
    cardImage1.hidden = true;
    cardImage2.hidden = true;
    cardImage3.hidden = true;
    cardImage4.hidden = true;
    cardImage5.hidden = true;
    cardImage6.hidden = true;
    cardImage7.hidden = true;
    turnDiv.hidden = true;
    turnCardDiv.hidden = true;
    riverDiv.hidden = true;
    riverCardDiv.hidden = true;
    riverButton.hidden = true;

    turnButton.hidden = false;
    submitErrorField.innerHTML="";
}

function submitValidateInfo() {
    var submitErrorMsg = "";
    var submitErrorField = document.getElementById("submitError");
    var outcomeModal = document.getElementById("outcomeModal");
    var handValue1 = document.getElementById("handCardValues1").value;
    var handSuit1 = document.getElementById("handCardSuits1").value;
    var handValue2 = document.getElementById("handCardValues2").value;
    var handSuit2 = document.getElementById("handCardSuits2").value;
    var flopValue1 = document.getElementById("flopCardValues1").value;
    var flopSuit1 = document.getElementById("flopCardSuits1").value;
    var flopValue2 = document.getElementById("flopCardValues2").value;
    var flopSuit2 = document.getElementById("flopCardSuits2").value;
    var flopValue3 = document.getElementById("flopCardValues3").value;
    var flopSuit3 = document.getElementById("flopCardSuits3").value;
    var turnValue = document.getElementById("turnCardValues").value;
    var turnSuit = document.getElementById("turnCardSuits").value;
    var riverValue = document.getElementById("riverCardValues").value;
    var riverSuit = document.getElementById("riverCardSuits").value;
    var turnDiv = document.getElementById("turnDiv");
    var riverDiv = document.getElementById("riverDiv");

    let flopArray = [handValue1, handSuit1, handValue2, handSuit2, flopValue1, flopSuit1, flopValue2, flopSuit2, flopValue3, flopSuit3]

    if(flopArray.every(function(x) {return x === "none";})){
        submitErrorMsg = "Please ensure the hand cards and flop cards are filled in before submitting!"
        submitErrorField.innerHTML = submitErrorMsg;
    }
    else if((turnDiv.hidden == false) && (turnValue == "none" || turnSuit == "none")){
        submitErrorMsg = "Please fill out the turn card fields!"
        submitErrorField.innerHTML = submitErrorMsg;
    }
    else if((riverDiv.hidden == false) && (riverValue == "none" || riverSuit == "none")){
        submitErrorMsg = "Please fill out the river card fields!"
        submitErrorField.innerHTML = submitErrorMsg;
    }
    else{
        outcomeModal.style.display = "block";
    }
}

function generateHistory(){
    for (numberOfHistoryGames; numberOfHistoryGames>=1; numberOfHistoryGames--){
        var arrayIndex = (numberOfHistoryGames - 1);
        var gameDiv = document.createElement("div");
        var gameID = document.createTextNode("ID: " + gameDataArray[arrayIndex][0]);
        var gameNumber = document.createTextNode("Game Number: " + gameDataArray[arrayIndex][1]);
        var boardCards = document.createTextNode("Board Cards: " + gameDataArray[arrayIndex][2]);
        var handCards = document.createTextNode("Hand Cards: " + gameDataArray[arrayIndex][3]);
        var outcome = document.createTextNode("Outcome: " + gameDataArray[arrayIndex][4]);

        gameDiv.append(gameID);
        gameDiv.append(document.createElement("br"));
        gameDiv.append(gameNumber);
        gameDiv.append(document.createElement("br"));
        gameDiv.append(boardCards);
        gameDiv.append(document.createElement("br"));
        gameDiv.append(handCards);
        gameDiv.append(document.createElement("br"));
        gameDiv.append(outcome);

        gameHistoryDiv.parentNode.insertBefore(gameDiv, gameHistoryDiv.nextSibling);
    }
}