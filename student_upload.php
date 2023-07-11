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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user data from form inputs
    $age = $_POST['age'];
    $specialization = $_POST['specialization'];
    $marks_class_10 = $_POST['class_10'];
    $marks_class_11 = $_POST['class_11'];
    $marks_class_12 = $_POST['class_12'];
    $marks_semester_1 = $_POST['semester_1'];
    $marks_semester_2 = $_POST['semester_2'];
    $marks_semester_3 = $_POST['semester_3'];
    $marks_semester_4 = $_POST['semester_4'];
    $marks_semester_5 = $_POST['semester_5'];
    $marks_semester_6 = $_POST['semester_6'];
    $marks_semester_7 = $_POST['semester_7'];
    $marks_semester_8 = $_POST['semester_8'];
    $company_id = $_POST['company_id'];
    // $overall_cpi = $_POST['cpi'];
    $area_of_interest = $_POST['interest'];
    $batch_year = $_POST['batch_year'];
    $placed_or_not = $_POST['placed'];
    $package = 0;
    if ($placed_or_not) {
        $package = $_POST['package'];
    }

    $_SERVER['batch_year'] = $batch_year;

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

    $val = 0;
    $num = 8;

    if ($marks_semester_2 == 0) {
        $val = $marks_semester_1;
        $num = 1;
    } else
        if ($marks_semester_3 == 0) {
            $val = $marks_semester_1 + $marks_semester_2;
            $num = 2;
        } else
            if ($marks_semester_4 == 0) {
                $val = $marks_semester_1 + $marks_semester_2 + $marks_semester_3;
                $num = 3;
            } else
                if ($marks_semester_5 == 0) {
                    $val = $marks_semester_1 + $marks_semester_2 + $marks_semester_3 + $marks_semester_4;
                    $num = 4;
                } else
                    if ($marks_semester_6 == 0) {
                        $val = $marks_semester_1 + $marks_semester_2 + $marks_semester_3 + $marks_semester_4 + $marks_semester_5;
                        $num = 5;
                    } else
                        if ($marks_semester_7 == 0) {
                            $val = $marks_semester_1 + $marks_semester_2 + $marks_semester_3 + $marks_semester_4 + $marks_semester_5 + $marks_semester_6;
                            $num = 6;
                        } else
                            if ($marks_semester_8 == 0) {
                                $val = $marks_semester_1 + $marks_semester_2 + $marks_semester_3 + $marks_semester_4 + $marks_semester_5 + $marks_semester_6 + $marks_semester_7;
                                $num = 7;
                            } else
                                if ($marks_semester_8 != 0) {
                                    $val = $marks_semester_1 + $marks_semester_2 + $marks_semester_3 + $marks_semester_4 + $marks_semester_5 + $marks_semester_6 + $marks_semester_7 + $marks_semester_8;
                                    $num = 8;
                                }

    $overall_cpi = ($val) / $num;

    $sql = "INSERT INTO students_info
            VALUES ('$roll_no','$specialization', '$age', '$marks_class_10', '$marks_class_11', '$marks_class_12', '$marks_semester_1', '$marks_semester_2', '$marks_semester_3', '$marks_semester_4', '$marks_semester_5', '$marks_semester_6', '$marks_semester_7', '$marks_semester_8', '$overall_cpi', '$area_of_interest', '$batch_year', '$placed_or_not', '$package')";

    if ($conn->query($sql) === true) {

        $sql = "INSERT INTO placement VALUES('$roll_no','$company_id','$package','$batch_year')";
        $conn->query($sql);
        // Display success message and redirect to login page after 5 seconds
        // Display success message and redirect to login page after 5 seconds
        echo '<div class="success-message">Registered! Successfully. You will be redirected to the Welcome page in <span id="countdown">5</span> seconds.</div>';
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

<script>
    function generateYearOptions(startYear) {
    const currentYear = new Date().getFullYear() + 4; // Get the current year
    const yearDropdown = document.getElementById("batch_year");

    // Loop through the range of years and add options to the dropdown
    for (let i = startYear; i <= currentYear; i++) { const option=document.createElement("option"); option.text=i;
        option.value=i; yearDropdown.add(option); } 
    
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
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>

        <label for="specialization">Specialization:</label>
        <input type="text" id="specialization" name="specialization" required>

        <label for="class_10">Marks in Class 10:</label>
        <input type="number" id="class_10" name="class_10" step="0.01" required>

        <label for="class_11">Marks in Class 11:</label>
        <input type="number" id="class_11" name="class_11" step="0.01" required>

        <label for="class_12">Marks in Class 12:</label>
        <input type="number" id="class_12" name="class_12" step="0.01" required>

        <label for="semester_1">Marks in Semester 1:</label>
        <input type="number" id="semester_1" name="semester_1" step="0.01" required>

        <label for="semester_2">Marks in Semester 2:</label>
        <input type="number" id="semester_2" name="semester_2" step="0.01" required>

        <label for="semester_3">Marks in Semester 3:</label>
        <input type="number" id="semester_3" name="semester_3" step="0.01" required>

        <label for="semester_4">Marks in Semester 4:</label>
        <input type="number" id="semester_4" name="semester_4" step="0.01" required>

        <label for="semester_5">Marks in Semester 5:</label>
        <input type="number" id="semester_5" name="semester_5" step="0.01" required>

        <label for="semester_6">Marks in Semester 6:</label>
        <input type="number" id="semester_6" name="semester_6" step="0.01" required>

        <label for="semester_7">Marks in Semester 7:</label>
        <input type="number" id="semester_7" name="semester_7" step="0.01" required>

        <label for="semester_8">Marks in Semester 8:</label>
        <input type="number" id="semester_8" name="semester_8" step="0.01" required>

        <!-- <label for="cpi">Overall CPI:</label>
        <input type="number" id="cpi" name="cpi" step="0.01" required> -->

        <label for="interest">Area of Interest:</label>
        <input type="text" id="interest" name="interest" required>

        <label for="batch_year">Batch Year:</label>
        <select id="batch_year" name="batch_year" required>
            <option value="">Select Year</option>
            <script>generateYearOptions(1990);</script>
        </select>





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
