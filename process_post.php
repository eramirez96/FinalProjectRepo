<?php
/*
    Assignment 4 PHP and Database
    Author: Elijah Ramirez
    Date: February, 10, 2020
    Purpost: To use user input, storing them into a database and to manipulate them for display.
*/
  require 'connection.php';

  $car_name = filter_input(INPUT_POST, 'car_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $car_type = filter_input(INPUT_POST, 'car_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $invalid = false;

  if (!filter_input(INPUT_POST, 'car_price', FILTER_VALIDATE_INT)) {
    $invalid = true;
  }
  else {
    $car_price = filter_input(INPUT_POST, 'car_price', FILTER_VALIDATE_INT);
  }

  if (strlen($car_name) < 1) {
  	$invalid = true;
  }

  if (isset($_POST['command']) && !isset($_POST['ModelID']) && $invalid == false) {
	$query     = "INSERT INTO vehicle (Name, Type, BasePrice) values (:car_name, :car_type, :car_price)";
	$statement = $db->prepare($query);
	$statement->bindValue(':car_name', $car_name);        
  $statement->bindValue(':car_type', $car_type);
  $statement->bindValue(':car_price', $car_price);
	$statement->execute();

	header("Location: http://localhost:31337/Final_Project/index.html");
    exit;
  }


  if (isset($_POST['updatecommand'])) {
  	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

  	$query     = "UPDATE vehicle SET Name = :car_name, Type = :car_type, BasePrice = :car_price WHERE ModelID = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':car_name', $car_name);        
    $statement->bindValue(':car_type', $car_type);
    $statement->bindValue(':car_price', $car_price);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: http://localhost:31337/Final_Project/employee.php");
    exit;
  }

  if (isset($_POST['deletecommand'])) {
  	$id = filter_input(INPUT_POST, 'ModelID', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM vehicle WHERE ModelID = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: http://localhost:31337/Final_Project/index.html");
    exit;
  }

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
    </ul>
    </nav>
  </div>
<h1>An error occured while processing your input.</h1>
  <?php if ($invalid == true): ?>
      <p>Invalid Input.</p>
  <?php endif ?>
<a href="index.html">Return Home</a>
</body>
</html>