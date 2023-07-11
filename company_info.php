<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "naitik";
$password = "naitik";
$dbname = "register";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$min_qualification = $_POST['min-qualification'];
$min_cpi = $_POST['min-cpi'];
$salary_start = $_POST['salary-range-min'];
$salary_end = $_POST['salary-range-max'];
$mode_of_interview = $_POST['mode-of-interview'];
$recruitment_year = $_POST['recruitment-year'];

$sql = "INSERT INTO eligibility (min_qualification, min_cpi, salary_start, salary_end, mode_of_interview, recruitment_year) VALUES ('$min_qualification', $min_cpi, $salary_start, $salary_end, '$mode_of_interview', $recruitment_year)";

if (mysqli_query($conn, $sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>
