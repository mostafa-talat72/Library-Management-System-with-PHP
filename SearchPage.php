<?php

    include('connection.php');
    include('/partials/nav.php');
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
  // check if form submit
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
    if(isset($_POST['delete'])){
        // store values ass String
        $user = mysqli_real_escape_string($conn,$_POST['delete']);
        $del= "Delete from Student_Details where Student_Id= '".$user."';";
        if(mysqli_query($conn,$del)){
            echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Student deleted successfully</div>";
        }
        unset($_POST['delete']);
        header('REFRESH:3;URL=home.php');
    }
    if(isset($_POST['pay_taxes'])){
        // store values ass String
        $user = mysqli_real_escape_string($conn,$_POST['pay_taxes']);
        $upd= "UPDATE Student_Details SET Student_Tax = 0 WHERE Student_Id= '".$user."';";
        if(mysqli_query($conn,$upd)){
            echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Taxes paid successfully</div>";
        }
        unset($_POST['delete']);
        header('REFRESH:3;URL=home.php');
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
        <div class="row">
            <?php 
                echo '<hr style="width:100%">'.'<h4>Books</h4>'.'<hr style="width:100%">';
                $result = $conn->query("select * from book_details where Book_id = '".$_SESSION['Search_Book']."' or Book_name= '".$_SESSION['Search_Book']."' or Author_name = '".$_SESSION['Search_Book']."' or Category_name = '".$_SESSION['Search_Book']."';");
                while($row=$result->fetch_assoc())
                {
                    $id = $row["Book_id"];
                    $name = $row["Book_name"];
                    $auth = $row["Author_name"];
                    $BookNumActual = $row["No_Copies_Actual"];
                    $BookNum = $row["No_Copies_Current"];
                    $Category_name= $row["Category_name"];

                    echo'<div class="col-sm-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">'.$name.'</h5>
                                <p name="Book_id">Book ID:'.$id.'</p>
                                <p name="Category">Category:'. $Category_name.'</p>
                                <p name="Number_of_books">Number of books:'.$BookNum.'</p>';
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
                                                style="float: right; disabled">Return</button>';
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
                            <small class="text-muted">Author:'.$auth.'</small>
                        </div>
                    </div>';
                }

                if(isset($_SESSION['User_Type']) && $_SESSION['User_Type'] == 'Manger')
                {
                    
                    echo '<hr style="width:100%">'.'<h4>Students</h4>'.'<hr style="width:100%">';
                    $result = $conn->query("select * from student_details where Student_Id = '".$_SESSION['Search_Book']."' or Student_Name = '".$_SESSION['Search_Book']."';");
                   while($row=$result->fetch_assoc())
                    {
                        $id = $row["Student_Id"];
                        $name = $row["Student_Name"];
                        $Gender = $row["Student_Gender"];
                        $Tax = $row["Student_Tax"];

                        echo'<div class="col-sm-4 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">'.$name.'</h5>
                                    <p name="Student_Id">Student ID: '.$id.'</p>
                                    <p name="Gender">Gender: '.$Gender.'</p>';
                                    if(!checkBorrow($id) && $Tax == 0)
                                            {
                                                echo'<button class="btn btn-success" type="submit" name="delete" value="'. $id.'"
                                                    style="float: right;">Delete</button>';
                                            }
                                        else
                                            {
                                                echo'<button class="btn btn-danger" type="submit" name="delete" value="'.$id.'"
                                                    style="float: right;" disabled>Delete</button>';
                                            }
                            echo'</div>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Taxes: '. $Tax.'</small>';
                                    if($Tax != 0)
                                    {
                                        echo'<button class="btn btn-success" type="submit" name="pay_taxes" value="'.$id.'"
                                                    style="float: right;">Pay Taxes</button>';
                                    }

                        echo' </div>
                        </div>';

                    }
                     echo '<hr style="width:100%">'.'<h4>Borrowed Books</h4>'.'<hr style="width:100%">';
                     $result = $conn->query("select * from borrower_details where Borrower_Id = '".$_SESSION['Search_Book']."' or Student_id = '".$_SESSION['Search_Book']."' or Book_Id = '".$_SESSION['Search_Book']."';");
                    while($row=$result->fetch_assoc())
                    {
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
                }
         ?>
        </div>
    </form>
</div>
<?php 
        include('/partials/footer.php')
?>
