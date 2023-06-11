<?php
if(isset($_GET['edit_categories'])){
    $category_id=$_GET['edit_categories'];

    $select_categories="SELECT * FROM `categories` WHERE category_id=$category_id";
    $result_select_categories=mysqli_query($con,$select_categories);    
}
?>

<div class="container">
    <h1 class="text-center my-5">Edit Category</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-outline w-50 m-auto mb-4 text-center">
        <?php    
            while($row_data_categories=mysqli_fetch_array($result_select_categories)){
                $category_id=$row_data_categories['category_id'];
                $category_title=$row_data_categories['category_title'];
        ?>
                <label class="form-label" for="category_title">Category Title</label>
                <input class="form-control" id="category_title" type="text" required="required" name="category_title" value="<?php echo $category_title ?>">
        <?php
            }
        ?>
        </div>
        <div class="form-outline w-50 m-auto mb-4 text-center">
            <input type="submit" value="Update Category Title" class="btn btn-info py-2 px-3 border-0" name="category_title_update">
        </div>
    </form>
</div>

<?php
// update the category title
if(isset($_POST['category_title_update'])){
    $category_edit_id=$category_id;
    /* $category_edit_title=$_POST['category_title']; */
    $category_edit_title=filter_input(INPUT_POST,'category_title',FILTER_SANITIZE_SPECIAL_CHARS);

    if($category_edit_title==''){
        echo "<script>alert('Please fill all the fields and continue the process')</script>";
    }else{
        // update query
        $update_data="UPDATE `categories` SET category_title='$category_edit_title' WHERE category_id=$category_edit_id";
        $result_update_data=mysqli_query($con,$update_data);

        if($result_update_data){
            echo "<script>alert('Category updated successfully')</script>";
            echo "<script>window.open('index.php?view_categories','_self')</script>";
        }
    }
    
}

?>