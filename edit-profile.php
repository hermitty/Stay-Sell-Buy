<?php
//require 'header.php';
//to do: 
//close connection
//connect
session_start();
//$_SESSION['to_edit'] = 'e744f91c29ec99f0e662c9177946c627'; ///to remove
//UPDATE `website`.`user` SET `email` = 'sari@hotil.com', `firstname` = 'Sarh', `lastname` = 'Metin', `gender` = 'femle' WHERE (`iduser` = '7');

require 'connect.php';
$uhash = $_SESSION['to_edit'];
$sql_query = "SELECT * FROM website.user where user.hash = '$uhash';";
$run_query = mysqli_query($connection, $sql_query);
$data=mysqli_fetch_assoc($run_query);

$firstName = $data['firstname'];
$lastName = $data['lastname'];
$gender = $data['gender'];
$email = $data['email'];


if(isset($_POST["submit_btn"])){
	print_r($_POST);
	$firstName = trim($_POST[firstName]);
	$lastName = trim($_POST[lastName]);
	$gender = trim($_POST[Gender]);
	$login = trim($_POST[login]);
	$email = trim($_POST[email]);
	
	if(!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($email))
	{
		
			$go = 1;
			
			//check email
			$sql_query = "SELECT count(*) AS 'count' FROM website.user where user.email = '$email' and user.hash != '$uhash'";
			$run_query = mysqli_query($connection, $sql_query);
			$data=mysqli_fetch_assoc($run_query);
			//echo $data['count'];
			if($data['count'] == 0) $go2 = 1;
			else 
			{
				$go = 0;
				$errors['dubemail'] = 'Account with this email exists. Please choose a different address.';
				//errors['dub_login'] = 'An account with this ogin exists. Please choose other name.';
			}
			if($go == 1 && $go2 == 1)
			{
				$success = 'The form was successfully submitted.';
				echo 'succ';
			}
			
		
	}
	else
	{
		if(empty($gender))
		{
			$errors['gender_err'] = 'Please select your gender.';
		}
		$errors['main'] = 'Field is empty.';
	}
	if($success)
	{
		$hash =  md5 (rand(0,1000));
		//inster to database
		$sql_query = "UPDATE `website`.`user` SET `email` = '$email', `firstname` = '$firstName', `lastname` = '$lastName', `gender` = '$gender' WHERE (`hash` = '$uhash');";
		//$sql_query .= "VALUES('$login', '$email', '$password', '$hash', '$firstName', '$lastName', '$gender', 'active', 1);";
		//$sql_query .= '';
		
		$run_query = mysqli_query($connection, $sql_query);
		mysqli_close($sonnection);
		$_SESSION['to_edit'] = NULL;
		$_SESSION['message'] = "Profile was successfully edited";
		header("Location: success.php"); 
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
		<a href="profile.php"><button type="button" class="btn btn-outline-default waves-effect log_button"><?php echo $_SESSION['login'] ; ?> <i class="fa fa-user mr-2"aria-hidden="true"></i></button></a>
		<a href="logout.php"><button type="button" class="btn btn-outline-info waves-effect log_button">log out <i class="fa fa-rocket" aria-hidden="true"></i></button></a>
		<?php } ?>
	</div>
  </div>
  <!-- Header -->
  <div class="main_buttons">
	<div class="row">
	
	<!-- Default form register -->
	<form method="post" class="text-center border border-light p-5 centre">

		<p class="h4 mb-4">Edit profile</p>

		<div class="form-row">
			<div class="col">
				<!-- First name -->
				<input name="firstName" type="text" id="RegisterFormFirstName" class="form-control" value="<?php echo $firstName ?>" placeholder="First name">
				<?php if(empty($firstName)){?>
				<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
			</div>
			
			<div class="col">
				<!-- Last name -->
				<input name="lastName" type="text" id="RegisterFormLastName" class="form-control" value="<?php echo $lastName ?>" placeholder="Last name">
				<?php if(empty($lastName)){?>
				<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
			</div>
		</div>
		
		<!-- Gender -->
		<div class="form-row">
			<!-- Female -->
			<div class="custom-control custom-radio inp col">
			  <input type="radio" class="custom-control-input text-right" id="defaultUnchecked" name="Gender" value="female" <?php if($gender == 'female')echo 'checked' ?>>
			  <label class="custom-control-label" for="defaultUnchecked">Female</label>
			</div>

			<!-- Male -->
			<div class="custom-control custom-radio inp col">
			  <input type="radio" class="custom-control-input text-left" id="defaultChecked" name="Gender" value="male" <?php if($gender == 'male')echo 'checked' ?>>
			  <label class="custom-control-label" for="defaultChecked">Male</label>
			</div>
		</div>
		<?php if(empty($login)){?>
		<small id="WrongInput" class="form-text err"><?php echo $errors[gender_err] ?> </small><?php } ?>
		
		<!-- E-mail -->
		<input name="email" type="email" id="RegisterFormEmail" class="form-control inp" value="<?php echo $email ?>" placeholder="E-mail">
		<?php if(empty($email)){?>
		<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
		<?php if($go2 == 0){?>
		<small id="WrongInput" class="form-text err"><?php echo $errors[dubemail] ?> </small><?php } ?>

		
		<!-- Sign up button -->
		<button name="submit_btn" class="btn btn-info my-4 btn-block ripe-malinka-gradient" type="submit">Submit</button>
		
		<!-- Wrong input -->
		<small id="WrongInput" class="form-text text-muted mb-4">		
		</small>

	</form>
	<!-- Default form register -->
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
