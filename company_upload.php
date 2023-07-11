<?php
 session_start();
// Connect to the database
$servername = "localhost";
$username = "naitik";
$password = "naitik";
$dbname = "register";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$company_id = $_SESSION["company_id"];
$company_name = $_SESSION['company_name'];

$min_qualification = $_POST["min_qualification"];
$marks_criteria = $_POST["marks_criteria"];
$starting_salary = $_POST["starting_salary"];
$ending_salary = $_POST["ending_salary"];
$interview_mode = $_POST["interview_mode"];
$current_recruiting_year = $_POST["current_recruiting_year"];

$sql = "INSERT INTO Companies 
VALUES ('$company_id', '$company_name', '$min_qualification', '$marks_criteria', '$starting_salary', '$ending_salary', '$interview_mode' , '$current_recruiting_year')";

if (mysqli_query($conn, $sql)) {
  echo "Data uploaded successfully!";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>