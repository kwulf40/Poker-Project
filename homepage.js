var loggedIn = 0

window.onload = document.addEventListener("DOMContentLoaded", initializeValues);

function initializeValues() {
    document.getElementbyID("logout").addEventListener("click", logout);

    user = checkCookie();
    
    if (user == ""){
        /* 
        User not logged in.
        Display login and create account options, hide the poker tool option
        */
    }
    else {
        console.log(user);
        loggedIn = 1;
        /* 
        User is logged in. 
        Display logout and poker tool options
        */
    }
}

function checkCookie() {
    let cookie = document.cookie.split(';');
    console.log(cookie)
    for(let i = 0; i < cookie.length; i++) {
        let currentCookie = cookie[i];
        while (currentCookie.charAt(0) == ' ') {
            currentCookie = currentCookie.substring(1);
        }
        if (currentCookie.indexOf("username=") == 0) {
          return currentCookie.substring(9, currentCookie.length);
        }
      }
    return "";
}

function logout() {
    document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    
    window.location.replace("homepage.html");
}