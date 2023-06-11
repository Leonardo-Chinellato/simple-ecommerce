<?php
include('../includes/connect.php');

if(isset($_POST['insert_cat'])){ /* submit input name */
    /* $category_title=$_POST['cat_title']; */ /* text input name */
    $category_title=filter_input(INPUT_POST,'cat_title',FILTER_SANITIZE_SPECIAL_CHARS);

    if($category_title==''){
        echo "<script>alert('Please fill all the fields and continue the process')</script>";
    }else{
    
    // select data from database
    $select_query="select * from categories where category_title='$category_title'";
    $result_select=mysqli_query($con, $select_query);
    $number=mysqli_num_rows($result_select);
    
    if(!$number>0){ // if is a pre-exist category with the same name

        /* insert into TABLE (COLUNM) values ('THE VALUE THAT WAS ENTERED BY THE USER' [with '' becouse is varchar]); */
        $insert_query="insert into categories (category_title) values ('$category_title')"; 
        
        /* mysqli_query(CONNECTION VARIABLE, QUERY VARIABLE) */
        $result=mysqli_query($con,$insert_query);
    
        if($result){
            echo "<script>alert('Category has been inserted successfully')</script>";
            echo "<script>window.open('index.php?view_categories','_self')</script>";
        }

    }else{
        echo "<script>alert('This category is already present inside the database')</script>";
    }
    }
}

    

?>

<h2 class="text-center">Insert Category</h2>

<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
       <!--  <div class="input-group-prepend p-1"> -->
            <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <!-- </div> -->
        <input type="text" class="form-control" name="cat_title" placeholder="Insert Category" aria-label="categories" aria-describedby="basic-addon1" value="<?php if(isset($_POST['insert_cat'])){echo $category_title;}?>">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_cat" value="Insert Category">
       
    </div>
</form>
