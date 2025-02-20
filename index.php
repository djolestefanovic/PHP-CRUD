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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        /* Centriranje sadržaja na sredinu ekrana */
        body, html {
            height: 100%;
            margin: 0;
        }

        .login-container {
            display: flex;
            justify-content: center; /* Horizontalno centriranje */
            align-items: center;     /* Vertikalno centriranje */
            height: 100vh;           /* Visina ekrana */
        }

        .login-form {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            background-color: #fff;
        }

        .login-form input {
            margin-bottom: 15px;
        }

        .login-form img {
            width: 100px;
            height: auto;
            margin-bottom: 20px;
        }

        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<?php
if(isset($_SESSION['error'])){
    echo $_SESSION['error'] . "<br>";
    unset($_SESSION["error"]);
}

?>

<form action="" method="POST" class="login-form">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit" class="btn btn-primary">Login</button>
</form>
    
</body>
</html>