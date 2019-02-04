<?php
//require 'header.php';
//close connection
session_start();
//$_SESSION['to_remove'] = 'ad61ab143223efbc24c7d2583be69251';//to remove

if($_SESSION['to_remove'] == NULL)
{
	$_SESSION['message'] = "I do not know what to remove";
	header("Location: error.php");
}
if($_SESSION['type'] != 0 && $_SESSION['to_remove'] != $_SESSION['hash'])header("Location: index.php");
require 'connect.php';
if(isset($_POST["submit_btn"])){
	//print_r($_POST);
	$password = trim($_POST[Password]);
	if(!empty($password))
	{
		$login = $_SESSION['login'];
		$email = $_SESSION['email'];
		$sql_query = "SELECT password FROM website.user ";
		$sql_query .= "where (login = '$login' or email = '$email');";
		$run_query = mysqli_query($connection, $sql_query);
		$data=mysqli_fetch_assoc($run_query);
		
		if($data['password'] != $password)$errors['wrongpass'] = 'Wrong password';
		else
		{
			
			if($_SESSION['to_remove'] != NULL){
				$to_remove = $_SESSION['to_remove'];
				
				$sql_query = "SELECT iduser FROM website.user where user.hash = '$to_remove';";
				$run_query = mysqli_query($connection, $sql_query);
				$data=mysqli_fetch_assoc($run_query);
				$id = $data['iduser'];
				
				
				$sql_query = "DELETE FROM `website`.`user` WHERE (`iduser` = '$id');";
				$run_query = mysqli_query($connection, $sql_query);
				
				$sql_query = "DELETE FROM `website`.`vacancy` WHERE (`added_by` = '$id');";
				$run_query = mysqli_query($connection, $sql_query);
				
				$sql_query = "DELETE FROM `website`.`item` WHERE (`added_by` = '$id');";
				$run_query = mysqli_query($connection, $sql_query);
				
				$sql_query = "DELETE FROM `website`.`user` WHERE (`iduser` = '$id');";
				$run_query = mysqli_query($connection, $sql_query);
			
				mysqli_close($sonnection);
				
				$_SESSION['to_remove'] = NULL;
				if($to_remove == $_SESSION['hash']) header("Location: logout.php");
				else
				{
				$_SESSION['message'] = "The account was successfully removed";
				header("Location: success.php");
				}
			}
		}
	}
	else
	{
		$errors['main'] = 'Field is empty.';
	}
	
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
	<!-- form login -->
		<form method="post" class="text-center border border-light p-5 centre">

			<p class="h3 mb-3">Write password to remove profile</p>

		
			<!-- Password -->
			<input type="password" name="Password" id="LoginFormPassword" class="form-control inp" placeholder="Password">
			<?php if(empty($password)){?>
			<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
			<?php if(empty(!$errors['wrongpass'])){?>
			<small id="WrongInput" class="form-text err"><?php echo $errors['wrongpass'] ?> </small><?php } ?>

			<!-- Sign in button -->
			<button name="submit_btn" class="btn btn-info btn-block my-4 ripe-malinka-gradient" type="submit">Submit</button>
		</form>
<!-- Default form login -->
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
