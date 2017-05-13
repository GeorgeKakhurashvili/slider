<?php session_start(); ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
	<?php 
		 
		if (isset($_SESSION["check"])) {$check=$_SESSION["check"];}
			else
			{
				$check = 0;
			}
			if($check==0)
			{
				$_SESSION["empty_inputs"] = false;
				$_SESSION["wrong_pass_log"] = false;
			}
	?>
	<div id="text">
		<center><p>ადმინ პანელი</p></center>
		<?php if(@$_SESSION["empty_inputs"]) { ?>
		<div class="messages">
			<center><span>გთხოვთ შეავსოთ ყველა ველი!</span></center>
		</div>
		<?php  } elseif($_SESSION["wrong_pass_log"]) { ?>
		<div class="messages">
			<center><span>არასწორი ლოგინი ან პაროლი!</span></center>
		</div>
		<?php } else{echo "";} ?>
		
	</div>

	<div id="admin_page">
		<form action="sign_in.php" method="post" class = "form-group">
			<div class="inputs"><input type="text" name="login" class = "form-control" placeholder="ლოგინი"></div>
			<div class="inputs"><input type="password" name="password" class = "form-control" placeholder="პაროლი"></div>
			<div class="inputs"><center><input type="submit" value="ავტორიზაცია" class = 'btn btn-primary' style="font-family: BPG Mrgvlovani;"></center></div>
		</form>
	</div>
	<?php  
	unset($_SESSION["check"]);
	unset($_SESSION["empty_inputs"]);
	unset($_SESSION["wrong_pass_log"]);


	?>
</body>
</html>