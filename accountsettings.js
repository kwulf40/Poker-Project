window.onload = document.addEventListener("DOMContentLoaded", initializeValues);

function initializeValues() {
    document.getElementById("submitBtn").addEventListener("click", updatePass);
    document.getElementById("resetAccount").addEventListener("click", resetAccount);
    document.getElementById("logoutBtn").addEventListener("click", logout);
}

function updatePass() {
    var updatePassword = document.getElementById("passwordChange").value;

    /*
    Send the new password to the database to be updated
    */
}

function resetAccount() {
    /* 
    Show confirmation box.

    If confirm, send PHP command to reset values of account.
    */
}

function logout() {
    document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    
    window.location.replace("homepage.html");
}