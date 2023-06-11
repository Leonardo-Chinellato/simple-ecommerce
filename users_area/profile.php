<!-- connect file -->
<?php 
include('../includes/connect.php');
include('../functions/common_function.php');
@session_start();

// Verification
if(!isset($_SESSION['username'])){
    header('location:user_login.php');
}

// Data
$username=$_SESSION['username'];
$sql="SELECT * FROM `user_table` WHERE username='$username'";
$result = mysqli_query($con,$sql);

?>
<?php /* include('../functions/common_function.php'); */ ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome <?php echo $_SESSION['username']; ?></title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css file -->
    <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the cache problem -->

</head>

<body>

    <!-- navbar -->
    <div class="container-fluid p-0">
        
        
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info"> <!-- Changed "bg-body-tertiary" to "navbar-light bg-info" -->
            <div class="container-fluid"> 
                <img src="../images_from_google/logo.jpg" alt="" class="logo"> <!-- Use svg images  --> <!-- Changed "<a class="navbar-brand" href="#">Logo</a>" to img (logo) -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../index.php">Home</a> <!-- changed "href="#"" to href="/" -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../display_all_products.php">Products</a> <!-- Changed "Link" to "Products" -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a> <!-- Changed "Link" to "Contact" -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../cart.php"><i class="fa-solid fa-cart-shopping"></i><sup> <?php cart_item(); ?> </sup></a> <!-- Changed "Link" to "Cart" from https://fontawesome.com/icons/cart-shopping?s=solid&f=classic -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../cart.php">Total Price: <?php total_cart_price(); ?></a> <!-- Changed "Link" to "Total Price:" -->
                        </li>                                
                    </ul> 
                    <form class="d-flex" role="search" action="../search_product.php" method="get">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
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
                            <a href='profile.php' class='nav-link'>Welcome ".$_SESSION['username']."</a>
                        </li>";
                    }
                
                
                    if(!isset($_SESSION['username'])){
                        echo "
                        <li class='nav-item'>
                            <a href='checkout.php' class='nav-link'>Login</a>
                        </li>";
                    }else{
                        echo "
                        <li class='nav-item'>
                            <a href='logout.php' class='nav-link'>Logout</a>
                        </li>";
                    }
                ?>                
            </ul>
        </nav>

    

        <!-- third child -->
        <div class="bg-light">
            <h3 class="text-center">Hidden Store</h3>
            <p class="text-center">Communications is at the heart of e-commerce and community</p>
        </div>


        <!-- fouth child -->
        <div class="row">
            <div class="col-md-2 p-0">
                <ul class="navbar-nav bg-secondary text-center">
                    <li class="nav-item">
                        <a href="" class="nav-link text-light bg-info"><h4>Your Profile</h4></a>
                    </li>

                    <?php
                        $username=$_SESSION['username'];
                        $user_image_query="SELECT * FROM `user_table` WHERE username='$username'";
                        $result_user_image=mysqli_query($con,$user_image_query);
                        $row_image=mysqli_fetch_array($result_user_image);
                        $user_image=$row_image['user_image'];
                        echo "
                            <li class='nav-item'>
                                <img src='./user_images/$user_image' class='admin_image' alt=''>
                            </li>";
                    ?>
                    
                    <li class="nav-item">
                        <a href="profile.php" class="nav-link text-light">Pending Orders</a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php?edit_account" class="nav-link text-light">Edit Account</a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php?my_orders" class="nav-link text-light">My Orders</a>
                    </li>
                    <li class="nav-item">
                        <a href="profile.php?delete_account" class="nav-link text-light">Delete Account</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link text-light">Logout</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 text-center">
                <?php
                    get_user_order_details();
                    if(isset($_GET['edit_account'])){
                        include('edit_account.php');
                    }if(isset($_GET['my_orders'])){
                        include('user_orders.php');
                    }if(isset($_GET['delete_account'])){
                        include('delete_account.php');
                    }
                ?>
            </div>
        </div>
        
        

        <!-- last child -->
            <!-- include footer -->
            <?php include("../includes/footer.php"); ?>

    </div>



    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>