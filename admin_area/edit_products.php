<!-- show de values from mysql in the form -->
<?php
if(isset($_GET['edit_products'])){
    $product_id=$_GET['edit_products'];
    $select_products="SELECT * FROM `products` WHERE product_id=$product_id";
    $result_select_products=mysqli_query($con,$select_products);

    $row_fetch=mysqli_fetch_array($result_select_products);
    $product_title=$row_fetch['product_title'];
    $product_description=$row_fetch['product_description'];
    $product_keywords=$row_fetch['product_keywords'];
    
    $category_id=$row_fetch['category_id'];  
        // fetching category name
        $select_category="SELECT * FROM `categories` WHERE category_id=$category_id";
        $result_select_category=mysqli_query($con,$select_category);
            $row_fetch_category=mysqli_fetch_array($result_select_category);
            $category_id=$row_fetch_category['category_id'];
            $category_title_show=$row_fetch_category['category_title'];
            if($category_title_show==''){
                $category_title="No Category";
            }else{
                $category_title=$category_title_show;
            }


    $brand_id=$row_fetch['brand_id'];
        // fetching brand name
        $select_brand="SELECT * FROM `brands` WHERE brand_id=$brand_id";
        $result_select_brand=mysqli_query($con,$select_brand);
            $row_fetch_brand=mysqli_fetch_array($result_select_brand);
            $brand_id=$row_fetch_brand['brand_id'];
            $brand_title_show=$row_fetch_brand['brand_title'];
            if($brand_title_show==''){
                $brand_title="No Brand";
            }else{
                $brand_title=$brand_title_show;
            }


    $product_image1=$row_fetch['product_image1'];
    $product_image2=$row_fetch['product_image2'];
    $product_image3=$row_fetch['product_image3'];
    $product_price=$row_fetch['product_price'];
    
}
?>

<div class="container mt-5">
    <h1 class="text-center">Edit Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" class="form-control" id="product_title" name="product_title" required="required" value="<?php echo $product_title ?>">
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_description" class="form-label">Product Description</label>
            <input type="text" class="form-control" id="product_description" name="product_description" required="required" value="<?php echo $product_description ?>">
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" class="form-control" id="product_keywords" name="product_keywords" required="required" value="<?php echo $product_keywords ?>">
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_category" class="form-label">Product Category</label>
            <select name="product_category" class="form-select" value="">
                <option value="<?php echo $category_title ?>"><?php echo $category_title ?></option>
                <?php
                    $select_all_categories="SELECT * FROM `categories`";
                    $result_select_all_categories=mysqli_query($con,$select_all_categories);
                    
                    while($row_fetch_all_categories=mysqli_fetch_array($result_select_all_categories)){
                        $category_id=$row_fetch_all_categories['category_id'];
                        $category_title=$row_fetch_all_categories['category_title'];

                        echo "<option value='$category_id'>$category_title</option>";
                    };

                
                ?>
            </select>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_brand" class="form-label">Product Brand</label>
            <select name="product_brand" class="form-select" value="">
                <option value="<?php echo $brand_title ?>"><?php echo $brand_title ?></option>
                <?php
                    $select_all_brands="SELECT * FROM `brands`";
                    $result_select_all_brands=mysqli_query($con,$select_all_brands);

                    while($row_fetch_all_brands=mysqli_fetch_array($result_select_all_brands)){
                        $brand_id=$row_fetch_all_brands['brand_id'];
                        $brand_title=$row_fetch_all_brands['brand_title'];

                        echo "<option value='$brand_id'>$brand_title</option>";
                    };
                ?>
            </select>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image1" class="form-label">Product Image I</label>
            <div class="d-flex form-control w-90">
                <input type="file" class="form-control" id="product_image1" name="product_image[]" required="required">
                <img class="admin_image" src="products_images/<?php echo $product_image1?>" alt="">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image2" class="form-label">Product Image II</label>
            <div class="d-flex form-control w-90">
                <input type="file" class="form-control" id="product_image2" name="product_image[]" required="required">
                <img class="admin_image" src="products_images/<?php echo $product_image2?>" alt="">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_image3" class="form-label">Product Image III</label>
            <div class="d-flex form-control w-90">
                <input type="file" class="form-control" id="product_image3" name="product_image[]" required="required">
                <img class="admin_image" src="products_images/<?php echo $product_image3?>" alt="">
            </div>
        </div>
        <div class="form-outline w-50 m-auto mb-4">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="text" class="form-control" id="product_price" name="product_price" required="required" value="<?php echo $product_price ?>">
        </div>
        <div class="form-outline w-50 m-auto mb-4 text-center">
            <input type="submit" value="Update Product" class="btn btn-info py-2 px-3 border-0" name="product_update">
        </div>
    </form>
</div>


<!-- Editing products -->
<?php
if(isset($_POST['product_update'])){
    $update_id=$product_id;
    /* $product_title=$_POST['product_title']; */
    $product_title=filter_input(INPUT_POST,'product_title',FILTER_SANITIZE_SPECIAL_CHARS);
    /* $product_description=$_POST['product_description']; */
    $product_description=filter_input(INPUT_POST,'product_description',FILTER_SANITIZE_SPECIAL_CHARS);
    /* $product_keywords=$_POST['product_keywords']; */
    $product_keywords=filter_input(INPUT_POST,'product_keywords',FILTER_SANITIZE_SPECIAL_CHARS);
    
        // search the category id
        $product_category=$_POST['product_category'];
        $select_product_category="SELECT * FROM `categories` WHERE category_title='$product_category'";
        $result_select_product_category=mysqli_query($con,$select_product_category);
        $row_fetch_category_update=mysqli_fetch_array($result_select_product_category);
        $category_id_update=$row_fetch_category_update['category_id'];

        // search the brand id
        $product_brand=$_POST['product_brand'];
        $select_product_brand="SELECT * FROM `brands` WHERE brand_title='$product_brand'";
        $result_select_product_brand=mysqli_query($con,$select_product_brand);
        $row_fetch_brand_update=mysqli_fetch_array($result_select_product_brand);
        $brand_id_update=$row_fetch_brand_update['brand_id'];

        $product_price=$_POST['product_price'];
        $product_price=filter_input(INPUT_POST,'product_price',FILTER_SANITIZE_SPECIAL_CHARS);

         // image
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
             
     

        

         
    


    // checking to fields empty or not
    if(
        $product_title=='' OR
        $product_description=='' OR
        $product_keywords=='' OR
        $product_category=='' OR
        $product_brand=='' OR
        $product_price==''
    ){
        echo "<script>alert('Please fill all the fields and continue the process')</script>";
    }else if(in_array($extension, $allowedFormats)){

        // Upload and compress images
        $compressedImagePaths = array();

        foreach($_FILES['product_image']['tmp_name'] as $key => $image){
            $compressedImagePath = $_FILES['product_image']['name'][$key];
            // Compress the image manually (adjust compression quality as needed)
            compressImage($image, "./products_images/" . $_FILES['product_image']['name'][$key], 70);

            $compressedImagePaths[] = $compressedImagePath;
        }

        // update query
        $update_data="UPDATE `products` SET product_title='$product_title',product_description='$product_description',product_keywords='$product_keywords',category_id=$category_id_update,brand_id=$brand_id_update,product_image1='".$compressedImagePaths[0]."',product_image2='".$compressedImagePaths[1]."',product_image3='".$compressedImagePaths[2]."',product_price='$product_price',date=NOW() WHERE product_id=$update_id";
        $result_update_data=mysqli_query($con,$update_data);

        if($result_update_data){
            echo "<script>alert('Product updated successfully')</script>";
            echo "<script>window.open('index.php?view_products','_self')</script>";
        }

    }else{
        echo "<script>alert('Invalid format!')</script>";
        echo "<script>window.open('index.php?edit_products=$product_id','_self')</script>";
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