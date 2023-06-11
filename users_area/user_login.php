<!-- connect file -->
<?php
    include('../functions/common_function.php');
    include('../includes/connect.php');
    @session_start();
   
   /* to check if the connection is ok */
    /*  if($con){
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
    <title>User - Login</title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the cache problem -->

</head>

<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">User Login</h2>
        <div class="row d-flex align-items-center justify-content-center mt-5">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post">
                    <!-- username field -->
                    <div class="form-outline mb-4">
                        <label for="user_username" class=""form-label>Username</label>
                        <input type="text" id="user_username" class="form-control" placeholder="Enter your username" autocomplete="off" required="required" name="user_username" value="<?php if(isset($_POST['user_login'])){$user_username=filter_input(INPUT_POST,'user_username',FILTER_SANITIZE_SPECIAL_CHARS); echo $user_username;} ?>">
                    </div>
                    <!-- password field -->
                    <div class="form-outline mb-4">
                        <label for="user_password" class=""form-label>Password</label>
                        <input type="password" id="user_password" class="form-control" placeholder="Enter your password" autocomplete="off" required="required" name="user_password">
                    </div>
                    <!-- login button -->
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Login" class="bg-info py-2 px-3 border-0" name="user_login">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a class="text-danger" href="user_registration.php">Register</a></p>
                        <p class="small fw-bold mt-4 pt-1 mb-0">Are you Admin? <a class="text-success" href="../admin_area/admin_login.php">Admin Login</a></p>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</body>
</html>

<?php
    if(isset($_POST['user_login'])){
        
        $user_username=filter_input(INPUT_POST,'user_username',FILTER_SANITIZE_SPECIAL_CHARS);
        $user_password=$_POST['user_password'];

        if(
            $user_username=='' OR
            $user_password==''
        ){
            echo "<script>alert('Please, fill all the fields!')</script>";
        }else{
        
        $select_query_username="SELECT * FROM `user_table` WHERE username='$user_username'";
        $result_select_query=mysqli_query($con,$select_query_username);
        $row_count=mysqli_num_rows($result_select_query);
        $row_data=mysqli_fetch_assoc($result_select_query);
        $user_active=$row_data['user_active'];
        $user_ip=getIPAddress();


        // cart item
        $select_query_ip_address="SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
        $result_select_query_ip_address=mysqli_query($con,$select_query_ip_address);
        $row_count_cart_ip_address=mysqli_num_rows($result_select_query_ip_address);

        
        if($row_count>0){

            if(password_verify($user_password,$row_data['user_password'])){
                
                if($user_active=="No"){
                    echo "<script>alert('Your account has been desabled, please contact our suport!')</script>";
                    echo "<script>window.open('../index.php','_self')</script>";
                }else{

                    if($row_count==1 and $row_count_cart_ip_address==0){ 
                        $_SESSION['username']=$user_username;   
                        echo "<script>alert('Login successful!')</script>";
                        echo "<script>window.open('profile.php','_self')</script>";
                    }else{
                        $_SESSION['username']=$user_username; 
                        echo "<script>alert('Login successful!')</script>";
                        echo "<script>window.open('checkout.php','_self')</script>";
                    }
                }

            }else{
                echo "<script>alert('Invalid credentials!')</script>";
            }

        }else{
            echo "<script>alert('No registered user!')</script>";
            echo "<script>window.open('user_registration.php','_self')</script>";
        }

    }
}

?>