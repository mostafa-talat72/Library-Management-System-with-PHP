<?php
    include('connection.php');
    session_start();
    if(!isset($_SESSION['User_ID']))
        {
          header('Location: logOut.php');
        }
    else
        {
           if($_SESSION['User_Type'] == 'Student')
           {
                $borrowerSql = "SELECT * from borrower_details where Student_id = '".$_SESSION['User_ID']."';";
                $borrower_Book = mysqli_query($conn,$borrowerSql);
                if( $borrower_Book){
                
                    $borrowerSql_Result = mysqli_fetch_all($borrower_Book,MYSQLI_ASSOC);
                    foreach($borrowerSql_Result as $Borrowers){
                        if($Borrowers['Student_id'] ===  $_SESSION['User_ID']){
                            $_SESSION['Book_ID_Borrowed'] =   $Borrowers['Book_Id'];
                            $_SESSION['Borrower_ID'] =   $Borrowers['Borrower_Id'];
                            break;
                        }
                    }
                }
                else{
                    echo 'Error: '. mysqli_error($conn);
                }
            
           }
         } 
         include('/partials/nav.php'); 
  // check if form submit
    if(isset($_POST['borrow'])){
         // store values ass String
         $Book_id = $_POST['borrow'];
        $ins = "INSERT into borrower_details(Book_Id,Student_id)values('$Book_id','".$_SESSION['User_ID']."');";
    // add query to connection and check 
        if(mysqli_query($conn,$ins)){
           $_SESSION['Borrower_ID']= $Book_id;
          echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Book borrowed successfully</div>";
        }else{
            echo 'Error: '. mysqli_error($conn);
        }
        unset($_POST['borrow']);
        header('REFRESH:3;URL=home.php');
    }
    if(isset($_POST['return'])){
         $del="Delete from borrower_details where Borrower_Id= '".$_POST['return']."';";
        if(mysqli_query($conn,$del)){
            echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Book returned successfully</div>";
        //  header('Location:home.php');
        }
        unset($_SESSION['Book_ID_Borrowed']);
        unset($_SESSION['Borrower_ID']);
        unset($_POST['return']);
        header('REFRESH:3;URL=home.php');
    }
    if(isset($_POST['delete_book'])){
        $del= "Delete from book_details where Book_id= '".$_POST['delete_book']."';";
        if(mysqli_query($conn,$del)){
            echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Book deleted successfully</div>";
        }
        unset($_POST['delete_book']);
        header('REFRESH:3;URL=home.php');
    }
?>
<?php
     
    ?>
<div class="container" style="min-height: 85.3vh;">
    <form class="needs-validation" method="post" novalidate>
        <div class="row">
            <?php 
                $result = $conn->query("select * from book_details;");
                while($row=$result->fetch_assoc())
                {
                        $id = $row["Book_id"];
                        $name = $row["Book_name"];
                        $auth = $row["Author_name"];
                        $Publication_date = $row["Publication_year"];
                        $BookNumActual = $row["No_Copies_Actual"];
                        $BookNum = $row["No_Copies_Current"];
                        $Category_name= $row["Category_name"];
                echo'<div class="col-sm-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">'.$name.'</h5>
                            <p name="Book_id">Book ID: '.$id.'</p>
                            <p name="Publication_year">Publication date: '.$Publication_date.'</p>
                            <p name="Category">Category: '.$Category_name.'</p>
                            <p name="Number_of_books">Number of books: '.$BookNum.'</p>';
                                if($_SESSION['User_Type']==='Student')
                                {
                                    if($BookNum != 0 && !isset($_SESSION['Borrower_ID']) && $_SESSION['Student_Tax'] == 0)
                                    {
                                        echo'<button class="btn btn-success" type="submit" name="borrow" value="'.$id.'"
                                            style="float: right;">Borrow</button>';
                                    }
                                    else
                                    {
                                        if(isset($_SESSION['Borrower_ID']) && $_SESSION['Book_ID_Borrowed'] == $id)
                                        {
                                            echo'<button class="btn btn-danger" type="submit" name="return" value="'.$id.'"
                                            style="float: right;" disabled>Return</button>';
                                        }
                                        else
                                        {
                                            echo'<button class="btn btn-danger" type="submit" name="borrow" value="'.$id.'"
                                            style="float: right;" disabled>Borrow</button>';
                                        }
                                    
                                    }
                                }
                                else
                                {
                                    echo '<p name="BookNumActual">Actual Number of books: '.$BookNumActual.'</p>';
                                    if($BookNum == $BookNumActual)
                                    {
                                        echo'<button class="btn btn-success" type="submit" name="delete_book" style="float: right;"
                                            value="'.$id.'">Delete</button>';
                                    }
                                    else
                                    {
                                        echo'<button class="btn btn-danger"  type="submit" name="delete_book" style="float: right;"
                                            value="'.$id.'" disabled>Delete</button>';
                                    }
                                }

                       echo'</div>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Authors: '.$auth.'</small>
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
