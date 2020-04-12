<?php

  $uname = 'admin';
  $pwd = 'admin';
  session_start();

  $logged_in = false;

  if (isset($_SESSION['uname'])){
      $logged_in = true;
  }
  else { 
  if (isset($_POST['login'])) {
    if ($_POST['uname']==$uname && $_POST['pwd']) {
      $_SESSION['uname'] = $uname;
      $logged_in = true;
      echo "<script>alert('Welcome!')</script>";
    }
    else {
    header("refresh:1;url=authenticate.php");
    echo "<script>alert('Invalid username or password!')</script>";
    exit;
    }
  }
  else {
      header("Location: http://localhost:31337/Final_Project/authenticate.php");
    }   
  }

  require 'connection.php';

  $car_sort = 'ModelID';

  if (filter_input(INPUT_POST, 'car_sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS) && isset($_POST['sortcommand'])) {
  	$car_sort = filter_input(INPUT_POST, 'car_sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  }

    $query = "SELECT * FROM vehicle ORDER BY $car_sort ASC LIMIT 20";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $cars= $statement->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
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
			<li><a href="index.html">HOME</a></li>
			<li><a href="products.html">PRODUCTS</a></li>
			<li><a href="contact.html">CONTACT US</a></li>
			<li><a href="employee.php">EMPLOYEE SITE</a></li>
      <li><a href="logout.php">LOG OUT</a></li>
		</ul>
		</nav>
	</div>
  <?php if ($logged_in = true): ?>
    <p>Logged in!</p>
  <?php endif ?>
<div id="all_blogs">
  <form action="process_post.php" method="post" enctype="multipart/form-data">
    <fieldset>
      <legend>Create a New Car</legend>
      <p>
        <label for="car_name">Car Name:</label>
        <input name="car_name" id="car_name" />
      </p>
      <p>
        <label for="car_type">Car Type:</label>
		<select name= "car_type" id="car_type">
		  <option value="minivan">Minivan</option>
		  <option value="sportscar">Sportscar</option>
		  <option value="compact">Compact</option>
		  <option value="truck">Truck</option>
		</select>
      </p>
      <p>
        <label for="car_price">Base Price:</label>
        <input name="car_price" id="car_price" />
      </p>
      <p>
      	<label for="image">Upload an Image:</label>
      	<input type='file' name='image' id='image'>
      </p>
      <p>
        <input type="submit" name="command" value="Create" />
      </p>
    </fieldset>
  </form>
  <form action="employee.php" method="post">
      <p>
      	<label for="car_sort">Sort By:</label>
		<select name= "car_sort" id="car_sort">
		  <option value="Name">Name</option>
		  <option value="BasePrice">BasePrice</option>
		  <option value="Type">Type</option>
		</select>
      </p>
      <p>
        <input type="submit" name="sortcommand" value="Sort" />
      </p>
      <div id="car_data">
      <h2>Available Cars:</h2>
      <h4>Sorted by: <?= $car_sort ?></h4>
      	<?php foreach($cars as $car): ?>
      		<div>
      		<h4><a href="edit.php?ModelID=<?=$car['ModelID']?>">Model ID: <?=$car['ModelID']?></a></h4>
      		<p>Name: <?=$car['Name']?></p>
      		<p>Type: <?=$car['Type']?></p>
      		<?php if (!empty($car['img'])): ?>
      			<img src="uploads/<?= $car['img'] ?>" alt="" />
      		<?php endif ?>
      		<p>Starts From: <?=$car['BasePrice']?></p>
      		</div>
      	<?php endforeach?>
      </div>
    </form>
</div>
</body>
</html>