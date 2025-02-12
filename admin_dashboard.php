<?php

require_once 'config.php';


if(!isset($_SESSION['admin_id'])){
    header('location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>

<div class = "container">
    <div class="row mb-5">
        <div class = "col-md-6">
            <h2>Register Member</h2>
            <form action="register_member.php" method="post" enctype="multipart/form-data">
                First Name: <input class="form-control" type="text" name="first_name"><br>
                Last Name: <input class="form-control" type="text" name="last_name"><br>
                Email: <input class="form-control" type="email" name="email"><br>
                Phone Number: <input class="form-control" type="text" name="phone_number"><br>
                Training Plan:
                <select class="form-control" name="training_plan_id">
                    
                       </select><br>
                       <input type="hidden" name="photo_path" id="photoPathInput">
                       <div id="dropzone-upload" class="dropzone"></div>

                       <input class="btn btn-primary mt-3" type="submit" value="Register Member">
                </form>  
                </select>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>