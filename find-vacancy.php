<?php
//require 'header.php';
session_start();

if(isset($_POST["rm_vacancy_btn"])){
	$_SESSION['to_remove'] = $_POST["rm_vacancy_btn"];
	header("Location: remove-vacancy.php");
}
if(isset($_POST["ed_vacancy_btn"])){
	$_SESSION['to_edit'] = $_POST["ed_vacancy_btn"];
	header("Location: edit-vacancy.php");
}
				
require 'connect.php';
if(isset($_POST["submit_btn"])){
	//print_r($_POST);
	$sql_query = "SELECT title, category, price, description, contact, user.hash as uhash, vacancy.hash as phash, login as added_by, photo1, photo2, photo3 ";
	$sql_query .= "FROM website.vacancy, website.user ";
	$sql_query .= "where user.iduser = vacancy.added_by ";
	$first = 1;
	if($_POST["Room"]) 
	{
		if($first == 1)
		{
			$first = 0;
			$sql_query .= " and ("; 
		} else $sql_query .= " or "; 
		$sql_query .= " category = 'Room' ";
	}
	if($_POST["Apartment"]) 
	{
		if($first == 1)
		{
			$first = 0;
			$sql_query .= " and ("; 
		} else $sql_query .= " or "; 
		$sql_query .= " category = 'Apartment' ";
	}
	if($_POST["Studio"]) 
	{
		if($first == 1)
		{
			$first = 0;
			$sql_query .= " and ("; 
		} else $sql_query .= " or "; 
		$sql_query .= " category = 'Studio' ";
	}
	if($_POST["Other"]) 
	{
		if($first == 1)
		{
			$first = 0;
			$sql_query .= " and ("; 
		} else $sql_query .= " or "; 
		$sql_query .= " category = 'Other' ";
	}
	if($first == 0)$sql_query .= ")";
		
	$sql_query .= " ORDER BY date desc ";
	$run_query = mysqli_query($connection, $sql_query);
}
else
{
	$sql_query = "SELECT title, category, price, description, contact, user.hash as uhash, vacancy.hash as phash, login as added_by, photo1, photo2, photo3 ";
	$sql_query .= "FROM website.vacancy, website.user ";
	$sql_query .= "where user.iduser = vacancy.added_by ";
	$sql_query .= "ORDER BY date desc ";
	$run_query = mysqli_query($connection, $sql_query);
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
 <div class="animated fadeIn ">
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
		<div class="col-3  ">
			<div class="pad pad-left border-right h80 padper" style="position:fixed">
			<form method="post">
				<div class="pad custom-control custom-checkbox">
					<input name="checkAll" type="checkbox" class="custom-control-input" id="checkAll">
					<label class="custom-control-label" for="checkAll">All</label>
				</div>
				<div class="custom-control custom-checkbox">
					<input name="Room" type="checkbox" class="custom-control-input" <?php if($_POST['Room'] != NULL) echo checked ?> id="room">
					<label class="custom-control-label" for="room">Room</label>
				</div>
				<div class="custom-control custom-checkbox">
					<input name="Apartment" type="checkbox" class="custom-control-input"  <?php if($_POST['Apartment'] != NULL) echo checked ?> id="apartmet">
					<label class="custom-control-label" for="apartmet">Apartment</label>
				</div>
				<div class="custom-control custom-checkbox">
					<input name="Studio" type="checkbox" class="custom-control-input" <?php if($_POST['Studio'] != NULL) echo checked ?> id="studio">
					<label class="custom-control-label" for="studio">Studio</label>
				</div>
				<div class="custom-control custom-checkbox">
					<input name="Other" type="checkbox" class="custom-control-input" <?php if($_POST['Other'] != NULL) echo checked ?> id="other">
					<label class="custom-control-label" for="other">Other</label>
				</div>
				<div>
					<button name="submit_btn" class="btn ripe-malinka-gradient" type="submit">Search</button>
				</div>
			</form>	
			</div>
		</div>
		<div class="col-9">
		
		<?php while($data=mysqli_fetch_assoc($run_query)){;?>
	
			<div class="box border-bottom">
				
				<div class="row text-centre">
					<div class="col ">
						<a  href="http://localhost/vacancy.php?hash=<?php echo $data['phash']; ?>"><h3 ><?php echo $data['title']; ?> </h3></a>
					</div>
				</div>
				<div class="row ">
				<div class="col ">
					<div class="bottom pad-left offset-2">
						<p>Price: <?php echo $data['price']; ?></p>
						<p>Contact: <?php echo $data['contact']; ?></p>
						<p>Category: <?php echo $data['category'];?></p>
						<p>Description: </p>
						
					</div>
				</div>
				<div class="col text-centre">
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
					<a  href="http://localhost/profile.php?hash=<?php echo $data['uhash']; ?>"> added by <?php echo $data['added_by'];?> </a>
				</div>
				</div>
				<div class="row">
					<div class="col pad-left offset-1">
					<p><?php echo $data['description'];?></p>
					</div>
				</div><?php if( $_SESSION['logged_in'] == true && $_SESSION['type'] == 0) {?>
				<div class="row h30">
					
					<div class="col-2 offset-4"><form method="post">
							<button name="rm_vacancy_btn" value="<?php echo $data['phash'] ?>" class="btn but-pad vertical-center sunny-morning-gradient" type="submit">Remove</button>
						</form></div>
						<div class="col-2 "><form method="post">
							<button name="ed_vacancy_btn" value="<?php echo $data['phash'] ?>" class="btn but-pad vertical-center sunny-morning-gradient" type="submit">Edit</button>
						</form></div>
				</div><?php } ?>
		</div> <?php } ?>
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
