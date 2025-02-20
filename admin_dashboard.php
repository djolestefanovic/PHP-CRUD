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
                        $sql = "SELECT * FROM students";

                        $run = $conn ->query($sql);

                        $results = $run->fetch_all(MYSQLI_ASSOC);

                        foreach($results as $result) : ?>
                        
                            <tr>
                                <td><?php echo $result['first_name']; ?></td>
                                <td><?php echo $result['last_name']; ?></td>
                                <td><?php echo $result['email']; ?></td>
                                <td><?php echo $result['phone_number']; ?></td>
                                <td><?php echo $result['professor_id']; ?></td>
                                <td><img style="width:60px" src="<?php echo $result['photo_path']; ?>"></td>
                                <td><?php
                                
                                 $plan_id = $result['session_plan_id'];
                                 $sql = "SELECT * FROM session_plans WHERE plan_id = ?";
                                 $run = $conn ->prepare($sql);
                                 $run->bind_param('i', $plan_id);
                                 $run->execute();

                                 $results = $run->get_result() ;
                                 $results = $results->fetch_assoc();

                                 echo $results['name'];

                                ?></td>
                                <td><a target="_blank" href="?php echo $result['acces_card_pdf_path']; ?>">Access Card</a></td>
                                <td><?php
                                
                                 $create_at = strtotime($result['created_at']);
                                 $new_date = date("d/m/Y", $create_at);
                                 echo $new_date;
                                  ?></td>
                                <td><button>DELETE</button></td>
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

                    <input class="btn btn-primary mt-3" type="submit" value="Confirm">
                    </form>  
        </div>
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