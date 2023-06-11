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
    <title>Ecommerce website using PHP and MySQL</title>

    <!-- bootstrap css link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

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


        <!-- fouth child -->
        <div class="row px-1">
            <div class="col-md-10">
                <!-- products -->
                <div class="row">

                    <!-- fetching products -->
                    <?php
                        // calling function
                        view_details();
                        get_unique_brand();
                        get_unique_category();
                    ?>
                   
                </div>
                <!-- end row -->
            </div>
            <!-- end col -->


            <!-- sidenav -->
            <?php include("./includes/sidenav.php") ?>
        </div>




        <!-- last child -->
            <!-- include footer -->
            <?php include("./includes/footer.php"); ?>

    </div>



    <!-- bootstrap js link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>