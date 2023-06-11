<?php
if(isset($_GET['delete_categories'])){
    $category_id=$_GET['delete_categories'];

    $delete_query="DELETE FROM `categories` WHERE category_id=$category_id";
    $result_delete_query=mysqli_query($con,$delete_query);

    if($result_delete_query){
        echo "<script>alert('Category deleted successfully')</script>";
        echo "<script>window.open('index.php?view_categories','_self')</script>";
    }
}
?>