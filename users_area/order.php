<?php
/*  connect file  */
    include('../functions/common_function.php');
    include('../includes/connect.php');

if(isset($_GET['user_id'])){ // it comes from "payment.php", in achor tag <a href="order.php?user_id=PHP echo $user_id PHP"><h2 class="text-center">Pay offline</h2></a>
    $user_id=$_GET['user_id'];
}


// getting total items and total price of all items

$get_ip_address=getIPAddress();
$total_price=0;
$cart_query_price="SELECT * FROM `cart_details` WHERE ip_address='$get_ip_address'";
$result_cart_query_price=mysqli_query($con,$cart_query_price);

$invoice_number=mt_rand();

$status='pending';

$count_products=mysqli_num_rows($result_cart_query_price);

while($row_price=mysqli_fetch_array($result_cart_query_price)){
    $product_id=$row_price['product_id'];
    $select_products="SELECT * FROM `products` WHERE product_id=$product_id";
    $result_select_products=mysqli_query($con,$select_products);

    while($row_product_price=mysqli_fetch_array($result_select_products)){
        $product_price=array($row_product_price['product_price']);
        $product_values=array_sum($product_price);
        $total_price+=$product_values;
    }
}


// getting quantity from cart

    $get_ip_add = getIPAddress();
    $total_price=0;
    $cart_query="SELECT * FROM cart_details WHERE ip_address='$get_ip_add'";
    $result=mysqli_query($con,$cart_query);

    while($row=mysqli_fetch_array($result)){
        $product_id=$row['product_id'];
        $quantity=$row['quantity'];
        $select_products="SELECT * FROM `products` WHERE product_id='$product_id'";
        $result_products=mysqli_query($con,$select_products);

        while($row_product_price=mysqli_fetch_array($result_products)){
            $product_price_per_product=$row_product_price['product_price'];
            $product_total_price=array($product_price_per_product*$quantity);
            $product_values=array_sum($product_total_price);
            $total_price+=$product_values;
        }

    }

$insert_orders="INSERT INTO `user_orders` (user_id,amont_due,invoice_number,total_products,order_date,order_status) VALUES ($user_id,$total_price,$invoice_number,$count_products,NOW(),'$status')";
$result_query=mysqli_query($con,$insert_orders);
if($result_query){
    echo "<script>alert('Orders are submitted successfully')</script>";
    echo "<script>window.open('profile.php','_self')</script>";
}


// orders pending
$insert_pending_orders="INSERT INTO `orders_pending` (user_id,invoice_number,product_id,quantity,order_status) VALUES ($user_id,$invoice_number,$product_id,$quantity,'$status')";
$result_insert_pending_orders=mysqli_query($con,$insert_pending_orders);


// delete items from cart
$empty_cart="DELETE FROM `cart_details` WHERE ip_address='$get_ip_address'";
$result_empty_cart=mysqli_query($con,$empty_cart);


