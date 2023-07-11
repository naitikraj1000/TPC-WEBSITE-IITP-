<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $servername = "localhost";
    $username = "naitik";
    $password = "naitik";
    $dbname = "register";

    // create database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // check if connection is successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve the values from the form
    $startYear = $_POST['start-year'];
    $endYear = $_POST['end-year'];
    $topPackage = $_POST['top_package'];

    // Do something with the input values, e.g. display them
    // echo "Starting year: " . $startYear . "<br>";
    // echo "Ending year: " . $endYear . "<br>";
    // echo "Top package: " . $topPackage . "<br>";

    if ($topPackage == NULL) {
        // Q->3

        $results = array(); // initialize empty array to store results

        for ($year = $startYear; $year <= $endYear; $year++) {
            $sql = "SELECT COUNT(*) as count FROM Companies WHERE `Registering_Year` = $year";
            $result = $conn->query($sql);

            // Get result count and store in array
            $count = $result->fetch_assoc()["count"];
            $results[$year] = $count;
        }


        // echo $count;

        // Bar Graph

        // Include the Chart.js library
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

        // Create an array of labels and data
        $labels = array_keys($results);
        $data = array_values($results);

        echo '<canvas id="myChart" width="1000" height="600"></canvas>';

        echo '<script>
        var ctx = document.getElementById("myChart").getContext("2d");
        var chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ' . json_encode($labels) . ',
                datasets: [{
                    label: "Number of Companies",
                    data: ' . json_encode($data) . ',
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                animation: {
                    duration: 2000,
                    easing: "easeOutQuart"
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        </script>';

    } else {

        // $sql = "SELECT p.Company_ID, c.Company_Name FROM placement p INNER JOIN Companies c ON p.Company_ID = c.company_id WHERE p.Year BETWEEN $startYear AND $endYear ORDER BY p.Package DESC LIMIT $topPackage";
        $sql = "SELECT DISTINCT c.Company_Name,c.company_id
        FROM Companies c
        INNER JOIN (
            SELECT p.Company_ID
            FROM placement p
            WHERE p.Year BETWEEN $startYear AND $endYear
            ORDER BY p.Package DESC
            LIMIT $topPackage
        ) AS p
        ON c.company_id = p.Company_ID";

        $result = $conn->query($sql);

        // Output result

        // If there are any results, print them in a table
        if ($result->num_rows > 0) {
            echo '<table class="my-table">';
            echo '<thead><tr><th>Company Name</th></tr></thead>';
            echo '<tbody>';
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td class="company-name">' . $row["Company_Name"] . ' (ID: ' . $row["company_id"] . ')</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo "No results found";
        }

    }

}
?>


<!-- CSS -->
<style>
    .my-table {
        border-collapse: collapse;
        width: 100%;
    }

    .my-table th,
    .my-table td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }

    .my-table th {
        background-color: #ddd;
        font-weight: bold;
    }

    .company-name {
        font-weight: bold;
        font-size: 25px;
        color: blue;
        text-transform: uppercase;
        animation: color-change 1s ease-in-out infinite alternate;
    }

    @keyframes color-change {
        from {
            color: blue;
        }

        to {
            color: red;
        }
    }
</style>