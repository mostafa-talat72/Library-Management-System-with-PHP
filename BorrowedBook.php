<?php
    include('connection.php');
    session_start();
    if(!isset($_SESSION['User_ID']) || $_SESSION['User_ID'] == 'Student')
        {
          header('Location: logOut.php');
        }
    include('/partials/nav.php'); 
    if(isset($_POST['return'])){
         $del="Delete from borrower_details where Borrower_Id= '".$_POST['return']."';";
        if(mysqli_query($conn,$del)){
            echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Book returned successfully</div>";
        }
        unset($_POST['return']);
        unset($_SESSION['Book_ID_Borrowed']);
        unset($_SESSION['Borrower_ID']);
        header('REFRESH:3;URL=BorrowedBook.php');
    }
?>
<div class="container" style="min-height: 85.3vh;">
    <form class="needs-validation" method="post" novalidate>
        <div class="row">
            <?php 
                $result = $conn->query("select * from borrower_details;");
                while($row=$result->fetch_assoc()){
                        $Borrower_Id = $row["Borrower_Id"];
                        $Book_Id = $row["Book_Id"];
                        $Student_id = $row["Student_id"];
                        $Borrowed_From = $row["Borrowed_From"];
                        $Borrowed_TO = $row["Borrowed_TO"];
                        $Manger_Id= $row["Manger_Id"];
            
                    echo'<div class="col-sm-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">'.$Borrower_Id.'</h5>
                                <p name="Student_id">Student ID: '.$Student_id.'</p>
                                <p name="Book_id">Book ID: '.$Book_Id.'</p>
                                <p name="Borrow_date">Borrow date: '.$Borrowed_From.'</p>
                                <p name="Return_date">Return date: '.$Borrowed_TO.'</p>
                                <button class="btn btn-success" type="submit" name="return" value="'.$Borrower_Id.'"
                                            style="float: right;">Return</button>

                        </div>
                    </div>
                        <div class="card-footer">
                            <small class="text-muted">Manger ID: '.$Manger_Id.'</small>
                        </div>
                    </div>';
                }
            ?>
        </div>
    </form>
</div>
<?php 
    include('/partials/footer.php')
?>
