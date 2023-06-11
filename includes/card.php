<?php

$formattedNumber = number_format($product_price, 2, '.', ',');
$formattedCurrency = 'U$ ' . $formattedNumber;

echo "
    <div class='col-md-4 mb-2'>
        <!-- card title from bootstrap -->
        <div class='card'> 
            <img class='card-img-top' src='admin_area/products_images/$product_image1' alt='...'>
            <div class='card-body'>
                <h5 class='card-title'>$product_title</h5>
                <p class='card-text'>$product_description</p>
                <p class='card-text'>$formattedCurrency</p>
                <a href='index.php?add_to_cart=$product_id' class='btn btn-info'>Add to cart</a>
                <a href='product_details.php?product_id=$product_id' class='btn btn-secondary'>View more</a>
            </div>
        </div>
    </div>
";