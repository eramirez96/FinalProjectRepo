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
	<section id="information">
		<div id="about">
			<h1>Welcome.</h1>
			<p>Our company, Electric Motors have been striving since 2019 to innovate and produce affordable cars that will change the industry forever. We believe that the advent of electric vehicles will be the change that people need to combat climate change, and as well as making vehicles more accessible to people can provide an increase in productivity.</p>
			<img id="logo" src="images/logo.jpg" alt="logo">
		</div>
		<div id="promotions">
			<h2>Current Promotions:</h2>
			<dl>
				<dt>EM Speedster™</dt>
						<dd>$30,000.00 CAD (+10% off on additional accessories) any color + 3 year plan</dd>
				<dt>EM Trekker™</dt>
					<dd>$45,000.00 CAD (NO DOWN PAYMENT) + 4 year plan</dd>
				<dt>EM Glider™</dt>
					<dd>$80,000.00 CAD (5% off orig. price) + 5 year plan</dd>
			</dl>
		</div>
	</section>
</body>
</html>