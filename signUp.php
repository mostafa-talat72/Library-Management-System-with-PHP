<?php
    include('connection.php');
    include('/partials/nav.php');
    session_start();
    // Errors array
  $errors = ['user'=>'',
            'pass'=>'',
            'id'=>'',
            'gender'=>''];
    // check if form submit
    if(isset($_POST['submit'])){
    // store values as String
    $user = mysqli_real_escape_string($conn,$_POST['user']);
    $pass = mysqli_real_escape_string($conn,$_POST['pass']);
    $id = mysqli_real_escape_string($conn,$_POST['std-id']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    // check if inputs empty 
    if(empty($user)){
        $errors['user'] = "Enter your user name";
    }
    if(empty($pass)){
        $errors['pass'] = "Enter your Password";
    }
    if(empty($id)){
        $errors['id'] = "Enter your Id"; 
    }
    if(empty($gender)){
        $errors['gender'] = "choose your gender"; 
    }
    // check if no errors and create query
    if(!array_filter($errors)){
    // create query and put into variable
    $ins = "INSERT INTO Student_Details(Student_Id,Student_Name,Student_Gender,Student_Password)VALUES('$id','$user','$gender','$pass')";
    // add query to connection and check 
    if(mysqli_query($conn,$ins)){
        $_SESSION['User_ID'] = $id;
        $_SESSION['User_Name'] = $user;
        $_SESSION['User_Type']='Student';
        $_SESSION['Student_Tax']= 0;
        header('Location:home.php');
    }else{
        echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Error: ". mysqli_error($conn)."</div>";
    }
    }
}

?>
<div class="container" style="min-height: 85.3vh;">
    <?php
     if(isset($_SESSION['User_ID']))
        {
          header('Location: home.php');
        }
    ?>
    <form class="needs-validation" novalidate method="post">
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">User name</label>
                <input type="text" name="user" class="form-control" id="validationCustom01" placeholder="User name"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please choose a username.
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationCustom02">User Id</label>
                <input type="number" name="std-id" class="form-control" id="validationCustom02" placeholder="User Id"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please choose a userId.
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationCustom03">Password</label>
                <div class="input-group">
                    <input type="password" name="pass" class="form-control" id="validationCustom03"
                        placeholder="Password" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Please choose a password.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-outline-success active">
                        <input type="radio" name="gender" value="Male" id="male" autocomplete="off" checked> Male
                    </label>
                    <label class="btn btn-outline-success">
                        <input type="radio" name="gender" value="Female" id="female" autocomplete="off"> Female
                    </label>
                </div>
            </div>
        </div>
        <input class="btn btn-primary" type="submit" value="Sign Up" name="submit">
    </form>

    <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
    </script>
</div>
<?php 
    include('/partials/footer.php')
?>
