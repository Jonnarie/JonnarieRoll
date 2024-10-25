<?php
    

    if(isset($_POST['delete'])){
        $deleteId = $_POST['deleteID'];

        $querydelete = "DELETE FROM studenttbl WHERE ID = $deleteId";
        $sqldelete = mysqli_query($connection, $querydelete);

        echo '<script>alert("Successfully Deleted!");</script>';

        echo '<script>window.location.href = "/JONNARIE/read-all.php";</script>';
    }