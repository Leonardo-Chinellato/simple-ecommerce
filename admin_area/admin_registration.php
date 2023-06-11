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
    <title>Admin Registration</title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the cache problem -->

</head>
<body>
    <div class="container-fluid my-5">
        <h2 class="text-center">New User Registration</h2>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-lg-6 col-xl-4">
            <img src="../images_from_google/admin_registration.png" alt="Admin registration" class="img-fluid">
        </div>
        <div class="col-lg-4 col-xl-5" >
            <form action="" method="post">
                <div class="form-outline mb-4">
                    <label for="admin_name" class="form-label">Username</label>
                    <input type="text" name="admin_name" id="admin_name" required="required" placeholder="Enter your username" class="form-control" value="<?php if(isset($_POST['admin_registration'])){$admin_name=filter_input(INPUT_POST,'admin_name',FILTER_SANITIZE_SPECIAL_CHARS); echo $admin_name; } ?>">
                </div>
                <div class="form-outline mb-4">
                    <label for="admin_email" class="form-label">Email</label>
                    <input type="email" name="admin_email" id="admin_email" required="required" placeholder="Enter your email" class="form-control" value="<?php if(isset($_POST['admin_registration'])){$admin_email=filter_input(INPUT_POST,'admin_email',FILTER_SANITIZE_EMAIL); echo $admin_email; } ?>">
                </div>
                <div class="form-outline mb-4">
                    <label for="admin_password" class="form-label">Password</label>
                    <input type="password" name="admin_password" id="admin_password" required="required" placeholder="Enter your password" class="form-control">
                </div>
                <div class="form-outline mb-4">
                    <label for="confirm_admin_password" class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_admin_password" id="confirm_admin_password" required="required" placeholder="Confirm your password" class="form-control">
                </div>
                <div>
                    <input type="submit" value="Register" class="bg-info py-2 px-3 border-0" name="admin_registration">
                    <p class="small fw-bold mt-2 pt-1">Don't you have an account? <a class="link-danger" href="admin_login.php">Login</a></p>
                </div>
            </form>

        </div>

    </div>
    
</body>
</html>

<?php
if(isset($_POST['admin_registration'])){
    $admin_name=filter_input(INPUT_POST,'admin_name',FILTER_SANITIZE_SPECIAL_CHARS);
    $admin_email=filter_input(INPUT_POST,'admin_email',FILTER_SANITIZE_EMAIL);
    $admin_password=$_POST['admin_password'];
    $hash_password=password_hash($admin_password,PASSWORD_DEFAULT);
    $confirm_admin_password=$_POST['confirm_admin_password'];

    if(
        $admin_name=='' OR
        $admin_email=='' OR
        $admin_password=='' OR
        $confirm_admin_password==''
    ){
        echo "<script>alert('Please, fill all the fields!')</script>";
    }else{

    $select_admin="SELECT * FROM `admin_table` WHERE admin_name='$admin_name' OR admin_email='$admin_email'";
    $result_select_admin=mysqli_query($con,$select_admin);

    $admin_num_row=mysqli_num_rows($result_select_admin);

    if($admin_num_row>0){
        echo "<script>alert('The username or the email is already exist!')</script>";
    } else if($admin_password!=$confirm_admin_password){
        echo "<script>alert('The password does not match!')</script>";
    } else{
        // insert query
        $insert_admin="INSERT INTO `admin_table` (admin_name,admin_email,admin_password) VALUES ('$admin_name','$admin_email','$hash_password')";
        $result_insert_admin=mysqli_query($con,$insert_admin);

        if($result_insert_admin){
            $_SESSION['admin_name']=$admin_name;
            echo "<script>alert('User registered successfully!')</script>";
            echo "<script>window.open('index.php','_self')</script>";
        }else{
            die(mysqli_error($con));
        }
    }
    }
}



?>