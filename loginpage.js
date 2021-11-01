window.onload = document.addEventListener("DOMContentLoaded", initializeValues);

function initializeValues() {
    document.getElementById("submit").addEventListener("click", login);
}

function login() {
    var loginCheck = 0;
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    /*
    Pass username and password over to php to perform database check that:
    -Username exists
    -Username and password are correct

    If yes, loginCheck = 1
    */

    if (loginCheck == 1){
        cookieString = ("username=" + username + ";" + ";path=/")
        document.cookie = cookieString;

        //Show confirmation dialogue

        //Redirect to homepage
        window.location.replace("homepage.html");
    }
}