<!DOCTYPE html>
<html>
<body>

<h1> Student Data </h1>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SchoolName";

$conn = new mysqli($servername, $username, $password, $dbname); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

	$sql = "SELECT ID, Name, Major, Year, userid, email FROM student";
	$result = $conn->query($sql);
	#fetch data from database
	if ($result->num_rows > 0) {
                         
		while($row = $result->fetch_assoc()) {
			echo "<br> ID: ". $row["ID"]. " Name: ". $row["Name"]. " Major: " . $row["Major"] . 
				 " Year: " . $row["Year"] ." userid: " . $row["userid"] ." email: " . $row["email"] ."<br>";
		}
	} else {
		echo "Nothing found.";
	}
$conn->close();
?> 

<!--form to allow admin to delete students-->
<h3> Enter the ID of the student to be removed </h3>
<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	ID: <input type="text" name="delID"><br>
	<br> <input type="submit" name="delete" value="Delete">
</form>

<br>

<!-- form for admin to fill out when adding a new student -->
<h3> Enter the to create a new student </h3>
<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	ID: <input type="text" name="addID"><br><br>
	Name: <input type="text" name="addName"><br><br>
	Major: <input type="text" name="addMajor"><br><br>
	Year: <input type="text" name="addYear"><br><br>
	userid: <input type="text" name="adduserid"><br><br>
	email: <input type="text" name="addemail"><br><br>
	<br> <input type="submit" name="create" value="Create">
</form>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SchoolName";

#start new connection to database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
#send data to be stored into database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['delete'])) {
		$tempDelID = $_POST['delID'];

        $sql = "DELETE FROM student WHERE id= '$tempDelID'";
		$conn->query($sql);

    } else if (isset($_POST['create'])){

		$tempID = $_POST['addID'];
		$tempName = $_POST['addName'];
		$tempMajor = $_POST['addMajor'];
		$tempYear = $_POST['addYear'];
		$tempuserid = $_POST['adduserid'];
		$tempemail = $_POST['addemail'];
		
		
        $sql = "INSERT INTO student (ID, Name, Major, Year, userid, email)
		VALUES ('$tempID', '$tempName', '$tempMajor', '$tempYear', '$tempuserid', '$tempemail')";
		$conn->query($sql); 
	}
}

$conn->close();
?>


</body>
</html>
