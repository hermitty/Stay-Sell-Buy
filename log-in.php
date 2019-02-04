<?php
//require 'header.php';
//close connection
session_start();

if($_SESSION['logged_in'] == true)header("Location: index.php");
require 'connect.php';
if(isset($_POST["submit_btn"])){
	print_r($_POST);
	//$Password = 1;
	$email = trim($_POST[Email]);
	$password = trim($_POST[Password]);
	if(!empty($email) && !empty($password))
	{
		
		$sql_query = "SELECT login, email, password FROM website.user ";
		$sql_query .= "where (login = '$email' or email = '$email');";
		//$sql_query .= "(SELECT count(*) from website.user where login = '$email' or email = '$email') =1;";
		$run_query = mysqli_query($connection, $sql_query);
		$data=mysqli_fetch_assoc($run_query);
		
		if($data['login'] != $email && $data['email'] != $email)$errors['nologin'] = 'No user with this name. Try again.';
		else if($data['password'] != $password)$errors['wrongpass'] = 'Wrong password';
		else
		{
			$sql_query = "SELECT iduser, login, email, firstname, lastname, gender, status, type, hash ";
			$sql_query .= "FROM website.user where login = '$email' or email = '$email';";
			$run_query = mysqli_query($connection, $sql_query);
			$data=mysqli_fetch_assoc($run_query);
			$_SESSION['id'] = $data['iduser'];
			$_SESSION['login'] = $data['login'];
			$_SESSION['email'] = $data['email'];
			$_SESSION['firstaname'] = $data['firstname'];
			$_SESSION['lastname'] = $data['lastname'];
			$_SESSION['gender'] = $data['gender'];
			$_SESSION['status'] = $data['status'];
			$_SESSION['type'] = $data['type'];
			$_SESSION['hash'] = $data['hash'];
			$_SESSION['logged_in'] = true;
			
			//session_unset();
			//session_destroy();
			//print_r($_SESSION);
			mysqli_close($sonnection);
			if($_SESSION['logged_in'] == true && !empty($_SESSION['url']))
			{
				$url = $_SESSION['url'];
				$_SESSION['url'] = NULL;
				header("Location: $url");
			}
			else header("Location: profile.php");
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

			<p class="h3 mb-3">Log in</p>

			<!-- Email -->
			<input type="text" name="Email" id="" class="form-control inp" placeholder="E-mail" value="<?php echo $email ?>">
			<?php if(empty($email)){?>
			<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
		
			<!-- Password -->
			<input type="password" name="Password" id="LoginFormPassword" class="form-control inp" placeholder="Password">
			<?php if(empty($password)){?>
			<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
			<?php if(empty(!$errors['nologin'])){?>
			<small id="WrongInput" class="form-text err"><?php echo $errors['nologin'] ?> </small><?php } ?>
			<?php if(empty(!$errors['wrongpass'])){?>
			<small id="WrongInput" class="form-text err"><?php echo $errors['wrongpass'] ?> </small><?php } ?>
			

			<!-- Sign in button -->
			<button name="submit_btn" class="btn btn-info btn-block my-4 ripe-malinka-gradient" type="submit">Log in</button>

			<!-- Register -->
			<p><a href="create-account.php">
				Not a member?
				Create account!</a>
			</p>
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
