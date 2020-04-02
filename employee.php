<?php

  require 'authenticate.php';
  require 'connection.php';

    $query = "SELECT * FROM vehicle ORDER BY ModelID DESC LIMIT 10";
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
		</ul>
		</nav>
	</div>
<div id="all_blogs">
  <form action="process_post.php" method="post">
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
        <input type="submit" name="command" value="Create" />
      </p>
      <div id="car_data">
      <h2>Available Cars:</h2>
      	<?php foreach($cars as $car): ?>
      		<div>
      		<h4><a href="edit.php?ModelID=<?=$car['ModelID']?>">Model ID: <?=$car['ModelID']?></a></h4>
      		<p>Name: <?=$car['Name']?></p>
      		<p>Starts From: <?=$car['BasePrice']?></p>
      		</div>
      	<?php endforeach?>
      </div>
    </fieldset>
  </form>
</div>
</html>