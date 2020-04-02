 <?php
/*
    Assignment 4 PHP and Database
    Author: Elijah Ramirez
    Date: February, 10, 2020
    Purpost: To use user input, storing them into a database and to manipulate them for display.
*/
  define('ADMIN_LOGIN','wally');

  define('ADMIN_PASSWORD','mypass');

  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])

      || ($_SERVER['PHP_AUTH_USER'] != ADMIN_LOGIN)

      || ($_SERVER['PHP_AUTH_PW'] != ADMIN_PASSWORD)) {

    header('HTTP/1.1 401 Unauthorized');

    header('WWW-Authenticate: Basic realm="Our Blog"');

    exit("Access Denied: Username and password required.");

  }

   

?>