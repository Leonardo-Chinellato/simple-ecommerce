<?php
if(isset($_GET['edit_brands'])){
    $brand_id=$_GET['edit_brands'];

    $select_brand="SELECT * FROM `brands` WHERE brand_id=$brand_id";
    $result_select_brand=mysqli_query($con,$select_brand);   
}
?>


<div class="container">
    <h1 class="my-5 text-center">Edit Brand</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4 text-center">
            <?php
                while($row_data_brands=mysqli_fetch_array($result_select_brand)){
                    $brand_title=$row_data_brands['brand_title'];
            ?>
                <label class="form-label" for="brand_title">Category Title</label>
                <input class="form-control" id="brand_title" type="text" required="required" name="brand_title" value="<?php echo $brand_title ?>">
            <?php
                }
            ?>
        </div>
        <div class="form-outline w-50 m-auto mb-4 text-center">
            <input type="submit" value="Update Brand Title" class="btn btn-info py-2 px-3 border-0" name="brand_title_update">
        </div>
    </form>
</div>

<?php
// Update brand title
if(isset($_POST['brand_title_update'])){
    $brand_id_edit=$brand_id;
    /* $brand_title_edit=$_POST['brand_title']; */
    $brand_title_edit=filter_input(INPUT_POST,'brand_title',FILTER_SANITIZE_SPECIAL_CHARS);

    if($brand_title_edit==''){
        echo "<script>alert('Please fill all the fields and continue the process')</script>";
    }else{
        // Update query
        $update_query="UPDATE `brands` SET brand_title='$brand_title_edit' WHERE brand_id=$brand_id_edit";
        $result_update_query=mysqli_query($con,$update_query);

        echo "<script>alert('Brand updated successfully')</script>";
        echo "<script>window.open('index.php?view_brands','_self')</script>";
    }
}
?>