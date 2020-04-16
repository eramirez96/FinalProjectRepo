<?php
  require 'connection.php';

    session_start();

    $id = $_GET['ModelID'];

    $query = "SELECT * FROM vehicle WHERE ModelID = {$_GET['ModelID']}";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $cars= $statement->fetchAll();

    $query = "SELECT * FROM vehicle_comments WHERE commentID = {$_GET['ModelID']} ORDER BY commentDate DESC";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $comments= $statement->fetchAll();
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
      <li><a href="index.php">HOME</a></li>
      <li><a href="products.php">PRODUCTS</a></li>
      <li><a href="contact.php">CONTACT US</a></li>
      <li><a href="employee.php">EMPLOYEE SITE</a></li>
      <li><a href="register.php">REGISTER</a></li>
      <?php if (isset($_SESSION['uname']) || isset($_SESSION['uname1'])): ?>
        <li><a href="logout.php">LOG OUT</a></li>
      <?php endif ?>    </ul>
    </nav>
  </div>
  <div>
  <?php foreach($cars as $car): ?>
  <p>Model ID: <?=$car['ModelID']?></p>
  <p>Car Name: <?=$car['Name']?></p>
  <?php endforeach ?>
  <form action="process_post.php" method="post">
    <fieldset>
      <legend>Add A Review: </legend>
      <p>
        <label for="car_title">Title: </label>
        <input name="car_title" id="car_title" />
      </p>
      <p>
        <label for="car_review">Comment: </label>
        <textarea id="car_review" name="car_review" rows="8" cols="50"></textarea>
      </p>
      <p>
        <input type="hidden" name="id" value="<?=$car['ModelID']?>" />
        <input type="submit" name="commentcommand" value="Add Review" />
      </p>
    </fieldset>
  </form>
  <div>
  	<h2>Past Reviews: </h2>
  	<?php foreach ($comments as $comment): ?>
  		<h3><?= $comment['title'] ?></h3>
  		<p><?= $comment['comment'] ?></p>
  		<h5>Reviewed on: <?= $comment['commentDate'] ?></h5>
  	<?php endforeach ?>
  </div>
</div>
  </body>
  </html>