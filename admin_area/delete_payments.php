<?php
if(isset($_GET['delete_payments'])){
    $payment_id_delete=$_GET['delete_payments'];

    echo $payment_id_delete;

    $delete_query="DELETE FROM `user_payments` WHERE payment_id=$payment_id_delete";
    $result_delete_query=mysqli_query($con,$delete_query);

    if($result_delete_query){
        echo "<script>alert('Payment deleted successfully')</script>";
        echo "<script>window.open('index.php?list_payments','_self')</script>";
    }
}