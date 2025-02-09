<?php

$servername = "localhost";
$db_username = "root";
$db_password = "";
$database_name = "fakultet";

$conn = mysqli_connect($servername, $db_username, $db_password, $database_name);

if($conn){
    echo "Uspesno";
}

?>




<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>

<form action="" method="POST">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
    
</body>
</html>