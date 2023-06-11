<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!-- css file -->
     <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the chache problem -->

     <script>
        function deleteProduct(id){
            btn = document.getElementById('btn-delete-confirm');
            btn.setAttribute("href", "index.php?delete_orders=" + id);
        }
    </script>

</head>
<body>
<div class="container">
    <h3 class="text-center text-success">All Orders</h3>
    <table class="table table-bordered mt-5">
        <thead class="bg-info text-center">
            <tr>
                <th>Order ID</th>
                <th>Due Amont</th>
                <th>Invoice Number</th>
                <th>Total Products</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-light text-center">
            
                <?php
                    $orders_select="SELECT * FROM `user_orders`";
                    $result_orders_select=mysqli_query($con,$orders_select);

                    $row_count=mysqli_num_rows($result_orders_select);

                    if($row_count==0){
                        echo "<h5 class='text-center text-danger mt-5'>No orders</h5>";
                    }else{



                    while($result_orders_select_array=mysqli_fetch_array($result_orders_select)){
                        $order_id=$result_orders_select_array['order_id'];
                        $user_id=$result_orders_select_array['user_id'];
                        $amont_due=$result_orders_select_array['amont_due'];
                        $invoice_number=$result_orders_select_array['invoice_number'];
                        $total_products=$result_orders_select_array['total_products'];
                        $order_date=$result_orders_select_array['order_date'];
                        $order_status=$result_orders_select_array['order_status'];

                        $formattedNumber = number_format($amont_due, 2, '.', ',');
                        $formattedCurrency = 'U$ ' . $formattedNumber;

                        $formattedDate = date('m/d/Y', strtotime($order_date));

                    ?>

            <tr>
                <td><?php echo $order_id ?></td>
                <td><?php echo $formattedCurrency ?></td>
                <td><?php echo $invoice_number ?></td>
                <td><?php echo $total_products ?></td>
                <td><?php echo $formattedDate ?></td>
                <td><?php echo $order_status ?></td>
                <!-- <td><a href="index.php?delete_orders=<?php echo $order_id ?>" type="button" class="text-light" data-bs-toggle="modal" data-bs-target="#exampleModalOrders"><i class="fa-solid fa-trash"></i></a></td> -->
                <td><a href="javascript:void(0);" type="button" class="text-light" data-bs-toggle="modal" onclick="deleteProduct(<?php echo $order_id; ?>)" data-bs-target="#exampleModalProducts"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
                    <?php
                        }}
                    ?>
            
        </tbody>
    </table>

<!-- Modal -->
<div class="modal fade" id="exampleModalProducts" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4>Are you sure you want to delete this?</h4>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><a href="index.php?list_orders" class="text-light text-decoration-none">No</a></button>
            <button type="button" class="btn btn-primary"><a href="" id="btn-delete-confirm" class="text-light text-decoration-none">Yes</a></button>
        </div>
        </div>
    </div>
    </div>

    <!--cart.php?delete_cart_product=<?php echo $brand_id ?> -->
                                        
</div>

</div>
</body>