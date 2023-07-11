<?php
// define database connection parameters
$db_host = "localhost";
$db_user = "naitik";
$db_pass = "naitik";
$db_name = "register";
session_start();
// establish database connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// check if connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}


$roll_no = $_SESSION['roll_no'];
// check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // retrieve form data
    $roll_no = $_SESSION['roll_no'];
    $company_name = $_POST["company_name"];
    $current_ctc = $_POST["current_ctc"];
    $current_post = $_POST["current_post"];
    $location = $_POST["location"];
    $working_tenure = $_POST["working_tenure"];

    // check if the row already exists in the table
    $sql = "SELECT * FROM Alumini_info WHERE roll_no = '$roll_no'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // row exists, update it
        $sql = "UPDATE Alumini_info SET Company_Name = '$company_name', Current_CTC = '$current_ctc', Current_Post = '$current_post', Location = '$location', Working_Tenure = '$working_tenure' WHERE roll_no = '$roll_no'";
        if (mysqli_query($conn, $sql)) {
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } else {
        // row does not exist, insert it
        $sql = "INSERT INTO Alumini_info (roll_no, Company_Name, Current_CTC, Current_Post, Location, Working_Tenure) VALUES ('$roll_no', '$company_name', '$current_ctc', '$current_post', '$location', '$working_tenure')";
        if (mysqli_query($conn, $sql)) {
            echo "Record inserted successfully";
        } else {
            echo "Error inserting record: " . mysqli_error($conn);
        }
    }
}

// close database connection
mysqli_close($conn);
?>

<style>
    form {
        display: flex;
        flex-direction: column;
        max-width: 400px;
        margin: 0 auto;
    }

    label {
        margin-bottom: 0.5rem;
        font-weight: bold;
    }

    input[type="text"] {
        padding: 0.5rem;
        margin-bottom: 1rem;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 1rem;
    }

    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 1rem;
    }

    input[type="submit"]:hover {
        background-color: #0069d9;
    }
    .h1{
        text-align: center;
    }
</style>

<html>
<form method="post">
    <h1>Update Information</h1>
    <label for="company_name">Company Name:</label>
    <input type="text" name="company_name" required>

    <label for="current_ctc">Current CTC:</label>
    <input type="text" name="current_ctc" required>

    <label for="current_post">Current Post:</label>
    <input type="text" name="current_post" required>

    <label for="location">Location:</label>
    <input type="text" name="location" required>

    <label for="working_tenure">Working Tenure:</label>
    <input type="text" name="working_tenure" required>

    <input type="submit" name="submit" value="Update">
</form>
</body>

</html>