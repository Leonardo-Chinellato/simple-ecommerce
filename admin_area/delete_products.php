<?php
if(isset($_GET['delete_products'])){
    $product_id=$_GET['delete_products'];

    $select_delete="DELETE FROM `products` where product_id=$product_id";
    $result_select_delete=mysqli_query($con,$select_delete);

    if($result_select_delete){
        echo "<script>alert('Product deleted successfully')</script>";
        echo "<script>window.open('index.php?view_products','_self')</script>";
}
}