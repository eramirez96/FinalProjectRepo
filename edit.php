<?php
/*
    Assignment 4 PHP and Database
    Author: Elijah Ramirez
    Date: February, 10, 2020
    Purpost: To use user input, storing them into a database and to manipulate them for display.
*/
  require 'authenticate.php';
  require 'connection.php';

    $id = $_GET['ModelID'];

    $query = "SELECT * FROM vehicle WHERE ModelID = {$_GET['ModelID']}";
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
  <form action="process_post.php" method="post" enctype="multipart/form-data">
    <fieldset>
      <legend>Edit Car Information</legend>
      <?php foreach($cars as $car): ?>
      <p>Model ID: <?=$car['ModelID']?></p>
      <p>
        <label for="car_name">Car Name:</label>
        <input name="car_name" id="car_name" value="<?=$car['Name']?>" />
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
        <label for="car_price">Content</label>
        <input name="car_price" id="car_price" value="<?=$car['BasePrice']?>" />
      </p>
      <p>
        <label for="image">Upload an Image:</label>
        <input type='file' name='image' id='image'>
        <?php if (!empty($car['img'])): ?>
          <p>Current Image:</p>
          <img src="uploads/<?= $car['img'] ?>" alt="" />
         <?php endif ?>
      </p>
      <?php endforeach ?>
      <p>
        <input type="hidden" name="id" value="<?=$car['ModelID']?>" />
        <input type="hidden" name="current_image" value="<?=$car['img']?>" />
        <input type="submit" name="updatecommand" value="Update" />
        <input type="submit" name="deletecommand" value="Delete" onclick="return confirm('Are you sure you wish to delete this post?')" />
        <?php if (!empty($car['img'])): ?>
        <input type="submit" name="deletecommandimage" value="Delete Image" />
        <?php endif ?>
      </p>
    </fieldset>
  </form>
</div>
        <div id="footer">
            Copywrong 2020 - No Rights Reserved
        </div> <!-- END div id="footer" -->
    </div> <!-- END div id="wrapper" -->
</body>
</html>
