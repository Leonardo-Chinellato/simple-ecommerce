<?php
if(isset($_GET['delete_orders'])){
    $order_id_delete=$_GET['delete_orders'];

    $delete_query="DELETE FROM `user_orders` WHERE order_id=$order_id_delete";
    $result_delete_query=mysqli_query($con,$delete_query);

    if($result_delete_query){
        echo "<script>alert('Order deleted successfully')</script>";
        echo "<script>window.open('index.php?list_orders','_self')</script>";
    }
}