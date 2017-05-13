<?php  
session_start();
ob_start();
$_SESSION["loggined"] = false;
header("location:../admin_page"); 
?>