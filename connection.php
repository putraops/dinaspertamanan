<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dinaspertamanan";

## Create connection
$con = mysqli_connect($servername, $username, $password, $dbname);
## Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

header('Content-type: application/json');

?>
