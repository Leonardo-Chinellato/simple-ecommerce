<!-- connect file -->
<?php
    include('../functions/common_function.php');
    include('../includes/connect.php');
    @session_start();
   
   /* to check if the connection is ok */
    /* if($con){
        echo "connected";
    }else{
        die(mysqli_error($con));
    } */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the cache problem -->

</head>
<body>
    <div class="container-fluid my-5">
        <h2 class="text-center">Admin Login</h2>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6 col-xl-4">
            <img src="../images_from_google/admin_registration.png" alt="Admin login" class="img-fluid">
        </div>
        <div class="col-lg-4 col-xl-5" >
            <form action="" method="post">
                <div class="form-outline mb-4">
                    <label for="admin_name" class="form-label">Username</label>
                    <input type="text" name="admin_name" id="admin_name" required="required" placeholder="Enter your username" class="form-control" value="<?php if(isset($_POST['admin_login'])){$admin_name=filter_input(INPUT_POST,'admin_name',FILTER_SANITIZE_SPECIAL_CHARS); echo $admin_name;} ?>">
                </div>
                <div class="form-outline mb-4">
                    <label for="admin_password" class="form-label">Password</label>
                    <input type="password" name="admin_password" id="admin_password" required="required" placeholder="Enter your password" class="form-control">
                    <!-- <p class="small fw-bold mt-2 pt-1"><a class="link-danger" href="admin_XXXXX.php">Forgot password?</a></p> -->
                </div>
                <div>
                    <input type="submit" value="Login" class="bg-info py-2 px-3 border-0" name="admin_login">
                </div>
            </form>

        </div>

    </div>
    
</body>
</html>

<?php

if(isset($_POST['admin_login'])){
    /* $admin_name=$_POST['admin_name']; */
    $admin_name=filter_input(INPUT_POST,'admin_name',FILTER_SANITIZE_SPECIAL_CHARS);
    $admin_password=$_POST['admin_password'];

    if(
        $admin_name=='' OR
        $admin_password==''
    ){
        echo "<script>alert('Please, fill all the fields!')</script>";

    }else{

    $select_admin_users="SELECT * FROM `admin_table` WHERE admin_name='$admin_name'";
    $result_select_admin_users=mysqli_query($con,$select_admin_users);
    $row_count=mysqli_num_rows($result_select_admin_users);
    $row_data=mysqli_fetch_array($result_select_admin_users);

    if($row_count==0){
        echo "<script>alert('No registered admin!')</script>";
        echo "<script>window.open('admin_registration.php','_self')</script>";
    } else if (!password_verify($admin_password,$row_data['admin_password'])){
        echo "<script>alert('Invalid credentials!')</script>";
    } else {
        $_SESSION['admin_name']=$admin_name;
        echo "<script>alert('Login successful!')</script>";
        echo "<script>window.open('index.php','_self')</script>";
    }
    }
}

?>