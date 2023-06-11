<!-- connect file -->
<?php 
include('../includes/connect.php');
@session_start(); 
?>
<?php /* include('../functions/common_function.php'); */ ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce website-Checkout Page</title>

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
                        <?php
                            if(!isset($_SESSION['username'])){
                                echo "
                                <li class='nav-item'>
                                    <a class='nav-link' href='user_registration.php'>Register</a>
                                </li>";
                            }else{
                                echo "
                                <li class='nav-item'>
                                    <a class='nav-link' href='profile.php'>My Account</a>
                                </li>";
                                }
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a> <!-- Changed "Link" to "Contact" -->
                        </li>
                    </ul>                    
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
        <div class="row px-1">
            <div class="col-md-12">
                <!-- products -->
                <div class="row">
                    <?php
                        if(!isset($_SESSION['username'])){
                            include('user_login.php');
                        }
                        else{
                            include('payment.php');
                        }                        
                    ?>
                </div>
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