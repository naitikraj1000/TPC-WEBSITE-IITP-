<?php
session_start(); // Start the session

// Establish a database connection
$host = "localhost";
$username = "naitik";
$password = "naitik";
$database = "register";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the login form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
  
  // Retrieve the username and password from the login form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prepare a SQL query to check if the credentials are valid
  $sql = "SELECT * FROM admin WHERE user_name = '$username' AND password = '$password'";

  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    // Login successful, set the session variable
    $_SESSION['username'] = $username;
    header("Location: admin.php");
    exit();
  } else {
    // Login failed
    echo "Invalid username or password.";
  }
}

// Close the database connection
mysqli_close($conn);

?>
<style>
  form {
    background-color: #f2f2f2;
    padding: 20px;
    border-radius: 5px;
    width: 300px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
  }

  label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
  }

  input[type="text"], input[type="password"] {
    padding: 10px;
    border-radius: 5px;
    border: none;
    width: 100%;
    margin-bottom: 20px;
    font-size: 16px;
    box-sizing: border-box;
  }

  button[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
  }

  button[type="submit"]:hover {
    background-color: #3e8e41;
  }
</style>
<form method="POST">
  <label for="username">Username:</label>
  <input type="text" name="username" id="username" required>
  <br>
  <label for="password">Password:</label>
  <input type="password" name="password" id="password" required>
  <br>
  <button type="submit">Login</button>
</form>
