
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
            btn.setAttribute("href", "index.php?delete_categories=" + id);
        }
    </script>
</head>
<body>
    <h3 class="text-center text-success">View Categories</h3>
    <div class="button">
        <button class="mt-1">
            <a href="index.php?insert_category" class="nav-link text-light bg-info p-2">Insert Categories</a>
        </button>
    </div>
    <table class="table table-bordered mt-5">
        <thead class="text-center bg-info">
            <tr>
                <th>Category ID</th>
                <th>Category Title</th>
                <th>Number of Products</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="text-center bg-secondary text-light">
            <?php
                $select_categories="SELECT * FROM `categories` ORDER BY category_title";
                $result_select_categories=mysqli_query($con,$select_categories);

                while($row_data_categories=mysqli_fetch_array($result_select_categories)){
                    $category_id=$row_data_categories['category_id'];
                    $category_title=$row_data_categories['category_title'];

                    $select_products_category="SELECT * FROM `products` WHERE category_id=$category_id";
                    $result_select_products_category=mysqli_query($con,$select_products_category);
                    $product_category_num_row=mysqli_num_rows($result_select_products_category);
            
            ?>
            <tr>
                <td><?php echo $category_id?></td>
                <td><?php echo $category_title?></td>
                <td><?php echo $product_category_num_row?></td>
                <td><a href="index.php?edit_categories=<?php echo $category_id ?>" class="text-light"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <!-- <td><a href="index.php?delete_categories=<?php echo $category_id ?>" type="button" class="text-light" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-trash"></i></a></td> -->
                <td><a href="javascript:void(0);" type="button" class="text-light" data-bs-toggle="modal" onclick="deleteProduct(<?php echo $category_id; ?>)" data-bs-target="#exampleModalProducts"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><a href="index.php?view_categories" class="text-light text-decoration-none">No</a></button>
            <button type="button" class="btn btn-primary"><a href="" id="btn-delete-confirm" class="text-light text-decoration-none">Yes</a></button>
        </div>
        </div>
    </div>
    </div>

    <!--cart.php?delete_cart_product=<?php echo $category_id ?> -->
                                        
</div>
    
</body>
</html>