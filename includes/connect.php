<?php

// four parameters = localhost, username, password, database name.
$con=mysqli_connect('127.0.0.1:3307','root','','mystore'); // localhost was not working, changed to "127.0.0.1:3307".

if(!$con):
    die(mysqli_error($con));
endif;

?>