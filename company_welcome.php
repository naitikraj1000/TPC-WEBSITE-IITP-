<?php
  // Start a session to keep track of the user's login status
  session_start();
  
  // Check if the user is not logged in
  if (!isset($_SESSION["company_id"])) {
    // Redirect the user to the login page
    header("Location: company_login.php");
    exit();
  }

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

  // Retrieve the company name based on the company ID stored in the session variable
  $company_id = $_SESSION["company_id"];
  $sql = "SELECT company_name FROM Company WHERE company_id = '$company_id'";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $company_name = $row["company_name"];
  } else {
    $company_name = "Unknown company";
  }

  // Close the database connection
  mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome Page</title>
  <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    h1 {
        color: #333;
        text-align: center;
        margin-top: 50px;
        font-size: 70px;
    }


    a {
        display: block;
        margin-top: 30px;
        font-size: 1.5em;
        text-align: center;
        color: #333;
        text-decoration: none;
        padding: 10px;
        background-color: #f2f2f2;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 200px;
        margin: 0 auto;
    }

    a:hover {
        background-color: #ddd;
    }

    .register-btn {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        cursor: pointer;
        border-radius: 15px;
    }

    .register-btn:hover {
        background-color: #3e8e41;
    }
  </style>
</head>
<body>
  <h1>Welcome! <?php echo $company_name; ?></h1>
  <a href="company_upload.html">Upload Information</a><br>
  <a href="logout.php">Logout</a>
</body>
</html>

