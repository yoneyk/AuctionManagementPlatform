<?php
    session_start();
    include_once 'commonFunctions.php';
    unset($_SESSION['email']); 
    session_destroy();
    header('location:index.php');
?>

