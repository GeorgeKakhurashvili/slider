<?php session_start(); ob_start(); ?>
<html>
<head>
	<title>Admin</title>
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <script src="../../myscript.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/normalize.css" />
	<link rel="stylesheet" type="text/css" href="css/demo.css" />
	<link rel="stylesheet" type="text/css" href="css/component.css" />
    
</head>
<body>
  	<?php 
		include '../../includes/dbconnect.php';
		$select_main_imgs=mysqli_query($connect, "SELECT * from `slider_imgs`");
		$nums_main_imgs=mysqli_num_rows($select_main_imgs);
		if (isset($_SESSION["check"])) {$check=$_SESSION["check"];}
			else
			{
				$check = 0;
			}
			if($check==0)
			{
				$_SESSION["succ_insert"] = false;
				$_SESSION["not_succ_insert"] = false;
				$_SESSION["too_many_imgs"] = false;
				$_SESSION["delete_succs"] = false;
				$_SESSION["empty_in"] =false;
			}
	if($_SESSION["loggined"]){
	?>
	<nav class="nav">
	  <div class="burger burger--active">
	    <div class="burger__patty"></div>
	  </div>

	  <ul class="nav__list nav__list--active">
	    <li class="nav__item" title="სურათის დამატება">
	      <a href="#1" class="nav__link c-blue"><i class="fa fa-camera-retro"></i></a>
	    </li>
	    <li class="nav__item" title="სურათის წაშლა">
	      <a href="#2" class="nav__link c-yellow scrolly"><i class="fa fa-trash-o"></i></a>
	    </li>
	    <li class="nav__item" title="ვებ-გვერდზე გადასვლა">
	      <a href="../../../slider" class="nav__link c-red" target="_blank"><i class="fa fa-home"></i></a>
	    </li>
	    <li class="nav__item" title="გასვლა">
	      <a href="sign_out.php" class="nav__link c-red1 scrolly"><i class="fa fa-sign-out"></i></a>
	    </li>
	  </ul>
	</nav>

	<section class="panel b-blue" id="1" >
	  <article class="panel__wrapper">
	    <div class="panel__content">
	      <h1 class="panel__headline"><i class="fa fa-camera-retro"></i>&nbsp;სურათების დამატება</h1>
	      <div class="panel__block"></div>
	      <?php  if (@$_SESSION["succ_insert"]) { ?>      
	      <center><p>სურათი წარმატებით დაემატა!</p></center>
	      <?php  } elseif (@$_SESSION["empty_in"]) { ?>
	      <center><p>აირჩიე სურათი!</p></center>
	      <?php  } elseif (@$_SESSION["not_succ_insert"]) { ?>
	      <center><p>სურათი ვერ დაემატა, სცადეთ ახლიდან!</p></center>
	      <?php  } elseif (@$_SESSION["too_many_imgs"]) { ?>
	      <center><p>სურათების რაოდენობამ გადააჭარბა 6-ს, წაშალეთ რომელიმე!</p></center>
	      <?php } else echo ""; ?>
	      <div id="input_img">
	      	<form action="add_photo.php" method="post" enctype="multipart/form-data" class = "form-group">
	      		<div class="box">
						<input type="file" name="file-1" id="file-1" class="inputfile inputfile-1" style="display: none;">
						<label for="file-1"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg> <span>აირჩიე ფაილი</span></label>
						<div id="submit_photo">
							<input type="submit" name="" value="დამატება">
						</div>
				</div>
				

	      	</form>

	      </div>
	    </div>
	  </article>
	</section>
	<section class="panel b-yellow" id="2">
	  <article class="panel__wrapper">
	    <div class="panel__content" style="margin-top: -200px;">
	      <h1 class="panel__headline"><i class="fa fa-trash-o"></i>&nbsp;სურათების წაშლა</h1>
	      <div class="panel__block"></div>
	      <?php  if (@$_SESSION["delete_succs"]) { ?>      
	      <center><p>სურათი წარმატებით წაიშალა!</p></center>
	      <?php } else echo ""; ?>
	      <article id="gallery">
			<?php for ($i=0; $i < $nums_main_imgs; $i++) { $rows_img=mysqli_fetch_assoc($select_main_imgs); $id = $rows_img["id"]; ?>

			<a href="delete_img.php?id=<?=$id?>" id="delete_img_<?=$i?>" >
				<img src="<?=$rows_img['img_src_1']?>">
			</a>

			<?php  } ?>	
			
		  </article>
	    </div>
	  </article>
	</section>
	<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script src="js/index.js"></script>
	<?php }else{header("location:../../admin");}
	unset($_SESSION["succ_insert"]); 
	unset($_SESSION["not_succ_insert"]);
	unset($_SESSION["delete_succs"]);
	unset($_SESSION["check"]);

	?>
</body>
</html>