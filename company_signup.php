<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Replace with your MySQL database credentials
$servername = "localhost";
$username = "naitik";
$Password = "naitik";
$dbname = "register";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $Password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare a SQL statement to insert the form data into a "companies" table
$stmt = $conn->prepare("INSERT INTO Company  VALUES (?, ?, ?, ?, ?)");
// Bind the form data to the SQL statement parameters

$stmt->bind_param("sssss", $companyName, $companyId, $recruiting_since, $email, $password);

// echo $companyId," ",$companyName," ",$recruiting_since," ",$email," ",$password;
// Get the form data from the $_POST superglobal array
$companyName = $_POST["company-name"];
$companyId = $_POST["company-id"];
$recruiting_since = $_POST["recruiting_since"];
$email = $_POST["email"];
$password = $_POST["password"];
// Execute the SQL statement to insert the form data into the database
if ($stmt->execute()) {
  // Display success message and redirect to login page after 5 seconds
  echo '<div class="success-message">You have successfully signed up. You will be redirected to the login page in <span id="countdown">5</span> seconds.</div>';
  echo '<script>
            var timeleft = 5;
            var downloadTimer = setInterval(function(){
              timeleft--;
              document.getElementById("countdown").textContent = timeleft;
              if(timeleft <= 0)
                clearInterval(downloadTimer);
            },1000);
            setTimeout(function(){ window.location.href = "company_login.html"; }, 5000);
          </script>';

  // Add CSS for success message
  echo '<style>
            .success-message {
              padding: 10px;
              background-color: #d4edda;
              border-color: #c3e6cb;
              color: #155724;
              margin-bottom: 10px;
              text-align: center;
            }
          </style>';

  // Add CSS for countdown
  echo '<style>
            #countdown {
              font-size: 24px;
              font-weight: bold;
              color: #155724;
            }
          </style>';
} else {
  echo "Error: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>