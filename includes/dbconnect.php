<?php
	$core_db_name = "slider";
	$core_db_user = "root";
	$core_db_pass = "";
	$core_db_server = "localhost";


	
	$connect = mysqli_connect($core_db_server,$core_db_user,$core_db_pass, $core_db_name);

	mysqli_query($connect, "SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	$org = "core";
// $q="select * from `general_settings` where `id`='1'";
// $db_result=$connect->query($q);
// while ($row = mysqli_fetch_array($db_result, MYSQLI_ASSOC)) {
	// $db_result=$row;
	// break;
// }


// $org = $db_result['comp_folder'];
// $allowed_ir=array("jpg","png","jpeg","gif");
// $upfilesdir = dirname(__FILE__).'/../uploads/'.$org.'/';
// $upfilesdir2 = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/'.$org.'/';

?>