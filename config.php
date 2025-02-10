<?php

session_start(); //mala memorija koja cuva odredjene podatke($_SESSION)

$servername = "localhost";
$db_username = "root";
$db_password = "";
$database_name = "fakultet";

$conn = mysqli_connect($servername, $db_username, $db_password, $database_name);

if(!$conn){
    die("Neuspesna konekcija");
}