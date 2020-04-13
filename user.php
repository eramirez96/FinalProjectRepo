<?php
  require 'connection.php';

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
		<li><a href="index.html">HOME</a></li>
		<li><a href="products.html">PRODUCTS</a></li>
		<li><a href="contact.html">CONTACT US</a></li>
		<li><a href="employee.php">EMPLOYEE SITE</a></li>
  		<li><a href="logout.php">LOG OUT</a></li>
	</ul>
	</nav>
</div>
<form action="process_post.php" method="post">
<fieldset>
  <legend>Create a New User</legend>
  <p>
    <label for="user_name">Username: </label>
    <input name="user_name" id="user_name" />
  </p>
  <p>
    <label for="user_password">Password: </label>
    <input type="password" name="user_password" id="user_password" />
  </p>
  <p>
    <label for="permission_type">Permission Type: </label>
    <select name= "permission_type" id="permission_type">
      <option value="0">Admin (0)</option>
      <option value="1">Regular User (1)</option>
    </select>
  </p>
  <p>
    <input type="submit" name="usercommand" value="Create" />
  </p>
</fieldset>
</form>
<h4>Users:</h4>
<form action="process_post.php" method="post">
	<?php foreach($usernames as $username): ?>
		<div>
		<p>UserID: <?=$username['UserID']?></p>
		<p>Username: <?=$username['username']?></p>
		<p>Permission Type: <?=$username['permission']?></p>
		<h4><a href="edituser.php?UserID=<?=$username['UserID']?>">[EDIT USER]</a></h4>
		<h3>Date Created: <?=$username['created']?></h3>
		</div>
	<?php endforeach?>
</form>
</body>
</html>