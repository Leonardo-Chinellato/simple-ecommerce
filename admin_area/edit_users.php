<div class="container mt-5">
    <h1 class="text-center mb-5">Edit User</h1>
    <form action="" method="post" enctype="multipart/form-data">

        <!-- show de values from mysql in the form -->
        <?php
            if(isset($_GET['edit_users'])){
                $edit_users=$_GET['edit_users'];

                $select_users="SELECT * FROM `user_table` WHERE user_id=$edit_users";
                $result_select_users=mysqli_query($con,$select_users);

                $row_data=mysqli_fetch_array($result_select_users);

                $user_id=$row_data['user_id'];
                $username=$row_data['username'];
                $user_email=$row_data['user_email'];
                $user_image=$row_data['user_image'];
                $user_address=$row_data['user_address'];
                $user_mobile=$row_data['user_mobile'];
                $user_active=$row_data['user_active'];
                $user_ip=$row_data['user_ip'];

            }
        
        ?>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required="required" value="<?php echo $username ?>">
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="user_email" class="form-label">Email</label>
            <input type="text" class="form-control" id="user_email" name="user_email" required="required" value="<?php echo $user_email ?>">
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="user_image" class="form-label">User Image </label>
            <div class="d-flex form-control w-90">
                <input type="file" class="form-control" id="user_image" name="user_image" required="required">
                <img class="admin_image" src="../users_area/user_images/<?php echo $user_image?>" alt="">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="user_address" class="form-label">User Address</label>
            <input type="text" class="form-control" id="user_address" name="user_address" required="required" value="<?php echo $user_address ?>">
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="user_mobile" class="form-label">User Mobile</label>
            <input type="text" class="form-control" id="user_mobile" name="user_mobile" required="required" value="<?php echo $user_mobile ?>">
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="user_active" class="form-label">User Active</label>
            <select name="user_active" class="form-select" value="<?php echo $user_active ?>">
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>
        <div class="form-outline w-50 m-auto mb-4 text-center">
            <input type="submit" value="Update User" class="btn btn-info py-2 px-3 border-0" name="user_update">
        </div>
    </form>
</div>

<!-- Editing users -->
<?php
if(isset($_POST['user_update'])){
    $user_id=$user_id;
    $username=filter_input(INPUT_POST,'username',FILTER_SANITIZE_SPECIAL_CHARS);
    $user_email=filter_input(INPUT_POST,'user_email',FILTER_SANITIZE_EMAIL);
    $user_address=filter_input(INPUT_POST,'user_address',FILTER_SANITIZE_SPECIAL_CHARS);
    $user_mobile=filter_input(INPUT_POST,'user_mobile',FILTER_SANITIZE_SPECIAL_CHARS);
    $user_active=filter_input(INPUT_POST,'user_active',FILTER_SANITIZE_SPECIAL_CHARS);

            // image
                $allowedFormats=array("jpeg", "jpg", "png", "gif");
                $user_image=$_FILES['user_image']['name'];
                $extension=pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);
                
                
                

    // checking to fields empty or not
    if(
        $username=='' OR
        $user_email=='' OR
        $user_image=='' OR
        $user_address=='' OR
        $user_mobile=='' OR
        $user_active==''

    ){
        echo "<script>alert('Please fill all the fields and continue the process')</script>"; 
    }else if(in_array($extension, $allowedFormats)){
        
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
        $resizedImagePath = "../users_area/user_images/$user_image";

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



        // update query
        $update_user="UPDATE `user_table` SET username='$username',user_email='$user_email',user_image='$user_image',user_address='$user_address',user_mobile='$user_mobile',user_active='$user_active' WHERE user_id=$user_id";
        $result_update_user=mysqli_query($con,$update_user);

        if($result_update_user){
            echo "<script>alert('User updated successfully')</script>";
            echo "<script>window.open('index.php?list_users','_self')</script>";
        }
    }else{
        echo "<script>alert('Invalid format!')</script>";
        echo "<script>window.open('index.php?edit_users=$edit_users','_self')</script>";
    }
}