<html>
<head>
	<title>Slider</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="myscript.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body onload="alert_func();">
	<?php 
	include 'includes/dbconnect.php';
	$array_first_img = array();
	$select_main=mysqli_query($connect, "SELECT * from `slider_imgs`");
	//$main_row=mysqli_fetch_assoc($select_main);
	$nums_main=mysqli_num_rows($select_main);
	echo "<script>mass = new Array();</script>";
	for ($i=0; $i < $nums_main; $i++) { 
		$main_row1=mysqli_fetch_assoc($select_main);
		$img_src=$main_row1["img_src"];
		array_push($array_first_img,$img_src);
		echo "<script>mass.push('".$img_src."');</script>";	
	}
	?>
	<center>
	<div id="full_div">
		<div id="large_div">
			<img src="<?=$array_first_img[0]?>" id="image">
		</div>

			<div id="left_position"></div>
			<div id="arrow_left" onclick="move_backward();" onmouseover="slide_from_left();" onmouseout="back_to_left();">
			</div>

		<div id="full1">
			<div id="right_position"></div>
			<div id="arrow_right" onclick="move_forward();" onmouseover="slide_from_right();" onmouseout="back_to_right();"> 

			</div>
		</div>

	</div>
	</center>
</body>
</html>