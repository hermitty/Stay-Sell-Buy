<?php
//require 'header.php';
//ctype_alpha($name);
// to do: chane in sell if cond with select category
session_start();
require 'connect.php';
//direct to log in
if($_SESSION['logged_in'] != true)
{
	$_SESSION['url'] = 'add-vacancy.php'; // <- change in other page
	header("Location: log-in.php");
}
if($_SESSION['logged_in'] == true && $_SESSION['type'] == 0)
	{
	$_SESSION['message'] = 'You are admin. You cannot add posts'; // <- change in other page
	header("Location: error.php");
}

$select = 'Category';
//check post variables
if(isset($_POST["submit_btn"])){
	$errors = array();
	//print_r($_POST);
	$select = trim($_POST[Select]);
	$title = trim($_POST[Title]);
	$description = trim($_POST[Desription]);
	$price = trim($_POST[Price]);
	$contact = trim($_POST[Contact]);
	//print_r($_FILES);
	$image1 = NULL;
	$image2 = NULL;
	$image3 = NULL;
	
	if($_FILES["file1"]["name"] != '')
	{
		move_uploaded_file($_FILES['file1']['tmp_name'], "img/vacancy/{$_FILES['file1']['name']}");
		$image1 = "img/vacancy/";
		$image1 .= "{$_FILES['file1']['name']}";
	}
	if($_FILES["file2"]["name"] != '')
	{
		move_uploaded_file($_FILES['file2']['tmp_name'], "img/vacancy/{$_FILES['file2']['name']}");
		$image2 = "img/vacancy/";
		$image2 .= "{$_FILES['file2']['name']}";
	}
	if($_FILES["file3"]["name"] != '')
	{
		move_uploaded_file($_FILES['file3']['tmp_name'], "img/vacancy/{$_FILES['file3']['name']}");
		$image3 = "img/vacancy/";
		$image3 .= "{$_FILES['file3']['name']}";
	}


	
	if($select != 'Category' && !empty($title) && !empty($description) && !empty($price) && !empty($contact))
	{
		//if all field filled
		$success = 'The form was successfully submitted.';
		
		$hash =  md5 (rand(0,1000));
		//instert to database
		$id = $_SESSION['id'];
		$sql_query = "INSERT INTO `website`.`vacancy` (`title`, `category`, `description`, `price`, `contact`, `added_by`, `date`, `status`, `hash`, `photo1`, `photo2`, `photo3`)";
		$sql_query .= " VALUES('$title','$select','$description','$price','$contact',$id,NOW(),'active', '$hash', '$image1', '$image2', '$image3');";
		//$sql_query .= '';
		
		echo $sql_query;
		$run_query = mysqli_query($connection, $sql_query);
		//mysqli_close($sonnection);
		header("Location: vacancy.php?hash=".$hash);
		//echo 'succ';
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
	<form method="post" enctype="multipart/form-data" class="text-center border border-light p-4 centre" style="width:43%">

		<p class="h4 mb-4" >Add vacancy</p>	
		
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
		<div class="input-default-wrapper">
		  <input value="<?php echo $image1 ?>" type="file" accept="image/*"  id="file-with-current1" name="file1" class="input-default-js">
		  <label class="label-for-default-js rounded-right" for="file-with-current1"><span class="span-choose-file">Choose
			  image</span>
			<div class="float-right span-browse">Browse</div>
		  </label>
		</div>
		
		<div class="input-default-wrapper">
		  <input value="<?php echo $image2 ?>" type="file" accept="image/*"  id="file-with-current2" name="file2" class="input-default-js">
		  <label  class="label-for-default-js rounded-right" for="file-with-current2"><span class="span-choose-file">Choose
			  image</span>
			<div class="float-right span-browse">Browse</div>
		  </label>
		</div>
		
		<div class="input-default-wrapper">
		  <input value="<?php echo $image3 ?>" type="file" accept="image/*"  id="file-with-current3" name="file3" class="input-default-js">
		  <label class="label-for-default-js rounded-right" for="file-with-current3"><span class="span-choose-file">Choose
			  image</span>
			<div class="float-right span-browse">Browse</div>
		  </label>
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
