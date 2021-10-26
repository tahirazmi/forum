<?php

$servername ="localhost";
$username ="root";
$password ="";
$database ="idiscuss";

$conn= mysqli_connect($servername, $username, $password, $database);
if(!$conn){
    die("connection was not successful dur to -->" .mysqli_connect_error());
}


?>
