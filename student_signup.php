<?php
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Collect form data
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $rollNo = $_POST['rollNo'];
  $email = $_POST['email'];
  $Password = $_POST['password'];



  // Check if file is uploaded
  if (isset($_FILES['profilePhoto']) && $_FILES['profilePhoto']['error'] == 0) {
    $tmp_name = $_FILES['profilePhoto']['tmp_name'];
    $img_name = $_FILES['profilePhoto']['name'];
    $img_size = $_FILES['profilePhoto']['size'];
    $img_type = $_FILES['profilePhoto']['type'];

    // Check if file is an image
    $valid_image_types = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
    if (in_array($img_type, $valid_image_types)) {
      // Read the file into a variable
      $img_data = file_get_contents($tmp_name);
      // Connect to database
      $servername = "localhost";
      $username = "naitik";
      $password = "naitik";
      $dbname = "register";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Encode the image data as a hex string
// $img_hex = bin2hex($img_data);

      // Prepare and bind the SQL statement
      $stmt = $conn->prepare("INSERT INTO students VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssss", $firstName, $lastName, $rollNo, $email, $Password, $img_data);

      // Execute the statement
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
                setTimeout(function(){ window.location.href = "student_login.html"; }, 5000);
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

      $stmt->close();
      $conn->close();
    } else {
      echo "Invalid file type. Only JPEG, JPG, PNG and GIF are allowed.";
    }
  } else {
    echo "No file uploaded.";
  }
}
?>
