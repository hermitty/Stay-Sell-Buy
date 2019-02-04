<?php
//require 'header.php';
//ctype_alpha($name);
session_start();

				
if(isset($_POST["remove_profile_btn"])){
	$_SESSION['to_remove'] = $_POST["remove_profile_btn"];
	header("Location: remove-profile.php");
}
if(isset($_POST["edit_profile_btn"])){
	$_SESSION['to_edit'] = $_POST["edit_profile_btn"];
	header("Location: edit-profile.php");
}
if(isset($_POST["remove_vacancy_btn"])){
	$_SESSION['to_remove'] = $_POST["remove_vacancy_btn"];
	header("Location: remove-vacancy.php");
}		
if(isset($_POST["edit_vacancy_btn"])){
	$_SESSION['to_edit'] = $_POST["edit_vacancy_btn"];
	header("Location: edit-vacancy.php");
}
if(isset($_POST["remove_item_btn"])){
	$_SESSION['to_remove'] = $_POST["remove_item_btn"];
	header("Location: remove-item.php");
}
if(isset($_POST["edit_item_btn"])){
	$_SESSION['to_edit'] = $_POST["edit_item_btn"];
	header("Location: edit-item.php");
}
if(isset($_POST["remove_user_btn"])){
	$_SESSION['to_remove'] = $_POST["remove_user_btn"];
	header("Location: remove-profile.php");
}
if(isset($_POST["edit_user_btn"])){
	$_SESSION['to_edit'] = $_POST["edit_user_btn"];
	header("Location: edit-profile.php");
}

if($_SESSION['logged_in'])$logged = true;
require 'connect.php';

if(isset($_POST["submit_btn"])){
		
		if($_FILES["file"]["name"] != '')
		{
			move_uploaded_file($_FILES['file']['tmp_name'], "img/profile/{$_FILES['file']['name']}");
			$image = "img/profile/";
			$image .= "{$_FILES['file']['name']}";
			$id = $_SESSION['id'];
			
			$sql_query = "UPDATE `website`.`user` SET `photo` = '$image' WHERE (`iduser` = '$id');";
			$run_query = mysqli_query($connection, $sql_query);
		}
}


if(isset($_GET["hash"]) || $logged == true){
	if(isset($_GET["hash"])) $hash = $_GET["hash"];
	else $hash = $_SESSION['hash'];
	//$sql_query = "SELECT * from website.user ";
	//user
	$sql_query = "SELECT iduser, login, hash, firstname, lastname, gender, status, photo, email FROM website.user where hash = '$hash';";
	$run_query = mysqli_query($connection, $sql_query);
	$data=mysqli_fetch_assoc($run_query);
	$id = $data['iduser'];
	$login = $data['login'];
	$firstname = $data['firstname'];
	$lastname = $data['lastname'];
	$gender = $data['gender'];
	$status = $data['status'];
	$photo = $data['photo'];
	$email = $data['email'];
	
	
	//vacancy
	$sql_query = "SELECT vacancy.title, vacancy.hash as phash, vacancy.status as status, photo1 ";
	$sql_query .= "FROM website.vacancy, website.user ";
	$sql_query .= "where user.iduser = vacancy.added_by and added_by = '$id' ";
	$sql_query .= "ORDER BY date desc ";
	$run_query = mysqli_query($connection, $sql_query);
	
	if($hash == $_SESSION['hash'])$itsme = true;
	else $itsme = false;
	
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
  <div class="main_buttons">
	<div class="row">
	   <div class="box centre col-9 pad text-centre"> 
				<div class="row">
					<div class="col">
						<div class="">
							<div class="profile-img">
								<img src="<?php if($photo != NULL) echo $photo; else {?> img/profile.png <?php } ?>" alt=""/>	
								<?php if($itsme) { ?>
								<form  method="post" enctype="multipart/form-data">
									<div id="choose" class=" file btn btn-lg btn-primary">
									Choose photo
									<input type="file" name="file"  accept="image/*" id="image">
									</div> 
									<button name="submit_btn"  id="chosen" type="submit" value="Upload Image" class="file btn btn-lg btn-primary" >Submit</button>
								</form> <?php } ?>
							</div>
						</div>
						<p><?php echo $login ?></p>
					</div>
					<div class="col text-left">
					<div class="vertical-center">
					
						<p>Name: <?php echo $firstname ?></p>
						<p>Surname: <?php echo $lastname ?></p>
						<p>Gender: <?php echo $gender ?></p>
						<p>E-mail: <?php if($itsme) echo $email ?> </p>
					</div>
					</div>
					<div class="col-2">
						<form method="post" >
							<button name="remove_profile_btn" value="<?php echo $_SESSION['hash'] ?>" class="btn but-pad peach-gradient " type="submit">Remove profile</button>
						</form>
						<form method="post" >
							<button name="edit_profile_btn" value="<?php echo $_SESSION['hash'] ?>" class="btn but-pad young-passion-gradient" type="submit">Edit profile</button>
						</form>
						<?php if($_SESSION['logged_in'] == true && $_SESSION['type'] == 0){ ?>
						<a href="http://localhost/create-admin.php"><button class="btn but-pad warm-flame-gradient">Add admin account</button></a>
						<?php } ?>
					</div>
				</div>
				
				<?php if($_SESSION['type'] == 1 || ($_SESSION['type'] == 0 && $itsme != true)){ ?>
				<div class="row pad-left border-bottom">
					Posts: 
				</div>
				<?php 
				
				
				while($data=mysqli_fetch_assoc($run_query)){;?>
				<div class="row border-bottom">
				<div class="col-2">
					<img  class="imag" src="<?php if($data['photo1'] != NULL) echo $data['photo1']; else {?> img/no-photo.png <?php } ?>" alt=""/>
				</div>
				
				<div class="col">
					<h3 class="vertical-center"><a  href="http://localhost/vacancy.php?hash=<?php echo $data['phash']; ?>"> <?php echo $data['title'] ?> </a><h3>
				</div>
				<?php if($itsme || $_SESSION['type'] == 0) {?>
				<div class="col-2"><form method="post" >
					<button name="remove_vacancy_btn" value="<?php echo $data['phash'] ?>"  class="btn but-pad vertical-center ripe-malinka-gradient" type="submit">Remove</button>
				</form></div>
				
				
				<div class="col-1"><form method="post" >
					<button name="edit_vacancy_btn" value="<?php echo $data['phash'] ?>" class="btn but-pad vertical-center sunny-morning-gradient" type="submit">Edit</button>
				</form></div>
				
				<?php } ?>
				</div>
				<?php } ?>
				<?php 
				//item
				//echo 'a';
					$sql_query = "SELECT item.title, item.hash as phash, item.status as status, photo1 ";
					$sql_query .= "FROM website.item, website.user ";
					$sql_query .= "where user.iduser = item.added_by and added_by = '$id' ";
					$sql_query .= "ORDER BY date desc ";
					$run_query = mysqli_query($connection, $sql_query);
				
				while($data=mysqli_fetch_assoc($run_query)){?>
				<div class="row border-bottom">
				<div class="col-2">
					<img  class="imag" src="<?php if($data['photo1'] != NULL) echo $data['photo1']; else {?> img/no-photo.png <?php } ?>" alt=""/>
				</div>
				<div class="col">
					<h3 class="vertical-center"><a  href="http://localhost/item.php?hash=<?php echo $data['phash']; ?>"> <?php echo $data['title'] ?> </a><h3>
				</div>
				<?php if($itsme || $_SESSION['type'] == 0) {?>
				<div class="col-2"><form method="post" >
					<button name="remove_item_btn" value="<?php echo $data['phash'] ?>"  class="btn but-pad vertical-center ripe-malinka-gradient" type="submit">Remove</button>
				</form></div>
				
				<div class="col-1"><form method="post" >
					<button name="edit_item_btn" value="<?php echo $data['phash'] ?>"  class="btn but-pad vertical-center sunny-morning-gradient" type="submit">Edit</button>
				</form></div>
				<?php } ?>
				</div>
				<?php }} else if($itsme){ ?>
				
				<div class="row pad-left border-bottom">
					Users: 
				</div>
				<?php
				//users
					$sql_query = "SELECT login, firstname, lastname, hash as uhash, photo, type FROM website.user; ";
					
					$run_query = mysqli_query($connection, $sql_query);
				
				while($data=mysqli_fetch_assoc($run_query)){ ?>
				<div class="row border-bottom">
				<div class="col-2">
					<img  class="imag"src="<?php if($data['photo'] != NULL) echo $data['photo']; else {?> img/profile.png <?php } ?>" alt=""/>
				</div>
				
				<div class="col-2">
					<p class="vertical-center"><a  href="http://localhost/profile.php?hash=<?php echo $data['uhash']; ?>"> <?php echo $data['login'] ?> </a><p>
				</div>
				<div class="col">
					<p class="vertical-center"> <?php echo $data['firstname'].' '.$data['lastname'] ?> <p>
				</div>
				
				<div class="col-1">
					<p class="vertical-center"> <?php if($data['type'] == 1) echo 'user'; else echo 'admin'; ?> <p>
				</div>
				
				<div class="col-2"><form method="post" >
					<button name="remove_user_btn" value="<?php echo $data['uhash'] ?>"  class="btn but-pad vertical-center ripe-malinka-gradient" type="submit">Remove</button>
				</form></div>
				
				<div class="col-1"><form method="post" >
					<button name="edit_user_btn" value="<?php echo $data['uhash'] ?>" class="btn but-pad vertical-center sunny-morning-gradient" type="submit">Edit</button>
				</form></div>
				
				</div>
				
				
				
				<?php } }?>
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
