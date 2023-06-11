<?php
if(isset($_GET['edit_account'])){
    $user_session_name=$_SESSION['username'];
    $select_query="SELECT * FROM `user_table` WHERE username='$user_session_name'";
    $result_select_query=mysqli_query($con,$select_query);
    $row_fetch=mysqli_fetch_assoc($result_select_query);
    $user_id=$row_fetch['user_id'];
    $username=$row_fetch['username'];
    $user_email=$row_fetch['user_email'];
    $user_address=$row_fetch['user_address'];
    $user_mobile=$row_fetch['user_mobile'];
}

if(isset($_POST['user_update'])){
    $update_id=$user_id;
    $username=filter_input(INPUT_POST,'user_username',FILTER_SANITIZE_SPECIAL_CHARS);
    $user_email=filter_input(INPUT_POST,'user_email',FILTER_SANITIZE_EMAIL);
    $user_address=filter_input(INPUT_POST,'user_address',FILTER_SANITIZE_SPECIAL_CHARS);
    $user_mobile=filter_input(INPUT_POST,'user_mobile',FILTER_SANITIZE_SPECIAL_CHARS);
    /* $user_image=$_FILES['user_image']['name']; */
    /* $user_image_tmp=$_FILES['user_image']['tmp_name']; */

            // image
                $allowedFormats=array("jpeg", "jpg", "png", "gif");
                $user_image=$_FILES['user_image']['name'];
                $extension=pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);
                
                if($user_image!==''){
                    if(in_array($extension, $allowedFormats)){
                        $user_image_tmp=$_FILES['user_image']['tmp_name'];
                                    
                    }else{
                        echo "<script>alert('Invalid format!')</script>";
                        echo "<script>window.open('profile.php','_self')</script>";
                    }
                }       
    
    if(
        $username=='' OR
        $user_email=='' OR
        $user_address=='' OR
        $user_mobile=='' OR
        $user_image=='' 
    ){
        echo "<script>alert('Please, fill all the fields!')</script>";
        echo "<script>window.open('profile.php','_self')</script>";
    }else{
    move_uploaded_file($user_image_tmp,"./user_images/$user_image");

    // update query
    $update_data="UPDATE `user_table` SET username='$username',user_email='$user_email',user_image='$user_image',user_address='$user_address',user_mobile='$user_mobile' WHERE user_id=$update_id";
    $result_update_data=mysqli_query($con,$update_data);

    if($result_update_data){
        echo "<script>alert('Data updated successfully')</script>";
        echo "<script>window.open('logout.php','_self')</script>";
    }
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the cache problem -->

</head>
<body>
    <h3 class="text-center text-success mb-4">Edit Account</h3>
    <form action="" method="post" enctype="multipart/form-data" class="text-center">
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" name="user_username" value="<?PHP echo $username; ?>" required="required">
        </div>
        <div class="form-outline mb-4">
            <input type="email" class="form-control w-50 m-auto" name="user_email" value="<?PHP echo $user_email; ?>" required="required">
         </div>
        <div class="form-outline mb-4 w-50 d-flex m-auto">
            <input type="file" class="form-control m-auto" name="user_image" required="required">
            <img class="admin_image" src="./user_images/<?php echo $user_image;?>" alt=""> <!-- $user_image comes from array in profile.php -->
        </div>
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" name="user_address" value="<?PHP echo $user_address; ?>" required="required">
        </div>
        <div class="form-outline mb-4">
            <input type="text" class="form-control w-50 m-auto" name="user_mobile" value="<?PHP echo $user_mobile; ?>" required="required">
        </div>
        <input type="submit" value="Update" class="bg-info py-2 px-3 border-0" name="user_update">
    </form>
    
</body>
</html>