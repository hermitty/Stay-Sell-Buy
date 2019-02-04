<?php
//require 'header.php';
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
  <!-- header -->
  <div class="row border-bottom col-12"> 
	<div class="content-to-hide-big">
		<a href="index.php"><button type="button" class="btn btn-primary px-3 mean-fruit-gradient"><i class="fa fa-home" aria-hidden="true"></i></button></a>
		<a href="buy.php"><button class="btn peach-gradient">buy</button></a>
		<a href="sell.php"><button class="btn aqua-gradient">sell</button></a>
		<a href="find-vacancy.php"><button class="btn purple-gradient">find vacancy</button></a>
		<a href="add-vacancy.php"><button class="btn blue-gradient">add vacancy</button></a>
	</div>
	<div class="content-to-hide-small">
		<div class="dropdown">
		  <button class="btn btn-secondary dropdown-toggle sunny-morning-gradient" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Menu
		  </button>
		  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			<a class="dropdown-item" href="index.php">Home</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="buy.php">Buy</a>
			<a class="dropdown-item" href="sell.php">Sell</a>
			<a class="dropdown-item" href="find-vacancy.php">Find Vacancy</a>
			<a class="dropdown-item" href="add-vacancy.php">Add Vacancy</a>
		  </div>
		</div>
	</div>	
	<div class="log_button">
		<?php if($_SESSION['logged_in'] != true){ ?>
		<a href="create-account.php"><button type="button" class="btn btn-outline-default waves-effect log_button">create account</button></a>
		<a href="log-in.php"><button type="button" class="btn btn-outline-info waves-effect log_button">log in</button></a>
		<?php } else {?>
		<a href="http://localhost/profile.php?hash=<?php echo $_SESSION['hash']; ?>"><button type="button" class="btn btn-outline-default waves-effect log_button"><?php echo $_SESSION['login'] ; ?> <i class="fa fa-user mr-2"aria-hidden="true"></i></button></a>
		<a href="logout.php"><button type="button" class="btn btn-outline-info waves-effect log_button">log out <i class="fa fa-rocket" aria-hidden="true"></i></button></a>
		<?php } ?>
	</div>
  </div>
  <!-- Header -->
  <div class="">
	<div class="main_buttons">
	<h1>Success!</h1>
	<p>
	<?php
	if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ):
		echo $_SESSION['message'];
	else:
		header( "location: index.php" );
	endif;
	?>
	</p>
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
