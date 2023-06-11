<?php
include('includes/connect.php');

if(isset($_GET['delete_cart_product'])){
    $product_id=$_GET['delete_cart_product'];

    $select_delete="DELETE FROM `cart_details` WHERE product_id=$product_id";
    $result_select_delete=mysqli_query($con,$select_delete);

    if($result_select_delete){
        echo "<script>alert('Product deleted successfully')</script>";
        echo "<script>window.open('cart.php','_self')</script>";
} 
}



?>