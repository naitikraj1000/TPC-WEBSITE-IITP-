<?php
$verify = false;

// Start session
session_start();

// Check if user is logged in, redirect to login form if not
if (!isset($_SESSION['first_name']) || !isset($_SESSION['last_name']) || !isset($_SESSION['roll_no'])) {
    header("Location: login_form.php");
    exit();
}

// Get user data from session variables
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
$roll_no = $_SESSION['roll_no'];

// Database credentials
$host = 'localhost';
$username = 'naitik';
$password = 'naitik';
$database = 'register';

// Create connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare SQL statement to check if roll_no exists
$sql = "SELECT * FROM students_info WHERE roll_no='$roll_no'";
$result = mysqli_query($conn, $sql);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
    $verify = true;
}

$sql = "SELECT profile_image FROM students WHERE roll_no='$roll_no'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$profile_image = $row["profile_image"];
$base64_image = base64_encode($profile_image);

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
        font-size: 50px;
    }

    p {
        color: #371;
        text-align: center;
        margin-top: 20px;
        font-size: 50px;
    }

    a {
        display: block;
        margin-top: 30px;
        font-size: 1.55em;
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
        /* Green */
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
        /* Dark green */
    }

    .profile-image {
        width: 300px;
        height: 300px;
        border-radius: 50%;
        overflow: hidden;
        margin: 20px auto 0;
    }

    .profile-image img {
        width: 100%;
        height: auto;
    }
</style>

</head>

<body>
    <h1>Welcome!</h1>
    <p>Hello,
        <?php echo $first_name . " " . $last_name; ?>!
    </p>

    <div class="profile-image">
    <img src="data:image/<?php echo $image_type; ?>;base64,<?php echo $base64_image; ?>" alt="Profile Image">
    </div><br><br>

    <?php
    if ($verify) {
        echo '<a href="student_edit.php">Edit Information</a>';
    } else {
        echo '<a href="student_upload.php">Upload Information</a>';
    }
    ?><br>
    <a href="logout.php">Logout</a>

</body>

</html>
