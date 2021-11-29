<?php
/*Database credentials.*/
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'group2');
define('DB_PASSWORD', 'Lb4iTSy5adds');
define('DB_NAME', 'group2');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    echo "<p>why</p>";
    die("<p>Unable to connect to database server.</p> " . "<p>Database Error Code " . mysqli_connect_errno() . ": " . mysqli_connect_error() . "</p>");
}
else {
    echo "<p>yay</p>";
}
?>