<?php 
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "SchoolName";
	$connection = new mysqli($servername, $username, $password, $dbname);

  if ($connection->connect_error) die($connection->connect_error);

  if (isset($_SERVER['PHP_AUTH_USER']) &&
      isset($_SERVER['PHP_AUTH_PW']))
  {
    $un_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_USER']);
    $pw_temp = mysql_entities_fix_string($connection, $_SERVER['PHP_AUTH_PW']);

	$query = "SELECT * FROM users3 WHERE username='$un_temp'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
	elseif ($result->num_rows)
	{
		$row = $result->fetch_array(MYSQLI_NUM);

		$result->close();

		$salt1 = "qm&h*";
		$salt2 = "pg!@";
        $token = hash('ripemd128', "$salt1$pw_temp$salt2");
		
		if ($token == $row[1])
		{
			session_start();
			$_SESSION['username'] = $un_temp;
			$_SESSION['password'] = $pw_temp;
			$_SESSION['role'] = $row[2];
			echo "Hi $row[0], you are now logged in as a(n) '$row[2]'.";
			if($row[2] == "administrator"){
				die ("<p><a href=student.php>Click here to continue</a></p>");
			}else {
				$query = "SELECT * FROM student WHERE userid='$un_temp'";
				$result2 = $connection->query($query);
				if (!$result2) die($connection->error);
				
				$row2 = $result2->fetch_array(MYSQLI_NUM);

				$result2->close();
				
				die ("<br><p>Welcome $row2[1].<br> Your student ID is: $row2[0] 
					  <br> Your Major is: $row2[2] <br> Your year is: $row2[3]
					  <br> Your userid is: $row2[4] <br> Your email is: $row2[5] <br></p> ");
			}
		}
		else die("Invalid username/password combination");
	}
	else die("Invalid username/password combination");
  }
  else
  {
    header('WWW-Authenticate: Basic realm="Restricted Section"');
    header('HTTP/1.0 401 Unauthorized');
    die ("Please enter your username and password");
  }

  $connection->close();

  function mysql_entities_fix_string($connection, $string)
  {
    return htmlentities(mysql_fix_string($connection, $string));
  }	

  function mysql_fix_string($connection, $string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
  }
?>