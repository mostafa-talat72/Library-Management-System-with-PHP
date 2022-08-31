<?php
    session_start();
    if(isset($_POST['submit']))
    {
        $_SESSION['Search_Book']=$_POST['search'];
        header('Location: SearchPage.php');
    }
?>
<!doctype html>
<html lang="en">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Library!</title>
</head>

<body>

    <div class="container" style="min-height: 15vh;">
        <form class="needs-validation" method="post" novalidate>
            <ul class="nav nav-pills mb-3" style="float:right;">
                <?php
                if(isset($_SESSION['User_ID']))
                {
                    echo '<li class="nav-item"><a class="nav-link"  href="#">';echo $_SESSION['User_Name']; 
                    echo'</a></li>
                    <li class="nav-item"> <a class="nav-link" href="#">|</a></li> 
                    <li class="nav-item"> <a class="nav-link" href="logOut.php">Logout</a></li>';
                    
                }
                else
                    {
                    echo '
                        <li class="nav-item">
                            <a class="nav-link" href="signIn.php">Sign-In</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signUp.php">Sign-Up</a>
                        </li>';
                    }
            ?>
            </ul>
            <ul class="nav nav-pills mb-3">
                <?php
                 if(isset($_SESSION['User_Type']))
                 {
                     echo '<li class="nav-item"><a class="nav-link"  href="#">';echo $_SESSION['User_Type'].' ID: '.$_SESSION['User_ID']; echo'</a></li>';
                    if($_SESSION['User_Type']==='Student')
                     {
                         echo '<li class="nav-item"><a class="nav-link"  href="#">';echo 'Taxes: '. $_SESSION['Student_Tax']; echo'</a></li>';
                         if(isset($_SESSION['Book_ID_Borrowed']))
                         {
                            echo '<li class="nav-item"><a class="nav-link"  href="#">';echo 'Borrowed Book Id: '. $_SESSION['Book_ID_Borrowed']; echo'</a></li>';
                            echo '<li class="nav-item"><a class="nav-link"  href="#">';echo 'Borrowed Id: '.$_SESSION['Borrower_ID']; echo'</a></li>';
                         }
                     }
                 }
            ?>
            </ul>
            <?php
             if(isset($_SESSION['User_Type']))
             {
                 echo '  <div style="float:right;">
                <div style="float:left;">
                    <input type="text" name="search" class="form-control" placeholder="Search" style="float:left;">
                </div>
                <div style="float:right;">
                    <input class="btn btn-primary" type="submit" value="Search" name="submit" style="float:right;">
                </div>
                 </div>';
             }
            ?>


            <ul class="nav nav-pills mb-3">

                <?php 
            if(isset($_SESSION['User_Type']))
            {
               echo '<li class="nav-item"><a class="nav-link" href="home.php">Books</a></li>';
                if($_SESSION['User_Type']==='Manger')
                {
                    echo'<li class="nav-item">
                        <a class="nav-link" href="Student.php">Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="addBook.php">Add Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="BorrowedBook.php">Borrowed Books</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="history.php">History</a>
                    </li>
                    ';
                }
                else
                {
                    
                    echo '<li class="nav-item"><a class="nav-link" href="StudentHistory.php">History</a></li>';
                }
            }
            ?>

            </ul>
        </form>
    </div>
