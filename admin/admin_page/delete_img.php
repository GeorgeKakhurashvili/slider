<?php  
session_start();
ob_start();
include '../../includes/dbconnect.php';
include '../../includes/f.php';
$id = $_GET["id"];
$q="DELETE FROM slider_imgs WHERE id='$id'";
baza_do_only($q);
$_SESSION["check"] = true;
$_SESSION["delete_succs"] = true;
header("location:../admin_page/#2");
?>