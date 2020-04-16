<!DOCTYPE html>
<html lang="en">
<head>
  <title>Electric Motors Inc.</title>
  <link rel="stylesheet" type="text/css" href="index.css">
  <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Arimo&display=swap" rel="stylesheet"> 
</head>
<body>
  <h2>Administrator Log In</h2>
  <form action="employee.php" method="post">
    <p>
      <label for="uname">Username:</label>
      <input type='text' name='uname' id='uname'>
    </p>
    <p>
      <label for="pwd">Password:</label>
      <input type='password' name='pwd' id='pwd'>
    </p>
    <input type="submit" name="login" value="Log in" />
  </form>
  <h2>User Log In</h2>
  <form action="products.php" method="post">
    <p>
      <label for="reguname">Username:</label>
      <input type='text' name='reguname' id='reguname'>
    </p>
    <p>
      <label for="regpwd">Password:</label>
      <input type='password' name='regpwd' id='regpwd'>
    </p>
    <input type="submit" name="reglogin" value="Log in" />
  </form>
</body>
</html>