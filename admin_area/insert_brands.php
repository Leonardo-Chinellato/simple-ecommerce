<?php
include('../includes/connect.php');

if(isset($_POST['insert_brand'])){ /* submit input name */
    $brand_title=filter_input(INPUT_POST,'brand_title',FILTER_SANITIZE_SPECIAL_CHARS);

    if($brand_title==''){
        echo "<script>alert('Please fill all the fields and continue the process')</script>";
    }else{
    // select data from database
    $select_query="select * from brands where brand_title='$brand_title'";
    $result_select=mysqli_query($con, $select_query);
    $number=mysqli_num_rows($result_select);

    if(!$number>0){ // if is a pre-exist category with the same name

        /* insert into TABLE (COLUNM) values ('THE VALUE THAT WAS ENTERED BY THE USER' [with '' becouse is varchar]); */
        $insert_query="insert into brands (brand_title) values ('$brand_title')";

        /* mysqli_query(CONNECTION VARIABLE, QUERY VARIABLE) */
        $result=mysqli_query($con, $insert_query);

        if($result){
            echo "<script>alert('Brand has been inserted successfully')</script>";
            echo "<script>window.open('index.php?view_brands','_self')</script>";
        }

    }else{
        echo "<script>alert('This brand is already present inside the database')</script>";
    }}
}

?>

<h2 class="text-center">Insert Brand</h2>

<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
       <!--  <div class="input-group-prepend p-1"> -->
            <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <!-- </div> -->
        <input type="text" class="form-control" name="brand_title" placeholder="Insert Brand" aria-label="brands" aria-describedby="basic-addon1" value="<?php if(isset($_POST['insert_brand'])){echo $brand_title;}?>">
    </div>
    <div class="input-group w-10 mb-2 m-auto">

        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_brand" value="Insert Brand">
       
    </div>
</form>