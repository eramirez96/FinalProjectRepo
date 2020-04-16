<?php
	session_start();

	if (isset($_SESSION['uname']) || isset($_SESSION['uname1'])){
		session_destroy();

		header("Location: http://localhost:31337/Final_Project/index.php");
	}
	else {
		header("Location: http://localhost:31337/Final_Project/index.php");
	}
?>