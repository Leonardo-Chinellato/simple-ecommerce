<?php
include('../includes/connect.php');

if(isset($_POST['insert_product'])){ /* This data is the "name" of the submit buttom */

    $product_title=filter_input(INPUT_POST,'product_title',FILTER_SANITIZE_SPECIAL_CHARS);
    $product_description=filter_input(INPUT_POST,'product_description',FILTER_SANITIZE_SPECIAL_CHARS);
    $product_keywords=filter_input(INPUT_POST,'product_keywords',FILTER_SANITIZE_SPECIAL_CHARS);
    $product_category=$_POST['product_category'];
    $product_brand=$_POST['product_brand'];
    $product_price=filter_input(INPUT_POST,'product_price',FILTER_SANITIZE_SPECIAL_CHARS);
    $product_status='true';

    $allowedFormats=array("jpeg", "jpg", "png", "gif");
    $error = 0;
    foreach($_FILES['product_image']['name'] as $key => $image){
        $extension = pathinfo($_FILES['product_image']['name'][$key], PATHINFO_EXTENSION);
        if(!in_array($extension, $allowedFormats)){
            $error++;
        }
    }

    if ($error > 0) {
        echo "<script>alert('Invalid format! Only JPEG, JPG, PNG, or GIF images are allowed.')</script>";
    } elseif (!empty($_FILES['product_image']['tmp_name'])) {
        // Additional check to ensure all files are images
        $isValidImage = true;
    
        foreach ($_FILES['product_image']['tmp_name'] as $key => $image) {
            $extension = pathinfo($_FILES['product_image']['name'][$key], PATHINFO_EXTENSION);
            if (!in_array($extension, $allowedFormats)) {
                $isValidImage = false;
                break;
            }
        }
    
        if (!$isValidImage) {
            echo "<script>alert('Invalid format! Only JPEG, JPG, PNG, or GIF images are allowed.')</script>";
        } else {
            // Remaining code for compressing and inserting the images
        


    

    // checking empty condition
    if(
        $product_title=='' or
        $product_description=='' or
        $product_keywords=='' or
        $product_category=='' or
        $product_brand=='' or
        $product_price=='' 
    ){
        echo "<script>alert('Please, fill all the fields!')</script>";
        /* exit(); */ /* Instructed to insert this, but I didn't understand why it's here */
        
        
    }else if(in_array($extension, $allowedFormats)){

        // Upload and compress images
        $compressedImagePaths = array();

        foreach($_FILES['product_image']['tmp_name'] as $key => $image){
            $compressedImagePath = $_FILES['product_image']['name'][$key];
            // Compress the image manually (adjust compression quality as needed)
            compressImage($image, "./products_images/" . $_FILES['product_image']['name'][$key], 70);

            $compressedImagePaths[] = $compressedImagePath;
        }
            
        

        // insert query
        $insert_products="insert into products (product_title,product_description,product_keywords,category_id,brand_id,product_price,product_image1,product_image2,product_image3,date,status) values ('$product_title','$product_description','$product_keywords','$product_category','$product_brand','$product_price','".$compressedImagePaths[0]."','".$compressedImagePaths[1]."','".$compressedImagePaths[2]."',NOW(),'$product_status')";
        $result_query=mysqli_query($con,$insert_products);

        if($result_query){
            echo "<script>alert('Successfully inserted products!')</script>";
            echo "<script>window.open('index.php?view_products','_self')</script>";
        }

    }else{
        echo "<script>alert('Invalid format!')</script>";
        echo "<script>window.open('index.php?insert_products','_self')</script>";
    }
    
}
}
}

function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);
    } else {
        return false;
    }

    imagejpeg($image, $destination, $quality);
    imagedestroy($image);

    return true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Products-Admin Dashboard</title>
    
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!-- css file -->
     <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the chache problem -->

</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Product</h1>
        <!-- form -->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" name="product_title" id="product_title" class="form-control" placeholder="Enter product title" autocomplete="off" required="required" value="<?php if(isset($_POST['insert_product'])){echo $product_title;} ?>">
            </div>
            <!-- description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_description" class="form-label">Product Description</label>
                <input type="text" name="product_description" id="product_description" class="form-control" placeholder="Enter product description" autocomplete="off" required="required" value="<?php if(isset($_POST['insert_product'])){echo $product_description;} ?>">
            </div>
            <!-- keywords -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_keywords" class="form-label">Product Keywords</label>
                <input type="text" name="product_keywords" id="product_keywords" class="form-control" placeholder="Enter product keywords" autocomplete="off" required="required" value="<?php if(isset($_POST['insert_product'])){echo $product_keywords;} ?>">
            </div>
            <!-- categories -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_category" class="form-label">Product Category</label>
                <select name="product_category" id="" class="form-select">
                    <?php
                        $select_query="select * from categories";
                        $result_query=mysqli_query($con,$select_query);
                        
                        while($row=mysqli_fetch_assoc($result_query)):
                            $category_title=$row['category_title'];
                            $category_id=$row['category_id'];
                        
                            echo "<option value='$category_id'>$category_title</option>";
                        endwhile;
                    ?>
                </select>
            </div>
            <!-- brands -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_brand" class="form-label">Product Brand</label>
                <select name="product_brand" id="" class="form-select">
                    <?php
                        $select_query="select * from brands";
                        $result_query=mysqli_query($con,$select_query);

                        while($row=mysqli_fetch_assoc($result_query)):
                            $brand_title=$row['brand_title'];
                            $brand_id=$row['brand_id'];
                            
                            echo "<option value='$brand_id'>$brand_title</option>";
                        endwhile;
                    ?>
                </select>
            </div>
            <!-- image I -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image1" class="form-label">Product Image I</label>
                <input type="file" name="product_image[]" id="product_image1" class="form-control" required="required">
            </div>
            <!-- image II -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image2" class="form-label">Product Image II</label>
                <input type="file" name="product_image[]" id="product_image2" class="form-control" required="required">
            </div>
            <!-- image III -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_image3" class="form-label">Product Image III</label>
                <input type="file" name="product_image[]" id="product_image3" class="form-control" required="required">
            </div>
            <!-- price -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter product price" autocomplete="off" required="required" value="<?php if(isset($_POST['insert_product'])){echo $product_price;} ?>">
            </div>
            <!-- submit -->
            <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" value="Insert products" name="insert_product" class="btn btn-info mb-3 px-3">
            </div>

        </form>
    </div>
</body>
</html>