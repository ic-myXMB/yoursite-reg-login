<?php
// Display Errors if needed
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

// Database credentials. Edit: username, password, name
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'yoursite');
 
// Attempt to connect to MySQL database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check link connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>