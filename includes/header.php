<!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info"> <!-- Changed "bg-body-tertiary" to "navbar-light bg-info" -->
            <div class="container-fluid"> 
                <img src="images_from_google/logo.jpg" alt="" class="logo"> <!-- Use svg images  --> <!-- Changed "<a class="navbar-brand" href="#">Logo</a>" to img (logo) -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a> <!-- changed "href="#"" to href="/" -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="display_all_products.php">Products</a> <!-- Changed "Link" to "Products" -->
                        </li>
                        <?php
                            if(!isset($_SESSION['username'])){
                                echo "
                                <li class='nav-item'>
                                    <a class='nav-link' href='.\users_area\user_registration.php'>Register</a>
                                </li>";
                            }else{
                                echo "
                                <li class='nav-item'>
                                    <a class='nav-link' href='.\users_area\profile.php'>My Account</a>
                                </li>";
                                }
                        ?>

                        
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a> <!-- Changed "Link" to "Contact" -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-shopping"></i><sup> <?php cart_item(); ?> </sup></a> <!-- Changed "Link" to "Cart" from https://fontawesome.com/icons/cart-shopping?s=solid&f=classic -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Total Price: <?php total_cart_price(); ?></a> <!-- Changed "Link" to "Total Price:" -->
                        </li>         
                    </ul>
                    <form class="d-flex" role="search" action="search_product.php" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data" value="<?php if(isset($_GET['search_data'])) {$search_data_value=filter_input(INPUT_GET,'search_data',FILTER_SANITIZE_SPECIAL_CHARS); echo $search_data_value;}?>">
                        <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_product">
                    </form>
                </div>
            </div>
        </nav>

<!-- second child -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
            <?php
                    if(!isset($_SESSION['username'])){
                        echo "
                        <li class='nav-item'>
                            <a href='#' class='nav-link'>Welcome Guest</a>
                        </li>";
                    }else{
                        echo "
                        <li class='nav-item'>
                            <a href='users_area\profile.php' class='nav-link'>Welcome ".$_SESSION['username']."</a>
                        </li>";
                    }
                
                
                    if(!isset($_SESSION['username'])){
                        echo "
                        <li class='nav-item'>
                            <a href='./users_area/checkout.php' class='nav-link'>Login</a>
                        </li>";
                    }else{
                        echo "
                        <li class='nav-item'>
                            <a href='./users_area/logout.php' class='nav-link'>Logout</a>
                        </li>";
                    }
                ?>                
            </ul>
        </nav>


        