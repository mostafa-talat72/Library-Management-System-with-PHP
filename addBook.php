<?php
    include('connection.php');
    include('/partials/nav.php');
    session_start();
    $errors = ['book_id'=>'',
    'book_name'=>'',
    'Author'=>'',
    'Language'=>'',
    'Publication'=>'',
    'Actual'=>'',
    'Category'=>''];
    // check if form submit
    if(isset($_POST['addBook'])){
    // store values as String

        $book_id=mysqli_real_escape_string($conn,  $_POST['book_id']);
        $book_name =mysqli_real_escape_string($conn, $_POST['book_name']);
        $Author =mysqli_real_escape_string($conn, $_POST['Author']);
        $Language=mysqli_real_escape_string($conn, $_POST['Language']);
        $Publication =mysqli_real_escape_string($conn, $_POST['Publication']);
        $Actual = mysqli_real_escape_string($conn,$_POST['Actual']);
        $Category = mysqli_real_escape_string($conn,$_POST['Category']);
        // check if inputs empty 
        if(empty($book_id)){
        $errors['book_id'] = "Enter book id";
        }
        if(empty($book_name)){
        $errors['book_name'] = "Enter book name";
        }
        if(empty($Author)){
        $errors['Author'] = "Enter Author"; 
        }
        if(empty($Language)){
        $errors['Language'] = "Enter Language"; 
        }
        if(empty($Publication)){
            $errors['Publication'] = "Enter Publication Year"; 
        }
        if(empty($Actual)){
            $errors['Actual'] = "Enter Actual book number"; 
        }
        if(empty($Category)){
            $errors['Category'] = "Enter Category name"; 
        }
        
        // check if no errors and create query
        if(!array_filter($errors)){
        // create query and put into variable
        $ins ="insert into Book_Details values('$book_id','$book_name','$Author','$Language',$Publication,$Actual,$Actual,'$Category');";
        // add query to connection and check 
        if(mysqli_query($conn,$ins)){
    //    header('Location:home.php');
        echo "<div class='container alert alert-success alert-dismissible fade show' role='alert'>Book added successfully</div>";
        }else{
        echo 'Error: '. mysqli_error($conn);
        }
        }
         unset($_POST['addBook']);
    }

?>

<div class="container" style="min-height: 85.3vh;">
    <?php
     if(!isset($_SESSION['User_ID']) || $_SESSION['User_ID'] == 'Student')
        {
          header('Location: logOut.php');
        }
    ?>
    <form class="needs-validation" novalidate method="post">

        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom01">Book Id</label>
                <input type="number" name="book_id" class="form-control" id="validationCustom01" placeholder="Book id"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please choose a Book Id.
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationCustom02">Book name</label>
                <input type="text" name="book_name" class="form-control" id="validationCustom02" placeholder="Book name"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please choose a Book name.
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationCustom03">Author name</label>
                <div class="input-group">
                    <input type="text" name="Author" class="form-control" id="validationCustom03"
                        placeholder="Author name" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Please choose a Author name.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom04">Language</label>
                <input type="text" name="Language" class="form-control" id="validationCustom04" placeholder="Language"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please choose a language.
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationCustom05">Publication Year</label>
                <input type="number" name="Publication" class="form-control" id="validationCustom05"
                    placeholder="Publication Year" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please choose a Publication Year.
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <label for="validationCustom06">Number of Books</label>
                <div class="input-group">
                    <input type="number" name="Actual" class="form-control" id="validationCustom06"
                        placeholder="Number of Books" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Please choose a Number of Books.
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-4 mb-3">
                <label for="validationCustom07">Category</label>
                <input type="text" name="Category" class="form-control" id="validationCustom07" placeholder="Category"
                    required>
                <div class="valid-feedback">
                    Looks good!
                </div>
                <div class="invalid-feedback">
                    Please choose a Category.
                </div>
            </div>
        </div>

        <input class="btn btn-primary" type="submit" value="Add" name="addBook">
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
