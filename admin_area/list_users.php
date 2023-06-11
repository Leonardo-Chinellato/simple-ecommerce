<?php
?>
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
            btn.setAttribute("href", "index.php?delete_users=" + id);
        }
    </script>

</head>
<body>
<div class="container">
    <h3 class="text-center text-success">List Users</h3>
    <table class="table table-bordered">
        <thead class="text-center bg-info">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Image</th>
                <th>User IP</th>
                <th>Address</th>
                <th>Mobile</th>
                <th>Active</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="text-center text-light bg-secondary">
            <?php
                $select_list_users="SELECT * FROM `user_table` ORDER BY username";
                $result_select_list_users=mysqli_query($con,$select_list_users);

                $row_count=mysqli_num_rows($result_select_list_users);

                if($row_count==0){
                    echo "<h5 class='text-center text-danger mt-5'>No users</h5>";
                }else{

                  // pagination

            $limit=6; // variable to store the number of rows per page

            if(!isset($_GET['page'])){  

                $page_number=1;  
    
            }else{  
    
                $page_number=$_GET['page'];  
    
            }

            $initial_page=($page_number-1)*$limit;  // get the initial page number

            $total_rows=mysqli_num_rows($result_select_list_users);

            $total_pages=ceil($total_rows/$limit); // get the required number of pages

            // Prev + Next
            $prev = $page_number - 1;
            $next = $page_number + 1;

            $initial_page=($page_number-1)*$limit; // get the initial page number

            $getQuery = "SELECT * FROM user_table ORDER BY username LIMIT " . $initial_page . ',' . $limit;

            $result=mysqli_query($con,$getQuery);

                while($row_data=mysqli_fetch_array($result)){
                    $user_id=$row_data['user_id'];
                    $username=$row_data['username'];
                    $user_email=$row_data['user_email'];
                    $user_image=$row_data['user_image'];
                    $user_ip=$row_data['user_ip'];
                    $user_address=$row_data['user_address'];
                    $user_mobile=$row_data['user_mobile'];
                    $user_active=$row_data['user_active'];
            ?>
            <tr>
                <td><?php echo $user_id?></td>
                <td><?php echo $username?></td>
                <td><?php echo $user_email?></td>
                <td><img class="admin_image" src="../users_area/user_images/<?php echo $user_image?>"></td>
                <td><?php echo $user_ip?></td>
                <td><?php echo $user_address?></td>
                <td><?php echo $user_mobile?></td>
                <td><?php echo $user_active?></td>
                <td><a href="index.php?edit_users=<?php echo $user_id ?>" class="text-light"><i class="fa-solid fa-pen-to-square"></i></a></td>
                <!-- <td><a href="index.php?delete_users=<?php echo $user_id ?>" type="button" class="text-light" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-trash"></i></a></td> -->
                <td><a href="javascript:void(0);" type="button" class="text-light" data-bs-toggle="modal" onclick="deleteProduct(<?php echo $user_id; ?>)" data-bs-target="#exampleModalProducts"><i class="fa-solid fa-trash"></i></a></td>
            </tr>
            <?php
                }
                 // Pagination from bootstrap
        if($total_rows!==0){
          ?>            
              <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center">
                      <li class="page-item <?php if($page_number <= 1){ echo 'disabled'; } ?>">
                          <a class="page-link" href="<?php if($page_number <= 1){ echo '#'; } else { echo "?list_users&page=" . $prev; } ?>" aria-label="Previous">
                              <span aria-hidden="true">&laquo;</span>
                              <span class="sr-only">Previous</span>
                          </a>
                      </li>
                      <?php for($i = 1; $i <= $total_pages; $i++ ): ?>
                      <li class="page-item <?php if($page_number == $i) {echo 'active'; } ?>">
                          <a class="page-link" href="index.php?list_users&page=<?= $i; ?>"><?= $i; ?></a>
                      </li>
                      <?php endfor; ?>
                      
                      <li class="page-item <?php if($page_number >= $total_pages) { echo 'disabled'; }?>">
                          <a class="page-link" href="<?php if($page_number >= $total_pages){ echo '#'; } else {echo "?list_users&page=". $next; } ?>" aria-label="Next">
                              <span aria-hidden="true">&raquo;</span>
                              <span class="sr-only">Next</span>
                          </a>
                      </li>
                  </ul>
              </nav>

          <?php
          }
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
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><a href="index.php?list_users" class="text-light text-decoration-none">No</a></button>
            <button type="button" class="btn btn-primary"><a href="" id="btn-delete-confirm" class="text-light text-decoration-none">Yes</a></button>
        </div>
        </div>
    </div>
    </div>

    <!--cart.php?delete_cart_product=<?php echo $brand_id ?> -->
                                        
</div>

</div>
</body>