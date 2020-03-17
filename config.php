<?php
//Database credentials.
//define('DB_SERVER', '77.92.81.191');
//define('DB_USERNAME', 'deshalom_jay');
//define('DB_PASSWORD', 'Epicpie99');
//define('DB_NAME', 'deshalom_EnterWeb');
 
/* Attempt to connect to MySQL database */
//$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

 //Database credentials.
$host = "daredicing.com";
$username = "Greed";
$password = "elion123";
$dbName = "Greenwich";
 
/* Attempt to connect to MySQL database */
$conn = mysqli_connect($host, $username, $password, dbName);
  
// Check connection
if(!$conn){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
?>