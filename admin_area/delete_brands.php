<?php
if(isset($_GET['delete_brands'])){
    $brand_id_delete=$_GET['delete_brands'];

    $delete_brand_query="DELETE FROM `brands` WHERE brand_id=$brand_id_delete";
    $result_delete_brand_query=mysqli_query($con,$delete_brand_query);

    if($result_delete_brand_query){
        echo "<script>alert('Brand deleted successfully')</script>";
        echo "<script>window.open('index.php?view_brands','_self')</script>";
    }
}