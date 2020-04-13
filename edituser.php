<?php
/*
    Assignment 4 PHP and Database
    Author: Elijah Ramirez
    Date: February, 10, 2020
    Purpost: To use user input, storing them into a database and to manipulate them for display.
*/
  require 'connection.php';

    $id = $_GET['UserID'];

    $query = "SELECT * FROM vehicle_user WHERE UserID = {$_GET['UserID']}";
    $statement = $db->prepare($query); // Returns a PDOStatement object.
    $statement->execute(); // The query is now executed.
    $users= $statement->fetchAll();
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
<div id="all_blogs">
  <form action="process_post.php" method="post">
    <fieldset>
      <legend>Edit User Information</legend>
      <?php foreach($users as $user): ?>
      <p>User ID: <?=$user['UserID']?></p>
      <p>
        <label for="user_name">Username: </label>
        <input name="user_name" id="user_name" value="<?=$user['username']?>" />
      </p>
      <p>
        <label for="user_password">Password: </label>
        <input type="password" name="user_password" id="user_password" value="<?=$user['password']?>" />
      </p>
      <p>
        <label for="permission_type">Permission Type: </label>
        <select name= "permission_type" id="permission_type">
          <option value="0">Admin (0)</option>
          <option value="1">Regular User (1)</option>
        </select>
      </p>
      <?php endforeach ?>
      <p>
        <input type="hidden" name="id" value="<?=$user['UserID']?>" />
        <input type="submit" name="userupdatecommand" value="Update" />
        <input type="submit" name="userdeletecommand" value="Delete" />
      </p>
    </fieldset>
  </form>
</div>
</body>
</html>
