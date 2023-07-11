<?php
// Start session
session_start(); //session starts here  

// Connect to the database
$servername = "localhost";
$username = "naitik";
$password = "naitik";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Get user input from login form
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare SQL query to retrieve user data
$sql = "SELECT * FROM students WHERE email='$email' AND password='$password'";
$result = $conn->query($sql);


// Check if query returns any rows
if ($result->num_rows > 0) {
	// Authentication successful, retrieve user data
	$row = $result->fetch_assoc();
	$first_name = $row["first_name"];
	$last_name = $row["last_name"];
	$email = $row["email"];
	$roll_no = $row["roll_no"];
	$password = $row["password"];


	$sql = "SELECT * FROM students_info WHERE roll_no='$roll_no'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();

		$curr_date = intval(date("Y"));
		$date = intval($row["batch_year"]);


		// echo $curr_date - $date . "  " . $date;

		if ($curr_date - $date >= 5) {

			$sql = "SELECT * FROM Alumini WHERE roll_no='$roll_no'";
			$result = $conn->query($sql);
			if ($result->num_rows == 0) {
				$sql = "INSERT INTO Alumini (first_name, last_name, roll_no, email, password) 
				VALUES ('$first_name', '$last_name', '$roll_no', '$email', '$password')";
				mysqli_query($conn, $sql);
				// echo $first_name." ",$last_name." ",$roll_no."$email"." $password";
				header("Location: alumni_login.html");
				exit();
			} else {
				header("Location: alumni_login.html");
				exit();
			}

		} else {
			$_SESSION['first_name'] = $first_name;
			$_SESSION['last_name'] = $last_name;
			$_SESSION['email'] = $email;
			$_SESSION["loggedin"] = true;
			$_SESSION['roll_no'] = $roll_no;
			header("Location: welcome.php");
			exit();
		}
	} else {
		$_SESSION['first_name'] = $first_name;
		$_SESSION['last_name'] = $last_name;
		$_SESSION['email'] = $email;
		$_SESSION["loggedin"] = true;
		$_SESSION['roll_no'] = $roll_no;
		header("Location: welcome.php");
		exit();
	}
} else {
	// Authentication failed, display error message
	echo "Invalid email or password.";
}

// Close database connection
$conn->close();
?>