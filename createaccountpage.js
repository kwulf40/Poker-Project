window.onload = document.addEventListener("DOMContentLoaded", initializeValues);

function initializeValues() {
    document.getElementById("submit").addEventListener("click", createAcct);
}

function createAcct() {
    var acctCreated = 0;
    var newUsername = document.getElementById("newUsername").value;
    var newPassword = document.getElementById("newPassword").value;

    /*
    Pass the new username and password over to php to perform database check that:
    -Username DOES NOT already exist

    If yes, acctCreated = 1
    */

    if (acctCreated == 1){
        cookieString = ("username=" + newUsername + ";" + ";path=/")
        document.cookie = cookieString;

        //Show confirmation dialogue

        //Redirect to homepage
        window.location.replace("homepage.html");
    }
}