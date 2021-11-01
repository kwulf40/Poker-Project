window.onload = document.addEventListener("DOMContentLoaded", initializeValues);

function initializeValues() {
    document.getElementById("deleteSubmit").addEventListener("click", deleteAccount);
    document.getElementById("resetSubmit").addEventListener("click", resetAccount);
}

function deleteAccount() {
    var account = document.getElementById("Delete").value;

    /*
    Confirm with admin.

    If yes, send account string to database, check if it exists, and delete the user if the name is found.
    */
}

function resetAccount() {
    var account = document.getElementById("Reset").value;

    /*
    Confirm with admin.

    If yes, send account string to database, check if it exists, and reset the user back to a fresh start.
    */
}