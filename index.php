<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
 <div class="animated fadeIn">
  <div class="row border-bottom col-12"> 
	<div class="main_header">
		<?php if($_SESSION['logged_in'] != true){ ?>
		<a href="create-account.php"><button type="button" class="btn btn-outline-default waves-effect log_button">create account</button></a>
		<a href="log-in.php"><button type="button" class="btn btn-outline-info waves-effect log_button">log in</button></a>
		<?php } else {?>
		<a href="http://localhost/profile.php?hash=<?php echo $_SESSION['hash']; ?>"><button type="button" class="btn btn-outline-default waves-effect log_button"><?php echo $_SESSION['login'] ; ?> <i class="fa fa-user mr-2"aria-hidden="true"></i></button></a>
		<a href="logout.php"><button type="button" class="btn btn-outline-info waves-effect log_button">log out <i class="fa fa-rocket" aria-hidden="true"></i></button></a>
		<?php } ?>
	</div>
  </div>
  <div class="main_buttons">
	<div class="row">
		<div class="col-12 offset-sm-1 col-sm-3">
			<a href="buy.php"><button class="btn peach-gradient" style="font-size: 5rem;">buy</button></a>
		</div>
		<div class="col-12 offset-sm-2 offset-md-1 col-sm-3">
			<a href="sell.php"><button class="btn aqua-gradient" style="font-size: 5rem;">sell</button></a>
		</div>
	</div>
	<div class="row">		
		<div class="col-12 offset-sm-0 col-sm-4 offset-md-2">
			<a href="find-vacancy.php"><button class="btn purple-gradient" style="font-size: 3rem;">find<br>vacancy</button></a>
		</div>
		<div class="col-12 offset-sm-2 col-sm-4 offset-md-1 offset-lg-0">
			<a href="add-vacancy.php"><button class="btn blue-gradient" style="font-size: 3rem;">add<br> vacancy</button></a>
		</div>
	</div>
  </div>  
 </div>

  <!-- SCRIPTS -->
  <!-- JQuery -->
  <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="js/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="js/mdb.min.js"></script>
</body>

</html>
