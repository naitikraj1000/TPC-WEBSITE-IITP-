<?php
    session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$servername = "localhost";
$username = "naitik";
$password = "naitik";
$dbname = "register";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the user's input from the form
  $email = $_POST["email"];
  $password = $_POST["password"];
  
  // Validate the user's login credentials
  $query = "SELECT * FROM Company WHERE email = '$email' AND password = '$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    // Start a session and store the user's email address

    $_SESSION["email"] = $email;
  $row = mysqli_fetch_array($result);
  $_SESSION["company_id"] = $row["company_id"];
  $_SESSION['company_name']=$row['company_name'];
    // Redirect the user to the dashboard page
    header("Location: company_welcome.php");
    exit();
  } else {
    // Display an error message to the user
    $error_message = "Invalid email address or password. Please try again.";
  }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Company Login</title>
    <link rel="stylesheet" href="company_login_style.css">
  </head>
  <body>
    <h1>Company Login</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <label for="email">Email Address:</label>
      <input type="email" id="email" name="email" required><br>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <div id="error-message" style="font-weight: bold;"><?php echo $error_message; ?></div><br>

      <button type="submit">Login</button>
    </form>
  </body>
</html>

