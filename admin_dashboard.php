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
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <meta name='viewport' content='width=device-width, initial-scale=1'>

    <style>
                
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background-color: #343a40 !important;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        .navbar a {
            color: white !important;
        }

        .table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background-color:rgb(156, 168, 158);
            color: white;
            text-align: center;
        }
        .table td {
            text-align: center;
            vertical-align: middle;
        }
        .table img {
            border-radius: 50%;
            border: 2px solid #ddd;
        }
        
        .btn {
            border-radius: 5px;
            transition: 0.3s;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }

        .dropzone {
            border: 2px dashed #007bff;
            padding: 20px;
            text-align: center;
            background: #f1f9ff;
            border-radius: 8px;
        }

        .form-control {
            border-radius: 5px;
        }
        .export-button {
    margin-left: 10px; /* Povećaj ako treba više razmaka */
}

    </style>
</head>
<body>

<?php if(isset($_SESSION['success_message'])) : ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo $_SESSION['success_message'];
    unset($_SESSION['seccess_message']);
    ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

    <div class ="container">

        <div class="row">
            <div class="col-md-12">
                <h2>Students List</h2>
                <a href="export.php?what=students" class="btn btn-success btn-sm">Export</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Professor</th>
                            <th>Photo</th>
                            <th>Session Plan</th>
                            <th>Access Card</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                       $sql = "SELECT students.*,
                       session_plans.name AS session_plan_name,
                       professors.first_name AS professor_first_name,
                       professors.last_name AS trainer_last_name
                       FROM `students`
                       LEFT JOIN `session_plans` ON students.session_plan_id = session_plans.plan_id
                       LEFT JOIN `professors` ON students.professor_id = professors.professor_id";
               
                        $run = $conn ->query($sql);

                        $results = $run->fetch_all(MYSQLI_ASSOC);
                        $select_students = $results;

                        foreach($results as $result) : ?>
                        
                            <tr>
                                <td><?php echo $result['first_name']; ?></td>
                                <td><?php echo $result['last_name']; ?></td>
                                <td><?php echo $result['email']; ?></td>
                                <td><?php echo $result['phone_number']; ?></td>
                                <td><?php 
                                if($result['professor_first_name']) {
                                    echo $result['professor_first_name'] . " " . $result['last_name'];
                                } else {
                                    echo "Nema profesora";
                                }

                                ?></td>
                                <td><img style="width:60px" src="<?php echo $result['photo_path']; ?>"></td>
                                <td><?php echo $result['session_plan_name']?></td>
                                <td><a target="_blank" href="?php echo $result['acces_card_pdf_path']; ?>">Access Card</a></td>
                                <td><?php
                                
                                 $create_at = strtotime($result['created_at']);
                                 $new_date = date("d/m/Y", $create_at);
                                 echo $new_date;
                                  ?></td>
                                <td>
                                <form action="delete_student.php" method="POST">
                                <input type="hidden" name="student_id" value="<?php echo $result['student_id']; ?>">
                                <button type="button" class="btn btn-danger">DELETE</button>
                                </form>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
            <div class="col-md-12">
            <h2>Professors List</h2>
            <a href="export.php?what=professors" class="btn btn-success btn-sm">Export</a>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Created At</th>   
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                 $sql = "SELECT * FROM professors";

                                 $run = $conn ->query($sql);

                                 $results = $run->fetch_all(MYSQLI_ASSOC);
                                 $select_professors = $results;
         
                                 foreach($results as $result) : ?>

                                 <tr>
                                    <td><?php echo $result['first_name']; ?></td>
                                    <td><?php echo $result['last_name']; ?></td>
                                    <td><?php echo $result['email']; ?></td>
                                    <td><?php echo $result['phone_number']; ?></td>
                                    <td><?php echo date("F jS, Y", strtotime($result['created_at'])); ?></td>
                                 </tr>

                                <?php endforeach; ?>
                            </tbody>
                            </table>         
            </div>
        </div>

        <div class="row mb-5">
            <div class ="col-md-6">
                <h2>Register Student</h2>
                <form action="register_student.php" method="post" enctype="multipart/form-data">
                    First Name: <input class="form-control" type="text" name="first_name"><br>
                    Last Name: <input class="form-control" type="text" name="last_name"><br>
                    Email: <input class="form-control" type="email" name="email"><br>
                    Phone Number: <input class="form-control" type="text" name="phone_number"><br>

                    Session Plan:
                    <select class="form-control" name="session_plan_id">
                        <option value="" disabled selected>Session Plan</option>
                        
                        <?php
                        $sql = "SELECT * FROM session_plans";
                        $run = $conn->query($sql);
                        $results = $run->fetch_all(MYSQLI_ASSOC);

                        foreach($results as $result) {
                            echo "<option value='" . $result['plan_id'] . "'>" . $result['name'] . "</option>";

                        }
                        ?>

                    </select><br>
                    <input type="hidden" name="photo_path" id="photoPathInput">

                    <div id="dropzone-upload" class="dropzone"></div>

                    <input class="btn btn-success mt-3" type="submit" value="Confirm">
                    </form>  
        </div>
        <div class="col-md-6">
        <h2>Register Professor</h2>
            <form action ="register_professor.php" method="POST">
                    First Name: <input class="form-control" type="text" name="first_name"><br>
                    Last Name: <input class="form-control" type="text" name="last_name"><br>
                    Email: <input class="form-control" type="email" name="email"><br>
                    Phone Number: <input class="form-control" type="text" name="phone_number"><br>
                    <input class="btn btn-success mt-3" type="submit" value="Confirm">

            </form>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6"></div>
        <h2>Assing Professor to Student</h2>
        <form action ="assign_professor.php" method="POST">
            <label for="">Select Student</label>
            <select name="student" class="form-select">
              <?php
              foreach($select_students as $student) : ?>
              <option value="<?php echo $student['student_id'] ?>">
                <?php echo $student['first_name'] . " " . $student['last_name']; ?>
              </option>
              <?php endforeach; ?>

            </select>
            <label for="">Select Professor</label>
            <select name="professor" class="form-select">
            <?php
              foreach($select_professors as $professor) : ?>
              <option value="<?php echo $professor['professor_id'] ?>">
                <?php echo $professor['first_name'] . " " . $professor['last_name']; ?>
              </option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-success mt-3">Assign Professor</button>
    </div>
</div>

<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

<script>
    Dropzone.options.dropzoneUpload = {
        url: "upload_photo.php",
        paramName: "photo",
        maxFilesize: 20, //MB
        acceptedFiles: "image/*",
        init: function () {
            this.on("success", function (file, response){
                const jsonResponse = JSON.parse(response);
                if (jsonResponse.success) {
                    document.getElementById('photoPathInput').value = jsonResponse.photo_path;
                } else {
                    console.error(jsonResponse.error);
                }
            });
        }
    }
</script>

</body>
</html>