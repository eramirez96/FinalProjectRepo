<?php
  require 'connection.php';

  session_start();

  //user login check
  $query = "SELECT * FROM vehicle_user";
  $statement = $db->prepare($query); // Returns a PDOStatement object.
  $statement->execute(); // The query is now executed.
  $usernames= $statement->fetchAll();
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
    <?php endif ?>
	</ul>
	</nav>
</div>
<form action="process_post.php" method="post">
<fieldset>
  <legend>Create a New User</legend>
  <p>
    <label for="user_email">E-mail: </label>
    <input type="email" name="user_email" id="user_email" />
  </p>
  <p>
    <label for="user_name">Username: </label>
    <input name="user_name" id="user_name" />
  </p>
  <p>
    <label for="user_password">Password: </label>
    <input type="password" name="user_password" id="user_password" />
  </p>
  <p>
    <label for="confirm_user_password">Confirm Password: </label>
    <input type="password" name="confirm_user_password" id="confirm_user_password" />
  </p>
  <p>
    <input type="hidden" name="permission_type" value="1" />
    <input type="submit" name="registerusercommand" value="Create" />
  </p>
</fieldset>
</form>
</body>
</html>