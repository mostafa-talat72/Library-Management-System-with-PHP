<?php
  include('/partials/nav.php');
    // include Connection
  include('connection.php');
  session_start();
?>
<div class="container" style="min-height: 85.3vh;">
    <?php
     if(!isset($_SESSION['User_ID']))
        {
          header('Location: logOut.php');
        }
    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Borrower_id</th>
                <th scope="col">Student_id</th>
                <th scope="col">Book_id</th>
                <th scope="col">Action_date</th>
                <th scope="col">Action_name</th>
                <th scope="col">Manger_id</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $result = $conn->query("select * from history_detalis;");
                while($row=$result->fetch_assoc()){
                    $Student_id = $row["Student_id"];
                    $Borrower_id = $row["Borrower_id"];
                    $Book_id = $row["Book_id"];
                    $Action_date = $row["Action_date"];
                    $Action_name = $row["Action_name"];
                    $Manger_id = $row["Manger_id"];
                ?>
            <tr>
                <th scope="row"><?php echo $Borrower_id ?></th>
                <td><?php echo $Student_id ?></td>
                <td><?php echo $Book_id ?></td>
                <td><?php echo $Action_date ?></td>
                <td><?php echo $Action_name ?></td>
                <td><?php echo $Manger_id ?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<?php 
    include('/partials/footer.php')
?>
