<!-------f--------

    Final Project
    Name: Elijah Ramirez
    Date: December 4, 2019
    Description: Final Project

----------------->
<?php
  require 'connection.php';

	//user login check
	$query = "SELECT * FROM vehicle_user";
	$statement = $db->prepare($query); // Returns a PDOStatement object.
	$statement->execute(); // The query is now executed.
	$usernames= $statement->fetchAll();

	session_start();

	$logged_in = false;

	foreach ($usernames as $username) {
	if (isset($_SESSION['uname']) || isset($_SESSION['uname1'])){
	    $logged_in = true;
	}
	else { 
	  if (isset($_POST['reglogin'])) {
	    if ($_POST['reguname']==$username['username'] && $_POST['regpwd']==$username['password'] && $username['permission']== 0) {
	      $_SESSION['uname'] = 'set';
	      $logged_in = true;
	      echo "<script>alert('Welcome!')</script>";
	    }
	    elseif ($_POST['reguname']==$username['username'] && $_POST['regpwd']==$username['password'] && $username['permission']== 1) {
	      $_SESSION['uname1'] = 'set';
	      $logged_in = true;
	      echo "<script>alert('Welcome!')</script>";
	    }
	    else {
	      $logged_in = false;
	    }
	  }
	  else {
	    header("Location: http://localhost:31337/Final_Project/authenticate.php");
	  }   
	}
	}
	if (!$logged_in) {
		header("refresh:1;url=authenticate.php");
        echo "<script>alert('Invalid username or password!')</script>";
        exit;
	}

	$query = "SELECT * FROM vehicle ORDER BY ModelID ASC LIMIT 20";
	$statement = $db->prepare($query); // Returns a PDOStatement object.
	$statement->execute(); // The query is now executed.
	$cars= $statement->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Electric Motors Inc.</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Arimo&display=swap" rel="stylesheet"> 
</head>
<body>
	<header>
		<h1>Electric Motors</h1>
	</header>
	<div id="navigation">
		<nav>
		<ul>
			<li><a href="index.php">HOME</a></li>
			<li><a href="products.php">PRODUCTS</a></li>
			<li><a href="contact.php">CONTACT US</a></li>
			<li><a href="employee.php">EMPLOYEE SITE</a></li>
			<li><a href="register.php">REGISTER</a></li>
			<?php if (isset($_SESSION['uname']) || isset($_SESSION['uname1'])): ?>
				<li><a href="logout.php">LOG OUT</a></li>
			<?php endif ?>
		</ul>
		</nav>
	</div>
	<h2>Product Line:</h2>
	<div>
      	<?php foreach($cars as $car): ?>
      		<div>
      		<h4>Model ID: <?=$car['ModelID']?></h4>
      		<p>Name: <?=$car['Name']?></p>
      		<p>Type: <?=$car['Type']?></p>
      		<?php if (!empty($car['img'])): ?>
      			<img src="uploads/<?= $car['img'] ?>" alt="" />
      		<?php endif ?>
      		<p>Starts From: <?=$car['BasePrice']?></p>
      		<h4>Product Reviews</h4>
      		</div>
      	<?php endforeach?>
	</div>
</body>
</html>