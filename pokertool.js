window.onload = document.addEventListener("DOMContentLoaded", function(){
    initializeValues()
});

function initializeValues() {
    //document.getElementById("submitHandCards").addEventListener("click", submitHand);
    //document.getElementById("submitTableCard").addEventListener("click", submitTable);
    //document.getElementById("endGameBtn").addEventListener("click", endGame);
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
    var turnButton = document.getElementById('continueToTurn');
    var riverButton = document.getElementById('continueToRiver');
    
    turnDiv.hidden = false;
    turnButton.hidden = true;
    riverButton.hidden = false;
}

function revealRiver() {
    var riverDiv = document.getElementById('riverDiv');
    var riverButton = document.getElementById('continueToRiver');
    
    riverDiv.hidden = false;
    riverButton.hidden = true;
}

function cardReset() {
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
    riverDiv.hidden = true;
    riverButton.hidden = true;

    turnButton.hidden = false;
}