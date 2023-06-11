<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3 class="text-danger mb-4">Delete Account</h3>
    <form action="" method="post" class="mt-5">
        <div class="form-outline mb-4">
            <input type="submit" value="Delete Account" class="form-control w-50 m-auto bg-danger text-light" name="delete">
        </div>
        <div class="form-outline mb-4">
            <input type="submit" value="Don't Delete Account" class="form-control w-50 m-auto bg-success text-light" name="dont_delete">
        </div>
    </form>

    <?php
        $username_session=$_SESSION['username'];

        if(isset($_POST['delete'])){
            $delete_query="DELETE FROM `user_table` WHERE username='$username_session'";
            $result_delete_query=mysqli_query($con,$delete_query);
            if($result_delete_query){
                session_destroy();
                echo "<script>alert('Account Deleted Successfully')</script>";
                echo "<script>window.open('../index.php','_self')</script>";
            }
        }

        if(isset($_POST['dont_delete'])){
            echo "<script>window.open('profile.php','_self')</script>";
        }
    ?>
</body>
</html>