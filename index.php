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
<html lang="sr">
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Login</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
            height: 100vh;           /* Visina celog ekrana */
            background-color: #f4f4f4;
        }

        .login-form {
            text-align: center;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            background-color: #fff;
        }

        .login-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .login-form img {
            width: 250px;
            height: auto;
            margin-bottom: 20px;
        }
        
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <img src="photos/login.png" alt="Login Logo" class="img">
        <?php
       
        if(isset($_SESSION['error'])){
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION["error"]);
        }
        ?>
        
        <form action="" method="POST">
            <input type="text" name="username" class="form-control" placeholder="Username" required><br>
            <input type="password" name="password" class="form-control" placeholder="Password" required><br>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

</body>
</html>
