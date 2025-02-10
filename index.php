<?php

require_once 'config.php';

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

            if(password_verify($password, $admin['password'])){
               $_SESSION['admin_id'] = $admin['admin_id']; 
               header('location:admin_dashboard.php');
        } else{
            $_SESSION['error'] = "Netacan password!";
            header('location: index.php');
            exit(); // kad se radi redirect mora da ide exit da se dole php kod ne bi izvrsavao
        }
    } else {
        $_SESSION['error'] = "Netacan username";
        header('location: index.php');
        exit();
    }

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

<?php
if(isset($_SESSION['error'])){
    echo $_SESSION['error'] . "<br>";
    unset($_SESSION["error"]);
}

?>

<form action="" method="POST">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
    
</body>
</html>