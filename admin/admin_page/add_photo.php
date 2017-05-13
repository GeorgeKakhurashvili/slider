<?php
session_start();
ob_start();  
include '../../includes/dbconnect.php';
include '../../includes/f.php';
$select_main_imgs=mysqli_query($connect, "SELECT * from `slider_imgs`");
$nums_main_imgs=mysqli_num_rows($select_main_imgs);
if(isset($_FILES["file-1"]))
{
	$photo=$_FILES["file-1"];
	$file_type=$_FILES["file-1"]["type"];
	$file_name=$_FILES["file-1"]["name"];
	$file_temp_name=$_FILES["file-1"]["tmp_name"];
	$file_size=$_FILES["file-1"]["size"];

	if($file_type=="image/jpeg" && $file_name!='')
	{
		$new_file_name="../../images/f_".time("U").".jpg";
		$new_img_name_1="images/f_".time("U").".jpg";
		$new_img_name="f_".time("U").".jpg";
		$upl_img=move_uploaded_file($file_temp_name, $new_file_name);
	}
}
if (strlen($file_name) == 0) {
	$_SESSION["check"] = true;
	$_SESSION["empty_in"] = true;
	header("location:../admin_page");
}
elseif ($nums_main_imgs == 6) {
	$_SESSION["check"] = true;
	$_SESSION["too_many_imgs"] = true;
	header("location:../admin_page");
	}

elseif (strlen($file_name)>0) {
	
	$q="INSERT INTO slider_imgs (img_src,img_src_1) VALUES('$new_img_name_1','$new_file_name')";
	baza_do_only($q);
	$_SESSION["check"] = true;
	$_SESSION["succ_insert"] = true;
	header("location:../admin_page");
}
else
{
	$_SESSION["check"] = true;
	$_SESSION["not_succ_insert"] = true;
	header("location:../admin_page");
}

?>