<?php
// Include the file that retrieves settings from Parameter Store
include('get-parameters.php');

// Create connection using mysqli with parameters from Parameter Store
$bd = mysqli_connect($ep, $un, $pw, $db);

// Check connection
if (!$bd) {
    die("Connection failed: " . mysqli_connect_error());
}
?>