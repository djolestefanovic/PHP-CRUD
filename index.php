<?php

$servername = "localhost";
$db_username = "root";
$db_password = "";
$database_name = "fakultet";

$conn = mysqli_connect($servername, $db_username, $db_password, $database_name);

if(!$conn){
    die("Neuspesna konekcija");
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT admin_id, password FROM admins WHERE username = ?";

        $run = $conn->prepare($sql);
        $run->bind_param("s", $username);
        $run->execute();

        $results = $run->get_result();

        if($results->num_rows == 1){
            $admin = $results->fetch_assoc();

            if($admin['password'] == $password){
                echo"Password je tacan";
        } else{
            echo "password nije tacan";
        }
    }

} else {
    echo"nije uspesno";
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