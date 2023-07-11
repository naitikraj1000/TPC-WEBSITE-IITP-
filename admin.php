<html>
<style>
    .table-list {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }

    .table-list h2 {
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .table-list a {
        display: block;
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        text-decoration: none;
        color: #333;
        font-size: 18px;
        font-weight: bold;
    }

    .table-list a:hover {
        background-color: #f5f5f5;
    }
</style>

<div class="table-list">
    <h2>Table List</h2>
    <?php
    session_start(); // Start the session
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
    if (isset($_SESSION['username'])) {
        // User is logged in, display the logout link
        echo "Welcome, " . $_SESSION['username'] . "! ";
    } else {
        header("Location: tpc.html");
        exit();
    }

    // get all the table names
    $tables = array();
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_array()) {
        $tables[] = $row[0];
    }

    // display the tables as links
    foreach ($tables as $table) {
        echo "<a href=\"table.php?table=$table\">$table</a><br>";
    }
    echo "<a href='logout.php' style='color: blue; text-decoration: none;'>Logout</a>";
    
    // close the database connection
    $conn->close();
    ?>
</div>

</html>