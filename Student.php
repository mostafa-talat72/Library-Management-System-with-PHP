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

     if(isset($_POST['delete'])){
        // store values ass String
        $user = mysqli_real_escape_string($conn,$_POST['delete']);
        $del= "Delete from Student_Details where Student_Id= '".$user."';";
        if(mysqli_query($conn,$del)){
            echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Student deleted successfully</div>";
        }
        unset($_POST['delete']);
        header('REFRESH:3;URL=Student.php');
    }
    if(isset($_POST['pay_taxes'])){
        // store values ass String
        $user = mysqli_real_escape_string($conn,$_POST['pay_taxes']);
        $upd= "UPDATE Student_Details SET Student_Tax = 0 WHERE Student_Id= '".$user."';";
        if(mysqli_query($conn,$upd)){
            echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Taxes paid successfully</div>";
        }
        unset($_POST['delete']);
        header('REFRESH:3;URL=Student.php');
    }
?>
<div class="container" style="min-height: 85.3vh;">
    <?php
     if(!isset($_SESSION['User_ID']) || $_SESSION['User_ID'] == 'Student')
        {
          header('Location: logOut.php');
        }
    ?>
    <form class="needs-validation" method="post" novalidate>
        <div class="row">
            <?php 
                $result = $conn->query("select * from student_details;");
                while($row=$result->fetch_assoc()){
                        $id = $row["Student_Id"];
                        $name = $row["Student_Name"];
                        $Gender = $row["Student_Gender"];
                        $Tax = $row["Student_Tax"];
                        ?>
            <div class="col-sm-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $name ?></h5>
                        <p name="Student_Id">Student ID: <?php echo $id; ?></p>
                        <p name="Gender">Gender: <?php echo $Gender; ?></p>
                        <?php
                           if(!checkBorrow($id) && $Tax == 0)
                                {
                                     echo'<button class="btn btn-success" type="submit" name="delete" value="'; echo $id; echo '"
                                        style="float: right;">Delete</button>';
                                }
                            else
                                {
                                    echo'<button class="btn btn-danger" type="submit" name="delete" value="'; echo $id; echo '"
                                         style="float: right;" disabled>Delete</button>';
                                }
                        ?>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Taxes: <?php echo $Tax ?></small>
                    <?php
                         if($Tax != 0)
                         {
                            echo'<button class="btn btn-success" type="submit" name="pay_taxes" value="'; echo $id; echo '"
                                        style="float: right;">Pay Taxes</button>';
                         }
                    ?>
                </div>
            </div>
            <?php } ?>
        </div>
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
