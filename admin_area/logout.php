<?php

session_start();
session_unset();
session_destroy();
echo "<script>alert('Logout successful!')</script>";
echo "<script>window.open('../index.php','_self')</script>";



?>