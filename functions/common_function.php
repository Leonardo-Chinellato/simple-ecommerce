<?php

// including connect file
/* include('./includes/connect.php'); */ // commented becouse it was making problem on the user_registration.php


// getting products (fetching products index)
function get_products(){

    global $con;

    // condition to check if category or brand is seted
    if(!isset($_GET['category'])):
        if(!isset($_GET['brand'])):
            $select_query="SELECT * FROM products ORDER BY rand() LIMIT 0,6"; /* order by product_title */
            $result_query=mysqli_query($con,$select_query);
            /* $row=mysqli_fetch_assoc($result_query); */ /* if it is here, there wiil be noend results of cars. must be inside the while */

            while($row=mysqli_fetch_assoc($result_query)):
                $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_description=$row['product_description'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];

                include ("includes/card.php");
            endwhile;
        endif;
    endif;
}


// getting all products
function get_all_products(){

    global $con;

    // condition to check if category or brand is seted
    if(!isset($_GET['category'])){
        if(!isset($_GET['brand'])){
            $select_query="SELECT * FROM products ORDER BY product_title"; /* order by product_title */
            $result_query=mysqli_query($con,$select_query);
            

                // pagination

                $limit=6; // variable to store the number of rows per page

                if(!isset($_GET['page'])){  

                    $page_number=1;  
        
                }else{  
        
                    $page_number=$_GET['page'];  
        
                }

                $initial_page=($page_number-1)*$limit;  // get the initial page number

                $total_rows=mysqli_num_rows($result_query);

                $total_pages=ceil($total_rows/$limit); // get the required number of pages

                // Prev + Next
                $prev = $page_number - 1;
                $next = $page_number + 1;

                $initial_page=($page_number-1)*$limit; // get the initial page number

                $getQuery = "SELECT * FROM products ORDER BY product_title LIMIT " . $initial_page . ',' . $limit;

                $result=mysqli_query($con,$getQuery); 


            while($row=mysqli_fetch_assoc($result)){
                $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_description=$row['product_description'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];

                include ("includes/card.php");
            }
            

            // Pagination from bootstrap
            ?>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if($page_number <= 1){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($page_number <= 1){ echo '#'; } else { echo "?page=" . $prev; } ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php for($i = 1; $i <= $total_pages; $i++ ): ?>
                        <li class="page-item <?php if($page_number == $i) {echo 'active'; } ?>">
                            <a class="page-link" href="display_all_products.php?page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php if($page_number >= $total_pages) { echo 'disabled'; }?>">
                            <a class="page-link" href="<?php if($page_number >= $total_pages){ echo '#'; } else {echo "?page=". $next; } ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            <?php
        };
    };
}


// getting unique brands
function get_unique_brand(){
    global $con;

    // condition to check if is setted
    if(isset($_GET['brand'])){
        $brand_id=$_GET['brand'];
        $select_query="SELECT * FROM products WHERE brand_id=$brand_id ORDER BY product_title";
        $result_query=mysqli_query($con,$select_query);


            // message when no products for this brand
            $num_of_rows=mysqli_num_rows($result_query);
            if($num_of_rows==0){
                $brand_id=$_GET['brand'];
                $select_query="SELECT * FROM brands WHERE $brand_id=brand_id";
                $result_query=mysqli_query($con,$select_query);
                $row_data=mysqli_fetch_assoc($result_query);
                    $brand_title=$row_data['brand_title'];

                    echo "<h2 class='text-center text-danger'>Sorry, but we have no stock for $brand_title brand</h2>";
            };

            // pagination

            $limit=6; // variable to store the number of rows per page

            if(!isset($_GET['page'])){  

                $page_number=1;  
    
            }else{  
    
                $page_number=$_GET['page'];  
    
            }

            $initial_page=($page_number-1)*$limit;  // get the initial page number

            $total_rows=mysqli_num_rows($result_query);

            $total_pages=ceil($total_rows/$limit); // get the required number of pages

            // Prev + Next
            $prev = $page_number - 1;
            $next = $page_number + 1;

            $initial_page=($page_number-1)*$limit; // get the initial page number

            $getQuery = "SELECT * FROM products WHERE brand_id=$brand_id ORDER BY product_title LIMIT " . $initial_page . ',' . $limit;

            $result=mysqli_query($con,$getQuery);

        while($row=mysqli_fetch_assoc($result)){ /* this $row must be inside the while */
                $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_description=$row['product_description'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];

                include ("includes/card.php");
        };

            // Pagination from bootstrap
            if($total_rows!==0){
            ?>            
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if($page_number <= 1){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($page_number <= 1){ echo '#'; } else { echo "?brand=$brand_id&page=" . $prev; } ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php for($i = 1; $i <= $total_pages; $i++ ): ?>
                        <li class="page-item <?php if($page_number == $i) {echo 'active'; } ?>">
                            <a class="page-link" href="index.php?brand=<?=$brand_id?>&page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php if($page_number >= $total_pages) { echo 'disabled'; }?>">
                            <a class="page-link" href="<?php if($page_number >= $total_pages){ echo '#'; } else {echo "?brand=$brand_id&page=". $next; } ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            <?php
            }


    };        
}


// getting unique categories
function get_unique_category(){
    global $con;

    // condition to check if is setted
    if(isset($_GET['category'])){
        $category_id=$_GET['category'];
        $select_query="SELECT * FROM products WHERE category_id=$category_id ORDER BY product_title";
        $result_query=mysqli_query($con,$select_query);

            // message when no products for this category 
            $num_of_rows=mysqli_num_rows($result_query);
            if($num_of_rows==0){
                $category_id=$_GET['category'];
                $select_query="SELECT * FROM categories WHERE $category_id=category_id";
                $result_query=mysqli_query($con,$select_query);
                $row_data=mysqli_fetch_assoc($result_query);
                    $category_title=$row_data['category_title'];

                    echo "<h2 class='text-center text-danger'>Sorry, but we have no stock for $category_title category</h2>";

            }


            // pagination

            $limit=6; // variable to store the number of rows per page

            if(!isset($_GET['page'])){  

                $page_number=1;  
    
            }else{  
    
                $page_number=$_GET['page'];  
    
            }

            $initial_page=($page_number-1)*$limit;  // get the initial page number

            $total_rows=mysqli_num_rows($result_query);

            $total_pages=ceil($total_rows/$limit); // get the required number of pages

            // Prev + Next
            $prev = $page_number - 1;
            $next = $page_number + 1;

            $initial_page=($page_number-1)*$limit; // get the initial page number

            $getQuery = "SELECT * FROM products WHERE category_id=$category_id ORDER BY product_title LIMIT " . $initial_page . ',' . $limit;

            $result=mysqli_query($con,$getQuery);

        while($row=mysqli_fetch_assoc($result)){ /* this $row must be inside the while */
                $product_id=$row['product_id'];
                $product_title=$row['product_title'];
                $product_description=$row['product_description'];
                $product_image1=$row['product_image1'];
                $product_price=$row['product_price'];
                $category_id=$row['category_id'];
                $brand_id=$row['brand_id'];

                include ("includes/card.php");
        }

        // Pagination from bootstrap
        if($total_rows!==0){
            ?>            
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if($page_number <= 1){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($page_number <= 1){ echo '#'; } else { echo "?category=$category_id&page=" . $prev; } ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php for($i = 1; $i <= $total_pages; $i++ ): ?>
                        <li class="page-item <?php if($page_number == $i) {echo 'active'; } ?>">
                            <a class="page-link" href="index.php?category=<?=$category_id?>&page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php if($page_number >= $total_pages) { echo 'disabled'; }?>">
                            <a class="page-link" href="<?php if($page_number >= $total_pages){ echo '#'; } else {echo "?category=$category_id&page=". $next; } ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            <?php
            }
        }
}


// getting search products
function get_search_products(){

        global $con;

            if(isset($_GET['search_data_product'])) {
                
                $search_data_value=filter_input(INPUT_GET,'search_data',FILTER_SANITIZE_SPECIAL_CHARS);

                if($search_data_value=='' AND !isset($_GET['page'])){
                    echo "<script>alert('Please fill the search input!')</script>";
                    echo "<script>window.open('display_all_products.php','_self')</script>";
                }else{
                $search_query="SELECT * FROM products WHERE product_keywords LIKE '%$search_data_value%' ORDER BY product_title";
                $result_query=mysqli_query($con,$search_query);
                /* $row=mysqli_fetch_assoc($result_query); */ /* if it is here, there wiil be noend results of cars. must be inside the while */
                
                $num_of_rows=mysqli_num_rows($result_query);
                    if($num_of_rows==0){
                        echo "<h2 class='text-center text-danger'>Sorry, but no results for $search_data_value</h2>";
                    }
                
            // pagination

            $limit=6; // variable to store the number of rows per page

            if(!isset($_GET['page'])){  

                $page_number=1;  
    
            }else{  
    
                $page_number=$_GET['page'];  
    
            }

            $initial_page=($page_number-1)*$limit;  // get the initial page number

            $total_rows=mysqli_num_rows($result_query);

            $total_pages=ceil($total_rows/$limit); // get the required number of pages

            // Prev + Next
            $prev = $page_number - 1;
            $next = $page_number + 1;

            $initial_page=($page_number-1)*$limit; // get the initial page number

            $getQuery = "SELECT * FROM products WHERE product_keywords LIKE '%$search_data_value%' ORDER BY product_title LIMIT " . $initial_page . ',' . $limit;

            $result=mysqli_query($con,$getQuery);

                while($row=mysqli_fetch_assoc($result)){
                    $product_id=$row['product_id'];
                    $product_title=$row['product_title'];
                    $product_description=$row['product_description'];
                    $product_image1=$row['product_image1'];
                    $product_price=$row['product_price'];
                    $category_id=$row['category_id'];
                    $brand_id=$row['brand_id'];
    
                    include ("includes/card.php");
                }

        // Pagination from bootstrap
        if($num_of_rows!==0){
            ?>            
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item <?php if($page_number <= 1){ echo 'disabled'; } ?>">
                            <a class="page-link" href="<?php if($page_number <= 1){ echo '#'; } else { echo "?search_data=$search_data_value&search_data_product=Search&page=" . $prev; } ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php for($i = 1; $i <= $total_pages; $i++ ): ?>
                        <li class="page-item <?php if($page_number == $i) {echo 'active'; } ?>">
                            <a class="page-link" href="search_product.php?search_data=<?php if(isset($_GET['search_data'])) {$search_data_value=filter_input(INPUT_GET,'search_data',FILTER_SANITIZE_SPECIAL_CHARS); echo $search_data_value;}?>&search_data_product=Search&page=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                        <?php endfor; ?>
                        
                        <li class="page-item <?php if($page_number >= $total_pages) { echo 'disabled'; }?>">
                            <a class="page-link" href="<?php if($page_number >= $total_pages){ echo '#'; } else {echo "?search_data=$search_data_value&search_data_product=Search&page=". $next; } ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>

            <?php
            }
            }
        }
}   


// displaying brands in sidenav (brands to be displayed)
function get_brands(){

    global $con;

    $select_brands="SELECT * FROM brands ORDER BY brand_title";
    $result_brands=mysqli_query($con,$select_brands);

    while($row_data=mysqli_fetch_assoc($result_brands)){
        $brand_title=$row_data['brand_title'];
        $brand_id=$row_data['brand_id'];

        echo "<li class='nav-item'>
            <a href='index.php?brand=$brand_id' class='nav-link text-light'>$brand_title</a>
            </li>";
    }
}


// displaying categories in sidenav (categories to be displayed)
function get_categories(){
    
    global $con;

    $select_categories="SELECT * FROM categories ORDER BY category_title";
    $result_categories=mysqli_query($con,$select_categories);

    while($row_data=mysqli_fetch_assoc($result_categories)):
        $category_title=$row_data['category_title'];
        $category_id=$row_data['category_id'];

        echo "<li class='nav-item'>
        <a href='index.php?category=$category_id' class='nav-link text-light'>$category_title</a>
        </li>";
    endwhile;                
}


// view details function
function view_details(){

    global $con;

    // condition to check if product, category or brand is seted
    if(isset($_GET['product_id'])){
        if(!isset($_GET['category'])):
            if(!isset($_GET['brand'])):
                $product_id=$_GET['product_id'];
                $select_query="SELECT * FROM products WHERE product_id=$product_id"; /* order by product_title */
                $result_query=mysqli_query($con,$select_query);
                /* $row=mysqli_fetch_assoc($result_query); */ /* if it is here, there wiil be noend results of cars. must be inside the while */

                while($row=mysqli_fetch_assoc($result_query)):
                    $product_id=$row['product_id'];
                    $product_title=$row['product_title'];
                    $product_description=$row['product_description'];
                    $product_image1=$row['product_image1'];
                    $product_image2=$row['product_image2'];
                    $product_image3=$row['product_image3'];
                    $product_price=$row['product_price'];
                    $category_id=$row['category_id'];
                    $brand_id=$row['brand_id'];

                    $formattedNumber = number_format($product_price, 2, '.', ',');
                    $formattedCurrency = 'U$ ' . $formattedNumber;
                    
                    // this card has a "go home" option
                    echo "
                        <div class='col-md-4 mb-2'>
                            <!-- card title from bootstrap -->
                            <div class='card'> 
                                <img class='card-img-top' src='./admin_area/products_images/$product_image1' alt='...'>
                                <div class='card-body'>
                                    <h5 class='card-title'>$product_title</h5>
                                    <p class='card-text'>$product_description</p>
                                    <p class='card-text'>$formattedCurrency</p>
                                    <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                                    <a href='display_all_products.php' class='btn btn-secondary'>Go home</a>
                                </div>
                            </div>
                        </div>

                        <div class='col-md-8'>
                            <!-- related images -->
                            <div class='row'>
                                <div class='col-md-12'>
                                    <h4 class='text-center text-info mb-5'>Related products</h4>
                                </div>
                                <div class='col-md-6'>
                                    <img class='card-img-top' src='./admin_area/products_images/$product_image2' alt='...'>
                                </div>
                                <div class='col-md-6'>
                                    <img class='card-img-top' src='./admin_area/products_images/$product_image3' alt='...'>
                                </div>
                            </div>
                        </div>
                    ";
                endwhile;
            endif;
        endif;
    }
}


// get ip adress function
function getIPAddress(){  

        //whether ip is from the share internet  
        if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                    $ip = $_SERVER['HTTP_CLIENT_IP'];  
            }  
        //whether ip is from the proxy  
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
        }  
    //whether ip is from the remote address  
        else{  
                $ip = $_SERVER['REMOTE_ADDR'];  
        }  
        return $ip;  
}  
   $ip = getIPAddress();  
    /* echo 'User Real IP Address - '.$ip; */


// cart function
function cart(){
    
    global $con;

    if(isset($_GET['add_to_cart'])){
        $get_ip_add = getIPAddress();
        $get_product_id=$_GET['add_to_cart'];

        $select_query="SELECT * FROM cart_details WHERE ip_address='$get_ip_add' AND product_id=$get_product_id"; // with '' when is varchar.

        $result_query=mysqli_query($con,$select_query);

        $num_of_rows=mysqli_num_rows($result_query);

        if($num_of_rows>0){
            echo "<script>alert('This item is already present inside cart')</script>";
            echo "<script>window.open('display_all_products.php','_self')</script>"; //'_self' open at the same page, '_blank', in a new page
            
        }else{
            $insert_query="INSERT INTO cart_details (product_id,ip_address,quantity) VALUES ($get_product_id,'$get_ip_add',1)";
            
            $result_query=mysqli_query($con,$insert_query);

            echo "<script>alert('Item is added to cart')</script>";
            echo "<script>window.open('display_all_products.php','_self')</script>"; //'_self' open at the same page, '_blank', in a new page
        }
    }
}


// function to get cart item (little) number in the header
function cart_item(){

        global $con;

        $get_ip_add = getIPAddress();
        $select_query="SELECT * FROM `cart_details` WHERE ip_address='$get_ip_add'";
        $result_query=mysqli_query($con,$select_query);
        $count_cart_items=mysqli_num_rows($result_query); 

        echo $count_cart_items;
}


// total price function (header)
function total_cart_price(){
    global $con;

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
            $formattedNumber = number_format($total_price, 2, '.', ',');
            $formattedCurrency = 'U$ ' . $formattedNumber;
        }

    }
    if($total_price==0){
        echo "-";
    }else{
        echo $formattedCurrency;
    }
}


// get user order details
function get_user_order_details(){
    global $con;

    $username=$_SESSION['username'];
    $get_details="SELECT * FROM `user_table` WHERE username='$username'";
    $result_query=mysqli_query($con,$get_details);

    while($row_query=mysqli_fetch_array($result_query)){
        $user_id=$row_query['user_id'];

        if(!isset($_GET['edit_account'])){
            if(!isset($_GET['my_orders'])){
                if(!isset($_GET['delete_account'])){
                    $get_orders="SELECT * FROM `user_orders` WHERE user_id=$user_id AND order_status='pending'";
                    $result_get_orders=mysqli_query($con,$get_orders);
                    $row_count=mysqli_num_rows($result_get_orders);

                    if($row_count>0){
                        echo "<h3 class='text-center text-success mt-5 mb-2'>You have <span class='text-danger'>$row_count</span> pending orders</h3>
                            <p class='text-center'><a href='profile.php?my_orders' class='text-dark'>Order Detais</a></P>";
                    }else{
                        echo "<h3 class='text-center text-success mt-5 mb-2'>You have zero pending orders</h3>
                            <p class='text-center'><a href='../display_all_products.php' class='text-dark'>Explore products</a></P>";
                    }
                }
            }
        }
    }
}

?>