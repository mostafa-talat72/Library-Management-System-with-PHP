<?php
    include('/partials/nav.php');
    // include Connection
  include('connection.php');
  session_start();
  
  function checkBorrow($Student_Borrower_id)
    {
          global $conn;
            $borrowerSql = "SELECT * from borrower_details where Student_id = '".$Student_Borrower_id."';";
            $borrower_Book = mysqli_query($conn,$borrowerSql);
            if($borrower_Book){
                $borrowerSql_Result = mysqli_fetch_all($borrower_Book,MYSQLI_ASSOC);
                foreach($borrowerSql_Result as $Borrowers){
                    if($Borrowers['Student_id'] ===  $Student_Borrower_id){
                        return 1;
                    }
                }
            }
            else{
                echo 'Error: '. mysqli_error($conn);
            }

            return 0;
    }
  // Errors array
    $errors = ['user'=>''];
  // check if form submit
    if(isset($_POST['delete'])){
        // store values ass String
        $user = mysqli_real_escape_string($conn,$_POST['user']);
        
        // check if inputs empty 
        if(empty($user)){
            $errors['user'] = "Enter user Id";
        }

        $ok = checkBorrow($user);
        // check if no errors and create query
        if(!array_filter($errors)){
            if(!$ok)
           {
               
                $del= "Delete from Student_Details where Student_Id= '".$user."';";
                if(mysqli_query($conn,$del)){
                    echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>student deleted successfully</div>";
            //  header('Location:home.php');
                }else{
                    echo "<div class='container alert alert-danger alert-dismissible fade show' role='alert'>This Student does not exist</div>";
                }
           }
           else
           {
               echo "<div class='container alert alert-danger alert-dismissible fade show' role='alert'>This student cannot be deleted</div>";
           }
        
        }  
    }

    
?>
<div class="container" style="min-height: 85.3vh;">
    <?php
     if(!isset($_SESSION['User_ID']))
        {
          header('Location: logOut.php');
        }
    ?>
    <form class="needs-validation" method="post" novalidate>
        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">User Id</label>
                <input type="number" name="user" class="form-control" id="validationCustom01" placeholder="User Id"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please Enter a valid User Id.
                </div>
            </div>
        </div>
        <input class="btn btn-danger" type="submit" value="Delete" name="delete">

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
