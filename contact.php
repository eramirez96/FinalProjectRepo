<!-------f--------

    Final Project
    Name: Elijah Ramirez
    Date: December 4, 2019
    Description: Final Project

----------------->
<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Electric Motors Inc.</title>
	<link rel="stylesheet" type="text/css" href="index.css">
	<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Arimo&display=swap" rel="stylesheet"> 
	<script src="contactvalidation.js" type="text/javascript"></script>
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
	<form id="forms" 
      action="index.html" 
      method="post">
	<fieldset id="contacts">
		<legend>Contact</legend>
		<hr />
		<label for="comment">Contact Information:</label><br />
		<div id="fields">
			<ul>
				<li>
					<label for="name">Name:</label>
					<input id="name" name="name" type="text" />
					<p class ="errors" id="name_error">* Required field</p>
				</li>
				<li>
					<label for="phonenum">Phone Number:</label>
					<input id="phonenum" name="phonenum" type="tel"/>
					<p class ="errors" id="phonenum_error">* Required field</p>
					<p class ="errors" id="phonenumformat_error">* Invalid phone number</p>
				</li>
				<li>
					<label for="email">E-mail:</label>
					<input id="email" name="email" type="text" />
					<p class ="errors" id="email_error">* Required field</p>
					<p class ="errors" id="emailformat_error">* Invalid email address</p>
				</li>
			</ul>
		</div>			
	</fieldset>
	<fieldset id="comments">
		<legend>Comments</legend>
		<hr />
		<label for="comment">Any comments?</label><br />
		<textarea id="comment" name="comment" rows="8" cols="50"></textarea>
	</fieldset>
	<fieldset id="buttons">
		<legend>Submit or Reset</legend>
		<input type="reset" value="Reset" />
		<input type="submit" value="Submit" />
	</fieldset>
	</form>
</body>
</html>