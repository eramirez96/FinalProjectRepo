<?php
/*
    Assignment 4 PHP and Database
    Author: Elijah Ramirez
    Date: February, 10, 2020
    Purpost: To use user input, storing them into a database and to manipulate them for display.
*/
  require 'connection.php';

  // file_upload_path() - Safely build a path String that uses slashes appropriate for our OS.
  // Default upload path is an 'uploads' sub-folder in the current folder.
  function file_upload_path($original_filename, $upload_subfolder_name = 'uploads') {
     $current_folder = dirname(__FILE__);
     
     // Build an array of paths segment names to be joins using OS specific slashes.
     $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
     
     // The DIRECTORY_SEPARATOR constant is OS specific.
     return join(DIRECTORY_SEPARATOR, $path_segments);
  }

  // file_is_an_image() - Checks the mime-type & extension of the uploaded file for "image-ness".
  function file_is_an_image($temporary_path, $new_path) {
      $allowed_mime_types      = ['image/jpeg', 'image/png'];
      $allowed_file_extensions = ['jpg', 'jpeg', 'png'];
      
      $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
      $actual_mime_type        = getimagesize($temporary_path)['mime'];
      
      $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
      $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
      
      return $file_extension_is_valid && $mime_type_is_valid;
  }

  $car_name = filter_input(INPUT_POST, 'car_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $car_type = filter_input(INPUT_POST, 'car_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $invalid = false;
  $no_image = true;

  if (!filter_input(INPUT_POST, 'car_price', FILTER_VALIDATE_INT)) {
    $invalid = true;
  }
  else {
    $car_price = filter_input(INPUT_POST, 'car_price', FILTER_VALIDATE_INT);
  }

  if (strlen($car_name) < 1) {
  	$invalid = true;
  }

  $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);

  if ($image_upload_detected) { 
    $detected = 'image detected!';
    $image_filename        = $_FILES['image']['name'];
    $temporary_image_path  = $_FILES['image']['tmp_name'];
    $new_image_path        = file_upload_path($image_filename);
    if (file_is_an_image($temporary_image_path, $new_image_path)) {

        $current_folder = dirname(__FILE__);

        copy($temporary_image_path, $image_filename);

        //image resizing
        $ext = explode('.', $image_filename);
        $ext = end($ext);

        $base_name = explode('.', $image_filename);
        $base_name = reset($base_name);

        //new images
        include "uploads/ImageResize.php";
        include "uploads/ImageResizeException.php";

        $newfile = new \Gumlet\ImageResize($image_filename);

        $newfile->resizeToWidth(300);
        $newfile->save($base_name .'.'. $ext);

        copy($image_filename, 'uploads/'.$image_filename);
        unlink($image_filename);
    }
    $no_image = false;
  }

  //Creating a database entry with INSERT
  if (isset($_POST['command']) && !isset($_POST['ModelID']) && $invalid == false) {
	$query     = "INSERT INTO vehicle (Name, Type, BasePrice, img) values (:car_name, :car_type, :car_price, :image_filename)";
	$statement = $db->prepare($query);
	$statement->bindValue(':car_name', $car_name);        
  $statement->bindValue(':car_type', $car_type);
  $statement->bindValue(':car_price', $car_price);
  $statement->bindValue(':image_filename', $image_filename);
	$statement->execute();

	header("Location: http://localhost:31337/Final_Project/employee.php");
    exit;
  }
  else if ($no_image && isset($_POST['command']) && !isset($_POST['ModelID']) && $invalid == false) {
  $query     = "INSERT INTO vehicle (Name, Type, BasePrice) values (:car_name, :car_type, :car_price)";
  $statement = $db->prepare($query);
  $statement->bindValue(':car_name', $car_name);        
  $statement->bindValue(':car_type', $car_type);
  $statement->bindValue(':car_price', $car_price);
  $statement->execute();

  header("Location: http://localhost:31337/Final_Project/employee.php");
    exit;
  }

  //Updating database entry with UPDATE
  if ($no_image && isset($_POST['updatecommand'])) {
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
  else if (isset($_POST['updatecommand'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query     = "UPDATE vehicle SET Name = :car_name, Type = :car_type, BasePrice = :car_price, img = :image_filename WHERE ModelID = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':car_name', $car_name);        
    $statement->bindValue(':car_type', $car_type);
    $statement->bindValue(':car_price', $car_price);
    $statement->bindValue(':image_filename', $image_filename);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: http://localhost:31337/Final_Project/employee.php");
    exit;
  }

  //Updating database with DELETE
  if (isset($_POST['deletecommand'])) {
  	$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM vehicle WHERE ModelID = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: http://localhost:31337/Final_Project/index.html");
    exit;
  }

  if (isset($_POST['deletecommandimage'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query     = "UPDATE vehicle SET Name = :car_name, Type = :car_type, BasePrice = :car_price, img = NULL WHERE ModelID = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':car_name', $car_name);        
    $statement->bindValue(':car_type', $car_type);
    $statement->bindValue(':car_price', $car_price);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    $del_filename = $_POST['current_image'];
    unlink('uploads'.DIRECTORY_SEPARATOR.$del_filename);

    header("Location: http://localhost:31337/Final_Project/edit.php?ModelID="."$id");
    exit;
  }

  //User Insert, Update, and Delete
  $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $user_password = filter_input(INPUT_POST, 'user_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $user_type = filter_input(INPUT_POST, 'permission_type', FILTER_SANITIZE_NUMBER_INT);

  //Updating database entry with INSERT
  if (isset($_POST['usercommand']) && !isset($_POST['UserID'])) {
    $query     = "INSERT INTO vehicle_user (username, password, permission) values (:user_name, :user_password, :user_type)";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);        
    $statement->bindValue(':user_password', $user_password);
    $statement->bindValue(':user_type', $user_type);
    $statement->execute();

    header("Location: http://localhost:31337/Final_Project/user.php");
    exit;
  }
  //Updating database entry with UPDATE
  if (isset($_POST['userupdatecommand'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query     = "UPDATE vehicle_user SET username = :user_name, password = :user_password, permission = :user_type WHERE UserID = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);        
    $statement->bindValue(':user_password', $user_password);
    $statement->bindValue(':user_type', $user_type);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: http://localhost:31337/Final_Project/user.php");
    exit;
  }
  //Updating database with DELETE
  if (isset($_POST['userdeletecommand'])) {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM vehicle_user WHERE UserID = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();

    header("Location: http://localhost:31337/Final_Project/user.php");
    exit;
  }

  //User Registration
  //Updating database entry with INSERT
  $confirm_user_password = filter_input(INPUT_POST, 'confirm_user_password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

  if (isset($_POST['registerusercommand']) && !isset($_POST['UserID'])) {
    if ($user_password == $confirm_user_password) {
      $permission_type = filter_input(INPUT_POST, 'permission_type', FILTER_SANITIZE_NUMBER_INT);

      $query     = "INSERT INTO vehicle_user (username, password, permission) values (:user_name, :user_password, :user_type)";
      $statement = $db->prepare($query);
      $statement->bindValue(':user_name', $user_name);        
      $statement->bindValue(':user_password', $user_password);
      $statement->bindValue(':user_type', $permission_type);
      $statement->execute();

      header("Location: http://localhost:31337/Final_Project/index.html");
      exit;
    }
    else {
      header("refresh:1;url=index.html");
      echo "<script>alert('Passwords are not identical, please try again.')</script>";
    }
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