<?php
	session_start();

	if (isset($_SESSION['uname'])){
		session_destroy();

		header("Location: http://localhost:31337/Final_Project/index.html");
	}
	else {
		header("Location: http://localhost:31337/Final_Project/authenticate.php");
	}
?>