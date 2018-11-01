<?php 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "SchoolName";
	$connection = new mysqli($servername, $username, $password, $dbname);

  if ($connection->connect_error) die($connection->connect_error);
#create new table in database
  $query = "CREATE TABLE IF NOT EXISTS users3 (
    username VARCHAR(32) NOT NULL UNIQUE,
    password VARCHAR(32) NOT NULL,
	role VARCHAR(32) NOT NULL
  )";
  $result = $connection->query($query);
  if (!$result) die($connection->error);
#encrypt passwords
  $salt1    = "qm&h*";
  $salt2    = "pg!@";

  $username = 'admin1';
  $password = 'admin1';
  $role = 'administrator';
  $token    = hash('ripemd128', "$salt1$password$salt2");

  add_user($username, $token, $role);

  $username = 'student1';
  $password = 'student1';
  $role = 'student';
  $token    = hash('ripemd128', "$salt1$password$salt2");

  add_user($username, $token, $role);

  $username = 'student2';
  $password = 'student2';
  $role = 'student';
  $token    = hash('ripemd128', "$salt1$password$salt2");

  add_user($username, $token, $role);
#function to add user data into database
  function add_user($un, $pw, $rl)
  {
    global $connection;

    $query  = "INSERT INTO `users3` (`username`, `password`, `role`)  VALUES('$un', '$pw', '$rl')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
  }
?>
