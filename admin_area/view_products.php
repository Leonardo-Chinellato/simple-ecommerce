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
            btn.setAttribute("href", "index.php?delete_products=" + id);
        }
    </script>

</head>
<body>
    <h3 class="text-center text-success">All Products</h3>
    <div class="button">
        <button class="mt-1">
            <a href="index.php?insert_products" class="nav-link text-light bg-info p-2">Insert Products</a>
        </button>
    </div>
    <table class="table table-bordered mt-5">
        <thead class="bg-info text-center">
            <tr>
                <th>Product ID</th>
                <th>Product Title</th>
                <th>Product Brand</th>
                <th>Product Image</th>
                <th>Product Price</th>
                <th>Total Sold</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="bg-secondary text-light text-center">
            <?php
                $select_products_view_products="SELECT * FROM `products` ORDER BY product_title";
                $result_select_products_view_products=mysqli_query($con,$select_products_view_products);

                // pagination

            $limit=6; // variable to store the number of rows per page

            if(!isset($_GET['page'])){  

                $page_number=1;  
    
            }else{  
    
                $page_number=$_GET['page'];  
    
            }

            $initial_page=($page_number-1)*$limit;  // get the initial page number

            $total_rows=mysqli_num_rows($result_select_products_view_products);

            $total_pages=ceil($total_rows/$limit); // get the required number of pages

            // Prev + Next
            $prev = $page_number - 1;
            $next = $page_number + 1;

            $initial_page=($page_number-1)*$limit; // get the initial page number

            $getQuery = "SELECT * FROM products ORDER BY product_title LIMIT " . $initial_page . ',' . $limit;

            $result=mysqli_query($con,$getQuery);
                
                while($row_data=mysqli_fetch_assoc($result)){
                    $product_id=$row_data['product_id'];
                    $brand_id=$row_data['brand_id'];
                    $product_title=$row_data['product_title'];
                    $product_image1=$row_data['product_image1'];
                    $product_price=$row_data['product_price'];
                    $status=$row_data['status'];

                    $select_total_sold="SELECT * FROM `orders_pending` WHERE product_id=$product_id";
                    $result_select_total_sold=mysqli_query($con,$select_total_sold);
                    $num_rows=mysqli_num_rows($result_select_total_sold);

                    $select_brand_title="SELECT * FROM `brands` WHERE brand_id=$brand_id";
                    $result_select_brand_title=mysqli_query($con,$select_brand_title);
                    while($row_data=mysqli_fetch_array($result_select_brand_title)){
                        $brand_title=$row_data['brand_title'];
                    }

                    
                

            ?>
                    <tr>
                        <td><?php echo $product_id?></td>
                        <td><?php echo $product_title?></td>
                        <td><?php echo $brand_title ?></td>
                        <td><img class="admin_image" src="products_images/<?php echo $product_image1?>"></img></td>
                        <td><?php echo $product_price?></td>                    
                        <td><?php echo $num_rows?></td>
                    
                        <?php
                            if($status==true){
                                echo "<td>In Stock</td>";
                            }else{
                                echo "<td>Out of Stock</td>";
                            }
                        ?>                      
                    
                        <td><a href="index.php?edit_products=<?php echo $product_id ?>" class="text-light"><i class="fa-solid fa-pen-to-square"></i></a></td>
                        <!-- <td><a href="index.php?delete_products=<?php echo $product_id ?>" type="button" class="text-light" data-bs-toggle="modal" data-bs-target="#exampleModal=<?php echo $product_id ?>"><i class="fa-solid fa-trash"></i></a></td> -->
                        <td><a href="javascript:void(0);" type="button" class="text-light" data-bs-toggle="modal" onclick="deleteProduct(<?php echo $product_id; ?>)" data-bs-target="#exampleModalProducts"><i class="fa-solid fa-trash"></i></a></td>
                    </tr>
            <?php
            
            } /* this (while) is necessery for the dynamic table */
            
            // Pagination from bootstrap
        if($total_rows!==0){
            ?>            
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if($page_number <= 1){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($page_number <= 1){ echo '#'; } else { echo "?view_products&page=" . $prev; } ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php for($i = 1; $i <= $total_pages; $i++ ): ?>
                        <li class="page-item <?php if($page_number == $i) {echo 'active'; } ?>">
                            <a class="page-link" href="index.php?view_products&page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php if($page_number >= $total_pages) { echo 'disabled'; }?>">
                            <a class="page-link" href="<?php if($page_number >= $total_pages){ echo '#'; } else {echo "?view_products&page=". $next; } ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            <?php
            }
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
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><a href="index.php?view_products" class="text-light text-decoration-none">No</a></button>
                                                <button type="button" class="btn btn-primary"><a href="" id="btn-delete-confirm" class="text-light text-decoration-none">Yes</a></button>
                                            </div>
                                            </div>
                                        </div>
                                        </div>

                                        <!--cart.php?delete_cart_product=<?php echo $product_id ?> -->
                                        
                                    </div>

</body>
</html>