<!-- connect file -->
<?php 
include('../includes/connect.php');
include('../functions/common_function.php');
@session_start();

// Verification
if(!isset($_SESSION['admin_name'])){
    header('location:admin_login.php');
}

// Data
$admin_name=$_SESSION['admin_name'];
$sql="SELECT * FROM `admin_table` WHERE admin_name='$admin_name'";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    
    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

     <!-- css file -->
     <link rel="stylesheet" href="../style.css" type="text/css" <?php echo date('Ymdhis'); ?>> <!-- this PHP code fix the chache problem -->

</head>
<body>
    <!-- navbar -->
    <div class="container-fluid p-0">
        
        <!-- first child -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images_from_google/logo.jpg" alt="" class="logo">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="#" class="nav-link">Welcome <?php echo $_SESSION['admin_name'] ?></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>


        <!-- second child -->
        <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
        </div>


        <!-- third child -->
        <div class="row">
            <div class="col-md-12 bg-secondary p-1 d-flex align-items-center justify-content-center">
                <div class="p-3">
                    <a href="#"><img src="../images_from_google/icon-admin.png" alt="" class="admin_image"></a>
                    <p class="text-light text-center pt-2"><a class="nav-link" href="#"><?php echo $_SESSION['admin_name'] ?></a></p>
                </div>
                <div class="button text-center mx-5">
                    <button class="m-2 mx-3">
                        <a href="index.php?view_products" class="nav-link text-light bg-info p-2">Products</a>
                    </button>
                    <button class="m-2 mx-3">
                        <a href="index.php?view_categories" class="nav-link text-light bg-info p-2">Categories</a>
                    </button>
                    <button class="m-2 mx-3">
                        <a href="index.php?view_brands" class="nav-link text-light bg-info p-2">Brands</a>
                    </button>
                    <button class="m-2 mx-3">
                        <a href="index.php?list_orders" class="nav-link text-light bg-info p-2">All Orders</a>
                    </button>
                    <button class="m-2 mx-3">
                        <a href="index.php?list_payments" class="nav-link text-light bg-info p-2">All Payments</a>
                    </button>
                    <button class="m-2 mx-3">
                        <a href="index.php?list_users" class="nav-link text-light bg-info p-2">List Users</a>
                    </button>
                    <button class="m-2 mx-3">
                        <a href="logout.php" class="nav-link text-light bg-info p-2">Logout</a>
                    </button>
                </div>
            </div>
        </div>


        <!-- fourth child -->
        <div class="container my-3">
            <?php
            if(isset($_GET['insert_category'])) {
                include('insert_categories.php');
            }
            if(isset($_GET['insert_brand'])) {
                include('insert_brands.php');
            }
            if(isset($_GET['insert_products'])) {
                include('insert_products.php');
            }
            if(isset($_GET['view_products'])){
                include('view_products.php');
            }
            if(isset($_GET['edit_products'])){
                include('edit_products.php');
            }
            if(isset($_GET['delete_products'])){
                include('delete_products.php');
            }
            if(isset($_GET['view_categories'])){
                include('view_categories.php');
            }
            if(isset($_GET['edit_categories'])){
                include('edit_categories.php');
            }
            if(isset($_GET['delete_categories'])){
                include('delete_categories.php');
            }
            if(isset($_GET['view_brands'])){
                include('view_brands.php');
            }
            if(isset($_GET['edit_brands'])){
                include('edit_brands.php');
            }
            if(isset($_GET['delete_brands'])){
                include('delete_brands.php');
            }
            if(isset($_GET['list_orders'])){
                include('list_orders.php');
            }
            if(isset($_GET['delete_orders'])){
                include('delete_orders.php');
            }
            if(isset($_GET['list_payments'])){
                include('list_payments.php');
            }
            if(isset($_GET['delete_payments'])){
                include('delete_payments.php');
            }
            if(isset($_GET['list_users'])){
                include('list_users.php');
            }
            if(isset($_GET['delete_users'])){
                include('delete_users.php');
            }
            if(isset($_GET['edit_users'])){
                include('edit_users.php');
            }

            ?>
        </div>


        <!-- last child -->
            <!-- include footer -->
            <?php include("../includes/footer.php"); ?>

        

    </div>
    

    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>