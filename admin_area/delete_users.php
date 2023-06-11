<?php
if(isset($_GET['delete_users'])){
    $user_id=$_GET['delete_users'];

    $delete_user_query="DELETE FROM `user_table` WHERE user_id=$user_id";
    $result_delete_user_query=mysqli_query($con,$delete_user_query);

    if($result_delete_user_query){
        echo "<script>alert('User deleted successfully')</script>";
        echo "<script>window.open('index.php?list_users','_self')</script>";
    }
}