<?php  
session_start();
ob_start();
include '../includes/dbconnect.php';
include '../includes/f.php';
if (isset($_POST["login"])) {
	$login = post($_POST["login"]);
}
if (isset($_POST["password"])) {
	$password = post($_POST["password"]);
}
if(strlen($login)!=0 && strlen($password)!=0) {
	
	$select_main=mysqli_query($connect, "SELECT * from `admin` where `login`='$login' and `password`='$password'");
	$nums_main=mysqli_num_rows($select_main);
	if ($nums_main>0) {
		header("location:admin_page");
		$_SESSION["loggined"] = true;
	}
	else
	{
		$_SESSION["check"] = true;
		$_SESSION["wrong_pass_log"] = true;
		header("location:../admin");
	}

}
else
{
	$_SESSION["check"] = true;
	$_SESSION["empty_inputs"] = true;
	header("location:../admin");
}

?>