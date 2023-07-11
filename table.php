<?php
// get the table name from the query parameter
$table = $_GET["table"];
// connect to the database
$servername = "localhost";
$username = "naitik";
$password = "naitik";
$dbname = "register";

$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// get all the columns of the table
$result = $conn->query("SHOW COLUMNS FROM $table");
$columns = array();
while ($row = $result->fetch_assoc()) {
    $columns[] = $row;
}

// get all the records of the table
$result = $conn->query("SELECT * FROM $table");

// display the records as a table
echo "<table>";
echo "<thead>";
echo "<tr>";
echo "<th>#</th>";
foreach ($columns as $column) {
    echo "<th>" . $column["Field"] . "</th>";
}
echo "</tr>";
echo "</thead>";
echo "<tbody>";
$i = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $i . "</td>";
foreach ($row as $key => $value) {
    if (strpos($value, "\x89PNG") === 0 || strpos($value, "GIF") === 0 || strpos($value, "\xFF\xD8") === 0) {
        // The binary data is an image
        $src = 'data:image/jpeg;base64,' . base64_encode($value);
        echo "<td><img src='$src' width='50px' height='50px'/></td>";
    } else {
        // The binary data is not an image
        echo "<td>$value</td>";
    }
}

    echo "</tr>";
    $i++;
}
echo "</tbody>";
echo "</table>";

// close the database connection
$conn->close();
?>

<html>

<head>
    <title>Table</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>

</body>

</html>
