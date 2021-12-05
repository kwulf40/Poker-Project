window.onload = document.addEventListener("DOMContentLoaded", initializeValues);

function initializeValues() {
    document.getElementById("deleteSubmit").addEventListener("click", deleteAccount);
    document.getElementById("resetSubmit").addEventListener("click", resetAccount);
    document.getElementById("adminSubmit").addEventListener("click", giveAdmin);
    document.getElementById("logSubmit").addEventListener("click", retrieveLog);
}

function deleteAccount() {
    var deleteForm = document.getElementById("deletion");
    var deleteAccountName = document.getElementById("deleteText").value;

    var confirmBox = confirm("Are you sure you want to delete " + deleteAccountName + "?");
    if(confirmBox == true){
        deleteForm.submit();
    }
    else{
        deleteForm.reset();
    }
}

function resetAccount() {
    var resetForm  = document.getElementById("reset");
    var resetAccountName = document.getElementById("resetText").value;

    var confirmBox = confirm("Are you sure you want to reset " + resetAccountName + "?");
    if(confirmBox == true){
        resetForm.submit();
    }
    else{
        resetForm.reset();
    }
}

function giveAdmin() {
    var adminForm  = document.getElementById("admin");
    var elevatedAccountName = document.getElementById("giveAdminText").value;

    var confirmBox = confirm("Are you sure you want to grant admin rights to " + elevatedAccountName + "?");
    if(confirmBox == true){
        adminForm.submit();
    }
    else{
        adminForm.reset();
    }
}

function retrieveLog() {
    var logForm  = document.getElementById("logs");
    logForm.submit();
}