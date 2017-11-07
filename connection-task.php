<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dinaspertamanan";

## Create connection
$taskconnection = mysqli_connect($servername, $username, $password, $dbname);
## Check connection
if (!$taskconnection) {
    die("Connection failed: " . mysqli_connect_error());
}


header('Content-type: application/json');

?>
