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
    <title>User - Registration</title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the cache problem -->

</head>

<body>
    <div class="container-fluid my-3">
        <h2 class="text-center">New User Registration</h2>
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-12 col-xl-6">
                <form action="" method="post" enctype="multipart/form-data">
                    <!-- username field -->
                    <div class="form-outline mb-4">
                        <label for="user_username" class=""form-label>Username</label>
                        <input type="text" id="user_username" class="form-control" placeholder="Enter your username" autocomplete="off" required="required" name="user_username" value="<?php if(isset($_POST['user_register'])){$user_username=filter_input(INPUT_POST,'user_username',FILTER_SANITIZE_SPECIAL_CHARS); echo $user_username;} ?>">
                    </div>
                    <!-- email field -->
                    <div class="form-outline mb-4">
                        <label for="user_email" class=""form-label>Email</label>
                        <input type="email" id="user_email" class="form-control" placeholder="Enter your email" autocomplete="off" required="required" name="user_email" value="<?php if(isset($_POST['user_register'])){$user_email=filter_input(INPUT_POST,'user_email',FILTER_SANITIZE_EMAIL); echo $user_email;} ?>">
                    </div>
                    <!-- image field -->
                    <div class="form-outline mb-4">
                        <label for="user_image" class=""form-label>Image</label>
                        <input type="file" id="user_image" class="form-control" name="user_image" required="required">
                    </div>
                    <!-- password field -->
                    <div class="form-outline mb-4">
                        <label for="user_password" class=""form-label>Password</label>
                        <input type="password" id="user_password" class="form-control" placeholder="Enter your password" autocomplete="off" required="required" name="user_password">
                    </div>
                    <!-- confirm password field -->
                    <div class="form-outline mb-4">
                        <label for="conf_user_password" class=""form-label>Confirm Password</label>
                        <input type="password" id="conf_user_password" class="form-control" placeholder="Confirm your password" autocomplete="off" required="required" name="conf_user_password">
                    </div>
                    <!-- address field -->
                    <div class="form-outline mb-4">
                        <label for="user_address" class=""form-label>Address</label>
                        <input type="text" id="user_address" class="form-control" placeholder="Enter your address" autocomplete="off" required="required" name="user_address" value="<?php if(isset($_POST['user_register'])){$user_address=filter_input(INPUT_POST,'user_address',FILTER_SANITIZE_SPECIAL_CHARS); echo $user_address;} ?>">
                    </div>
                    <!-- contact field -->
                    <div class="form-outline mb-4">
                        <label for="user_contact" class=""form-label>Contact</label>
                        <input type="text" id="user_contact" class="form-control" placeholder="Enter your mobile number" autocomplete="off" required="required" name="user_contact" value="<?php if(isset($_POST['user_register'])){$user_contact=filter_input(INPUT_POST,'user_contact',FILTER_SANITIZE_SPECIAL_CHARS); echo $user_contact;} ?>">
                    </div>
                    
                    <!-- register button -->
                    <div class="mt-4 pt-2">
                        <input type="submit" value="Register" class="bg-info py-2 px-3 border-0" name="user_register">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Already have an account? <a class="text-danger" href="user_login.php">Login</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
</body>
</html>

<!-- PHP code -->
<?php
    global $con;

    if(isset($_POST['user_register'])){
        $user_username=filter_input(INPUT_POST,'user_username',FILTER_SANITIZE_SPECIAL_CHARS);
        $user_email=filter_input(INPUT_POST,'user_email',FILTER_SANITIZE_EMAIL);
        $user_password=$_POST['user_password'];
        $hash_password=password_hash($user_password,PASSWORD_DEFAULT);
        $conf_user_password=$_POST['conf_user_password'];
        $user_address=filter_input(INPUT_POST,'user_address',FILTER_SANITIZE_SPECIAL_CHARS);
        $user_contact=filter_input(INPUT_POST,'user_contact',FILTER_SANITIZE_SPECIAL_CHARS);

            // image
                $allowedFormats=array("jpeg", "jpg", "png", "gif");
                $user_image=$_FILES['user_image']['name'];
                $extension=pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);

                      
 
        $user_ip=getIPAddress();

        // select query
        $select_query="SELECT * FROM `user_table` WHERE username='$user_username' OR user_email='$user_email'";
        $result_select_query=mysqli_query($con,$select_query);

        $rows_count=mysqli_num_rows($result_select_query);
        
        //check if is empty
        if(
            $user_username=='' OR
            $user_email=='' OR
            $user_password=='' OR
            $conf_user_password=='' OR
            $user_address=='' OR
            $user_image=='' OR
            $user_contact==''
        ){
            echo "<script>alert('Please, fill all the fields!')</script>";
        }
        else if($rows_count>0){
            echo "<script>alert('User or Email is already exist!')</script>";
        }
        else if($user_password!=$conf_user_password){
            echo "<script>alert('Password does not match!')</script>";
        }
        else if(in_array($extension, $allowedFormats)){
            
            // Get the temporary file location
            $user_image_tmp=$_FILES['user_image']['tmp_name'];
            
            // Set the desired dimensions for the resized image
            $maxWidth="354";
            $maxHeight="472";

            // Load the original image
            $imageInfo = getimagesize($user_image_tmp);
            $originalWidth = $imageInfo[0];
            $originalHeight = $imageInfo[1];
            $mime = $imageInfo['mime'];

            switch ($mime) {
                case 'image/jpeg':
                    $originalImage = imagecreatefromjpeg($user_image_tmp);
                    break;
                case 'image/png':
                    $originalImage = imagecreatefrompng($user_image_tmp);
                    break;
                case 'image/gif':
                    $originalImage = imagecreatefromgif($user_image_tmp);
                    break;
                default:
                    // Handle unsupported image formats
                    exit('Unsupported image format.');
            }

            // Calculate the new dimensions while maintaining the aspect ratio
            $aspectRatio = $originalWidth / $originalHeight;
            if ($originalWidth > $maxWidth || $originalHeight > $maxHeight) {
                if ($maxWidth / $maxHeight > $aspectRatio) {
                    $newWidth = $maxHeight * $aspectRatio;
                    $newHeight = $maxHeight;
                } else {
                    $newWidth = $maxWidth;
                    $newHeight = $maxWidth / $aspectRatio;
                }
            } else {
                $newWidth = $originalWidth;
                $newHeight = $originalHeight;
            }

            // Create a new image with the resized dimensions
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            // Set the desired compression level or quality based on the original format
            $compressionQuality = 80; // For JPEG
            $compressionLevel = 9; // For PNG

            // Output or save the resized image based on the original format
            $resizedImagePath = "./user_images/$user_image";

            switch ($mime) {
                case 'image/jpeg':
                    imagejpeg($resizedImage, $resizedImagePath, $compressionQuality);
                    break;
                case 'image/png':
                    imagepng($resizedImage, $resizedImagePath, $compressionLevel);
                    break;
                case 'image/gif':
                    imagegif($resizedImage, $resizedImagePath);
                    break;
                default:
                    // Handle unsupported image formats
                    exit('Unsupported image format.');
            }

            // Free up memory by destroying the image resources
            imagedestroy($originalImage);
            imagedestroy($resizedImage);


            // insert query
            $insert_query="INSERT INTO `user_table` (username,user_email,user_password,user_image,user_ip,user_address,user_mobile) VALUES ('$user_username','$user_email','$hash_password','$user_image','$user_ip','$user_address','$user_contact')";
            $sql_execute=mysqli_query($con,$insert_query);
            if($sql_execute){
                $_SESSION['username']=$user_username;
                echo "<script>alert('Data inserted successfully')</script>";
                echo "<script>window.open('../index.php','_self')</script>";
                
            }else{
                die(mysqli_error($con));
            }
        }else{
            echo "<script>alert('Invalid image format!')</script>";
            echo "<script>window.open('user_registration.php?user_register','_self')</script>";
        }
    }



?>