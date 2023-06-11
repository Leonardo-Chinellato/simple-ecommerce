<!-- connect file -->
<?php
include('includes/connect.php');
include('functions/common_function.php');
@session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce website - Cart details</title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the cache problem -->

</head>

<body>

    <!-- navbar -->
    <div class="container-fluid p-0">
        <!-- first child --> <!-- second child -->
        <?php include("./includes/header.php"); ?>


        <!-- calling cart function -->
        <?php cart(); ?>


        <!-- third child -->
        <div class="bg-light">
            <h3 class="text-center">Hidden Store</h3>
            <p class="text-center">Communications is at the heart of e-commerce and community</p>
        </div>


        <!-- fourth child-table -->
        <div class="container">
            
                        <?php
                            $get_ip_add=getIPAddress();

                            $select_cart="SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
                            $result_select_cart=mysqli_query($con,$select_cart);
                            $cart_num_rows=mysqli_num_rows($result_select_cart);

                            if($cart_num_rows==0){
                                echo "<h2 class='text-center text-danger my-3'>Cart is empty</h2>";
                                echo "<form method='post'>
                                        <div class='d-flex mb-5'>
                                            <button class='bg-info btn float-right text-light' type='button'><a class='text-decoration-none text-light' href='display_all_products.php'>Continue Shopping</a></button>
                                        </div>
                                    </form>";
                            } else{
                                
                        ?>
                                <form action="" method="post">
                                    <div class="row">
                                        <table class="table table-bordered text-center">
                                            <thead class="text-center bg-info">
                                                <tr>
                                                    <!-- <th>Product ID</th> -->
                                                    <th>Product Title</th>
                                                    <th>Product Brand</th>
                                                    <th>Image</th>
                                                    <th>Unit Price</th>
                                                    <th>Quantities</th>
                                                    <th>Total Price</th>
                                                    
                                                    <th>Delete</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-center">
                                                <?php
                                                    while($cart_array=mysqli_fetch_array($result_select_cart)){
                                                        $product_id=$cart_array['product_id'];
                                                        $quantity=$cart_array['quantity'];
                    
                                                        $select_products="SELECT * FROM `products` WHERE product_id=$product_id";
                                                        $result_select_products=mysqli_query($con,$select_products);

                                                        while($product_array=mysqli_fetch_array($result_select_products)){
                                                            $product_id=$product_array['product_id'];
                                                            $product_title=$product_array['product_title'];
                                                            $product_description=$product_array['product_description'];
                                                            $product_keywords=$product_array['product_keywords'];
                                                            $brand_id=$product_array['brand_id'];
                                                                $select_brand="SELECT * FROM `brands` WHERE brand_id=$brand_id";
                                                                $result_select_brand=mysqli_query($con,$select_brand);
                                                                $brand_array=mysqli_fetch_array($result_select_brand);
                                                                $brand_id=$brand_array['brand_id'];
                                                                $brand_title=$brand_array['brand_title'];

                                                            $product_image1=$product_array['product_image1'];
                                                            $product_price=$product_array['product_price'];
                                                        }
                                                            

                                                ?>
                                                <tr>
                                                    <!-- <td><?php echo $product_id?></td> -->
                                                    <td><?php echo $product_title?></td>
                                                    <td><?php echo $brand_title?></td>
                                                    <td><img class="cart_img" src="./admin_area/products_images/<?php echo $product_image1?>" alt=""></td>
                                                    <td><?php
                                                        $formattedNumberPP = number_format($product_price, 2, '.', ',');
                                                        $formattedCurrencyPP = 'U$ ' . $formattedNumberPP;
                                                        echo $formattedCurrencyPP;
                                                        
                                                        ?>
                                                    </td>
                                                    <td><input class="text-center form-control w-25 m-auto" type="number" id="product_quantity" name="quantity" required="required" value="<?php echo $quantity ?>"></td>
                                                    <td><?php    
                                                                $value = $product_price*$quantity;
                                                                $formattedNumber = number_format($value, 2, '.', ',');
                                                                $formattedCurrency = 'U$ ' . $formattedNumber;
                                                                echo $formattedCurrency;
                                                        ?>
                                                    </td>
                                                    <td><a href="delete_cart_item.php?delete_cart_product=<?php echo $product_id ?>" type="button" class="text-danger" data-bs-toggle="modal" data-bs-target="#exampleModalProducts-<?php echo $product_id ?>"><i class="fa-solid fa-trash"></i></a></td>
                                                </tr>
                                                <?php                                                                                                                                                                         
                                                   } // end of whiles
                                                ?>
                                            </tbody>
                                        </table>


                                        <!-- subtotal -->
                                        <div class="d-flex mb-5">
                                            <div class="d-flex mb-5">
                                                <h4 class="px-3">Subtotal: <strong class="text-info"><?php total_cart_price() ?> </strong></h4>  
                                                <button class="bg-secondary px-3 py-2 border-0 mx-3"><a class="text-light text-decoration-none" href="display_all_products.php">Continue Shopping</a></button>
                                                <button class="bg-info px-3 py-2 border-0 mx-3"><a class="text-light text-decoration-none" href="users_area/checkout.php">Checkout</a></button>
                                                <input type="submit" value="Update Cart" class="bg-info px-3 py-2 border-0 mx-3" name="update_cart_submit">
                                            </div>                                              
                                        </div>

                                        <?php
                                            
                                        
                                        ?>


                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalProducts-<?php echo $product_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h4>Are you sure you want to delete this?</h4>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><a href="cart.php" class="text-light text-decoration-none">No</a></button>
                                                <button type="button" class="btn btn-primary"><a href="cart.php?delete_cart_product=<?php echo $product_id ?>" class="text-light text-decoration-none">Yes</a></button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                        
                                    </div>
                                </form>


                        <?php
                                
                            } // end of else
                        ?>
                    
        </div>
                    
                            
                               


        <!-- last child -->
            <!-- include footer -->
            <?php include("./includes/footer.php"); ?> 
        

    </div>



    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>

