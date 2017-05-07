<?php
    $dbhost  = 'localhost'; 
    $dbname  = 'auction_management_db'; 
    $dbuser  = 'root';   
    $dbpass  = '';     
    
    $con=mysqli_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
    mysqli_select_db($con,$dbname) or die(mysql_error());

    function sanitizeString($con,$var){
        $var = strip_tags($var);
        $var = htmlentities($var);
        $var = stripslashes($var);
        return mysqli_real_escape_string($con,$var);
    }
?>

