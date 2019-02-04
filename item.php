<?php
//require 'header.php';
session_start();
require 'connect.php';
if(isset($_GET["hash"])){
	$hash = $_GET["hash"];
	//$sql_query = "SELECT * from website.user ";
	$sql_query = "SELECT title, category, description, price, contact, item.status as status, login as added_by, user.hash as uhash, item.hash as phash, photo1, photo2, photo3 ";
	$sql_query .= "FROM website.item, website.user ";
	$sql_query .= "where iduser = added_by and item.hash = '$hash' ";
	$run_query = mysqli_query($connection, $sql_query);
	$data=mysqli_fetch_assoc($run_query);
	//print_r($data);
	
}

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
  <div class="container">
	<div class="row">
		<div class="box centre col-9 pad text-centre"> <!-- box -->
				<h3><?php echo $data['title'] ?></h3>
				<div class="row">
					<div class="col offset-2 text-left">
					<div class="bottom pad-left">
					
						<p>Price: <?php echo $data['price'] ?></p>
						<p>Contact: <?php echo $data['contact'] ?></p>
						<p>Category: <?php echo $data['category'] ?></p>
						<p>Description:</p>
					</div>
					</div>
					<div class="col">
						<!--Carousel Wrapper-->
						<div id="carousel-example-1z" class="carousel slide carousel-fade" data-ride="carousel">
						  <!--Indicators-->
						  <ol class="carousel-indicators">
							<li data-target="#carousel-example-1z" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-1z" data-slide-to="1"></li>
							<li data-target="#carousel-example-1z" data-slide-to="2"></li>
						  </ol>
						  <!--/.Indicators-->
						  <!--Slides-->
						  <div class="carousel-inner post-img middle" role="listbox">
							<!--First slide-->
							<div class="carousel-item active">
							  <img class="d-block w-100" src="<?php if($data['photo1'] != NULL) echo $data['photo1']; else {?> img/no-photo.png <?php } ?>" alt="First slide">
							</div>
							<!--/First slide-->
							<!--Second slide-->
							<div class="carousel-item">
							  <img class="d-block w-100" src="<?php if($data['photo2'] != NULL) echo $data['photo2']; else {?> img/no-photo.png <?php } ?>" alt="Second slide">
							</div>
							<!--/Second slide-->
							<!--Third slide-->
							<div class="carousel-item">
							  <img class="d-block w-100" src="<?php if($data['photo3'] != NULL) echo $data['photo3']; else {?> img/no-photo.png <?php } ?>" alt="Third slide">
							</div>
							<!--/Third slide-->
						  </div>
						  <!--/.Slides-->
						  <!--Controls-->
						  <a class="carousel-control-prev" href="#carousel-example-1z" role="button" data-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="sr-only">Previous</span>
						  </a>
						  <a class="carousel-control-next" href="#carousel-example-1z" role="button" data-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="sr-only">Next</span>
						  </a>
						  <!--/.Controls-->
						</div>
						<!--/.Carousel Wrapper-->
						<a href="http://localhost/profile.php?hash=<?php echo $data['uhash']; ?>"><p>Added by: <?php echo $data['added_by'] ?></p></a>
					</div>
				</div>
				<div class="row pad-left offset-2">
					<p class="text-left"><?php echo $data['description'] ?></p>
				</div>
			</div>
	</div>
  </div>  
 </div>
 
 <div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
          <img src="" class="enlargeImageModalSource" style="width: 100%;">
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
   <script type="text/javascript" src="js/script.js"></script>
</body>

</html>
