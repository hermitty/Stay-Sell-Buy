<?php
//require 'header.php';
//ctype_alpha($name);
// to do: chane in sell if cond with select category
session_start();
require 'connect.php';

//$_SESSION['to_edit'] = '168908dd3227b8358eababa07fcaf091'; ///to remove

//UPDATE `website`.`vacancy` SET `title` = 'ddd', `category` = 'ss', `description` = 'fghddjk', `price` = 'ee', `contact` = 'fghjeek' WHERE (`idvacancy` = '23');
require 'connect.php';
$phash = $_SESSION['to_edit'];
$sql_query = "SELECT * FROM website.vacancy where vacancy.hash = '$phash';";
$run_query = mysqli_query($connection, $sql_query);
$data=mysqli_fetch_assoc($run_query);

$select = $data['category'];
$title = $data['title'];
$description = $data['description'];
$price = $data['price'];
$contact = $data['contact'];
$image1 = $data['photo1'];
$image2 = $data['photo2'];
$image3 = $data['photo3'];

if(isset($_POST["submit_btn"])){
	$errors = array();
	print_r($_POST);
	$select = trim($_POST[Select]);
	$title = trim($_POST[Title]);
	$description = trim($_POST[Desription]);
	$price = trim($_POST[Price]);
	$contact = trim($_POST[Contact]);
	$image1 = trim($_POST[Image1]);
	$image2 = trim($_POST[Image2]);
	$image3 = trim($_POST[Image3]);
	if($select != 'Category' && !empty($title) && !empty($description) && !empty($price) && !empty($contact))
	{
		
		$sql_query = "UPDATE `website`.`vacancy` SET `title` = '$title', `category` = '$select', `description` = '$description', `price` = '$price', `contact` = '$contact' WHERE (`hash` = '$phash');";
		
		//$sql_query .= '';
		
		$run_query = mysqli_query($connection, $sql_query);
		//mysqli_close($sonnection);
		echo 'succ';
		$_SESSION['to_edit'] = NULL;
		$_SESSION['message'] = "Vacancy was successfully edited";
		header("Location: success.php");
	}
	else
	{
		$errors['main'] = 'Field is empty.';
		$errors['select'] = 'Category is not selected.';
		
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
	<!-- Form register -->
	<form method="post" class="text-center border border-light p-4 centre" style="width:43%">

		<p class="h4 mb-4" >Edit vacancy</p>	
		
		<!-- Category -->
		<div><select name="Select" class="browser-default custom-select">
		  <option selected><?php echo $select ?></option>
		  <option value="Room">Room</option>
		  <option value="Apartment">Apartment</option>
		  <option value="Studio">Studio</option>
		  <option value="Other">Other</option>
		</select></div>
		
		<!-- Wrong input -->
		<?php if($select == 'Category'){?>
		<small class="form-text err"><?php echo $errors[select] ?> </small><?php }?> 

		<!-- Title -->
		<div><input type="text" name="Title" id="AddVacancyTitle" class="form-control inp" placeholder="Title" value="<?php echo $title ?>"></div>
		
		<!-- Wrong input -->
		<?php if(empty($title)){?>
		<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
		
		<div class=" inp">
			<textarea class="form-control rounded-1" name="Desription" id="AddVacancyDesription" rows="5" placeholder="Description"><?php echo $description ?></textarea>
		</div>
		
		<!-- Wrong input -->
		<?php if(empty($description)){?>
		<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>

		<!-- Price -->
		<div><input type="text" name="Price" id="AddVacancyPrice" class="form-control inp" placeholder="Price" value="<?php echo $price ?>"></div>
		
		<!-- Wrong input -->
		<?php if(empty($price)){?>
		<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
		
		<!-- Contact -->
		<div><input type="text inp" name="Contact" id="AddVacancyContact" class="form-control inp" placeholder="Contact" value="<?php echo $contact ?>"></div>
		
		<!-- Wrong input -->
		<?php if(empty($contact)){?>
		<small id="WrongInput" class="form-text err"><?php echo $errors[main] ?> </small><?php } ?>
		
		<!-- File input -->
		<div class="input-group inp">
		  <div class="custom-file">
			<input type="file" accept="image/*" class="custom-file-input" name="Image1" id="AddVacancyImage1" value="<?php echo $image1 ?>" aria-describedby="inputGroupFileAddon01">
			<label class="custom-file-label" for="inputGroupFile01">Choose image</label>
		  </div>
		</div>
		<div class="input-group">
		  <div class="custom-file">
			<input type="file" accept="image/*" class="custom-file-input" name="Image2" id="AddVacancyImage2" value="<?php echo $image2 ?>" aria-describedby="inputGroupFileAddon01">
			<label class="custom-file-label" for="inputGroupFile01">Choose image</label>
		  </div>
		</div>
		<div class="input-group">
		  <div class="custom-file">
			<input type="file" accept="image/*" class="custom-file-input" name="Image3" id="AddVacancyImage3" value="<?php echo $image3 ?>" aria-describedby="inputGroupFileAddon01">
			<label class="custom-file-label" for="inputGroupFile01">Choose image</label>
		  </div>
		</div>
		
		<!-- Wrong input -->
		<?php if(isset($success)){?>
		<small id="WrongInput" class="mar form-text mb-4 succ"><?php echo $success ?> </small><?php } ?>
		
		<!-- Submit button -->
		<button name="submit_btn" class="btn btn-info my-4 btn-block ripe-malinka-gradient" type="submit">Submit</button>
		


	</form>
	<!-- Form register -->
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
