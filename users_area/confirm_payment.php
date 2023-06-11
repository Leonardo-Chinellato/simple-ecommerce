<?php
    include('../includes/connect.php');
    @session_start();

    // Verification
    if(!isset($_SESSION['username'])){
        header('location:user_login.php');
    }

    // Data
    $username=$_SESSION['username'];
    $sql="SELECT * FROM `user_table` WHERE username='$username'";
    $result = mysqli_query($con,$sql);


    if(isset($_GET['order_id'])){// comes from user_orders.php
        $order_id=$_GET['order_id'];

        $select_data="SELECT * FROM `user_orders` WHERE order_id=$order_id";
        $result_select_data=mysqli_query($con,$select_data);
        $row_fetch=mysqli_fetch_assoc($result_select_data);
        $invoice_number=$row_fetch['invoice_number'];
        $amont_due=$row_fetch['amont_due'];

        $formattedNumber = number_format($amont_due, 2, '.', ',');
        $formattedCurrency = 'U$ ' . $formattedNumber;
    }

    if(isset($_POST['confirm_payment'])){// comes from form
        $invoice_number=$_POST['invoice_number'];
        $amount=$_POST['amount'];
        $payment_mode=$_POST['payment_mode'];

        $insert_query="INSERT INTO `user_payments` (order_id,invoice_number,amount,payment_mode) VALUES ($order_id,$invoice_number,'$amount','$payment_mode')";
        $result_insert_query=mysqli_query($con,$insert_query);

        if($result_insert_query){
            echo "<h3 class='text-center text-light'> Successfully completed the payment</h3>";
            echo "<script>window.open('profile.php?my_orders','_self')</script>";
        }

        $update_orders="UPDATE `user_orders` set order_status='Complete' WHERE order_id=$order_id";
        $result_update_orders=mysqli_query($con,$update_orders);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the cache problem -->

</head>
<body class="bg-secondary">
    <div class="container my-5">
        <h1 class="text-center text-light">Confirm Payment</h1>
        <form action="" method="post">
            <div class="form-outline my-4 text-center w-50 m-auto">
                <input type="text" name="invoice_number" id="" class="form-control w-50 m-auto" value="<?php echo $invoice_number?>">
            </div>
            <div class="form-outline my-4 text-center w-50 m-auto">
                <label for="" class="text-light">Amont</label>
                <input type="text" name="amount" id="" class="form-control w-50 m-auto" value="<?php echo $formattedCurrency?>">
            </div>
            <div class="form-outline my-4 text-center w-50 m-auto">
                <select name="payment_mode" id="" class="form-select w-50 m-auto">
                    <option>Select Payment Mode</option>
                    <option>UPI</option>
                    <option>Netbanking</option>
                    <option>Paypal</option>
                    <option>Cash on Delivery</option>
                    <option>Pay offline</option>
                </select>
            </div>
            <div class="form-outline my-4 text-center w-50 m-auto">
                <input type="submit" value="Confirm" class="bg-info py-2 px-3 border-0" name="confirm_payment">
            </div>
        </form>
    </div>

    
</body>
</html>