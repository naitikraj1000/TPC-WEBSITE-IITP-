<?php
// Start session
session_start();

// Check if user is logged in, redirect to login form if not
if (!isset($_SESSION['first_name']) || !isset($_SESSION['last_name'])) {
    header("Location: login_form.php");
    exit();
}


// Get user data from session variables
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$email = $_SESSION['email'];
$roll_no = $_SESSION['roll_no'];
$batch_year= $_SERVER['batch_year'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $placed_or_not = $_POST['placed'];
    $package = 0;

    if ($placed_or_not) {
        $package = $_POST['package'];
    }
    $company_id=$_POST['company_id'];

    $servername = "localhost";
    $username = "naitik";
    $password = "naitik";
    $dbname = "register";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // Update the students_info table with the new values
    $sql = "UPDATE students_info SET placed_or_not='$placed_or_not', package='$package' WHERE roll_no='$roll_no'";
    if ($conn->query($sql) === TRUE) {
        $sql = "UPDATE placement SET Package = '$package' WHERE Roll_No = '$roll_no'";
        $conn->query($sql);
        
           // Display success message and redirect to login page after 5 seconds
    echo '<div class="success-message">Updated! Successfully. You will be redirected to the Welcome page in <span id="countdown">5</span> seconds.</div>';
    echo '<script>
            var timeleft = 5;
            var downloadTimer = setInterval(function(){
              timeleft--;
              document.getElementById("countdown").textContent = timeleft;
              if(timeleft <= 0)
                clearInterval(downloadTimer);
            },1000);
            setTimeout(function(){ window.location.href = "welcome.php"; }, 5000);
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
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>

<!DOCTYPE html>
<html>

<head>

    <script>
        function showHidePackage() {
            var placedSelect = document.getElementById("placed");
            var packageLabel = document.getElementById("package-label");
            var packageInput = document.getElementById("package");
            
            var placedSelectA = document.getElementById("company");
            var packageLabelA = document.getElementById("company-label");
            var packageInputA = document.getElementById("company_id");

            if (placedSelect.value == "1") {
                packageLabel.style.display = "block";
                packageInput.style.display = "block";
                packageInput.setAttribute("required", true);

                packageLabelA.style.display = "block";
                packageInputA.style.display = "block";
                packageInputA.setAttribute("required", true);

            } else {
                packageLabel.style.display = "none";
                packageInput.style.display = "none";
                packageInput.removeAttribute("required");

                packageLabelA.style.display = "none";
                packageInputA.style.display = "none";
                packageInputA.removeAttribute("required");
            }
        }

    </script>


    <title>Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            color: #004d99;
        }

        form {
            margin: 0 auto;
            max-width: 600px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px #aaaaaa;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333333;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"],
        select {
            padding: 10px;
            width: 100%;
            border: 1px solid #aaaaaa;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            margin-bottom: 20px;
        }

        input[type="submit"] {
            background-color: #004d99;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #00264d;
        }
    </style>
</head>

<body>
    <h1>Student Information</h1>
    <form action="" method="POST">
        <label for="placed">Placed or Not:</label>
        <select id="placed" name="placed" onchange="showHidePackage()" required>
            <option value="">Select an option</option>
            <option value="1">Placed</option>
            <option value="0">Not placed</option>
        </select>

        <label for="package" id="package-label" style="display: none;">Package:</label>
        <input type="number" id="package" name="package" step="0.01" style="display: none;" required>


        <label for="company" id="company-label" style="display: none;">Company ID:</label>
        <input type="text" id="company_id" name="company_id" step="0.01" style="display: none;" required>

        <input type="submit" value="Submit">
    </form>
</body>

</html>
