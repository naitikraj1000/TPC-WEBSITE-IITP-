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

    echo "<h1>Form Data</h1>";
    // retrieve the form data
    $companies = isset($_POST['company']) ? $_POST['company'] : array();
    $package = isset($_POST['package']) ? $_POST['package'] : "";
    $number = isset($_POST['number']) ? $_POST['number'] : "";
    $eligibility = isset($_POST['eligibility']) ? $_POST['eligibility'] : "";
    $start_year = isset($_POST['start-year']) ? $_POST['start-year'] : "";
    $end_year = isset($_POST['end-year']) ? $_POST['end-year'] : "";
    $highest_package = isset($_POST['highest_Package']) ? $_POST['highest_Package'] : "";
    $median_package = isset($_POST['median_Package']) ? $_POST['median_Package'] : "";
    $lowest_package = isset($_POST['lowest_Package']) ? $_POST['lowest_Package'] : "";
    $specific_amount = isset($_POST['specific_amount']) ? $_POST['specific_amount'] : "";
    $cpi = isset($_POST['cpi']) ? $_POST['cpi'] : "";

    if ($cpi == null) {
        $cpi = 0;
    } else {
        $cpi_float = floatval($cpi);
    }

    $val = 0;
    $val = floatval($val);
    if ($specific_amount != null) {
        $val = $specific_amount;
        if ($val == 0) {
            $val = 0.0001;
        }

    }

    $specific_year = $start_year;
    $specific_year = intval($specific_year);
    // Convert the array to a comma-separated string for the query
    $company_list = implode(",", $companies);

    // Define the array to store the results
    $year_results = array();

    // Loop through the years and execute the query for each year
    for ($year = $specific_year; $year <= $end_year; $year++) {

        // Build the SQL query with the additional condition for the specific companies
        //     $sql = "SELECT
        // MAX(p.package) AS max_package,
        // AVG(p.package) AS avg_package,
        // MIN(p.package) AS min_package
        // FROM
        // placement p
        // INNER JOIN students_info s ON p.Roll_No = s.roll_no
        // INNER JOIN Companies c ON p.Company_ID = c.company_id
        // WHERE
        // p.Year = '" . $year . "' AND
        // s.overall_cpi >= '" . $cpi . "' AND
        // p.Package >= '" . $val . "' AND
        // c.Company_Name IN ('" . implode("','", $companies) . "')";


        $sql = "SELECT
    MAX(p.package) AS max_package,
    AVG(p.package) AS avg_package,
    MIN(p.package) AS min_package
    FROM
    placement p
    INNER JOIN students_info s ON p.Roll_No = s.roll_no
    INNER JOIN Companies c ON p.Company_ID = c.company_id
    WHERE
    p.Year = '" . $year . "' AND
    s.overall_cpi >= '" . $cpi . "' AND
    p.Package >= '" . $val . "' AND
    c.Company_Name IN ('" . implode("','", $companies) . "') AND
    s.batch_year = '" . $year . "' AND
    c.Registering_Year = '" . $year . "'";


        // Execute the query and retrieve the results
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        // Store the results in the array
        $year_results[$year] = array(
            'max_package' => $row['max_package'],
            'avg_package' => $row['avg_package'],
            'min_package' => $row['min_package'],
        );
    }

    if ($number == null) {
        // Print the results for each year
        // foreach ($year_results as $year => $results) {
        //     echo "Year: " . $year . "<br>";
        //     echo "Highest package: " . $results['max_package'] . "<br>";
        //     echo "Average package: " . $results['avg_package'] . "<br>";
        //     echo "Lowest package: " . $results['min_package'] . "<br>";

        // }
// Define the data for the chart

        if ($specific_amount != null) {
            $median_package = 0.1;
            $highest_package = 0.2;
            $lowest_package = 0.11;
        }
        // Define the data for the chart

        $data = array(
            'labels' => array_keys($year_results),
            'datasets' => array(),
        );

        if ($highest_package != null) {
            $data['datasets'][] = array(
                'label' => 'Max Package',
                'data' => array_column($year_results, 'max_package'),
                'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                'borderColor' => 'rgba(255, 99, 132, 1)',
                'borderWidth' => 2,
            );
        }

        if ($median_package != null) {
            $data['datasets'][] = array(
                'label' => 'Median Package',
                'data' => array_column($year_results, 'avg_package'),
                'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                'borderColor' => 'rgba(75, 192, 192, 1)',
                'borderWidth' => 2,
            );
        }

        if ($lowest_package != null) {
            $data['datasets'][] = array(
                'label' => 'Lowest Package',
                'data' => array_column($year_results, 'min_package'),
                'backgroundColor' => 'rgba(153, 102, 255, 0.2)',
                'borderColor' => 'rgba(153, 102, 255, 1)',
                'borderWidth' => 2,
            );
        }

        // Convert the data to a JSON string
        $data_json = json_encode($data);

        // Create the HTML for the chart
        $html = '<canvas id="myChart" width=1000px" height="600px"></canvas>';

        // Create the JavaScript for the chart
        $js = <<<JS
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

var ctx = document.getElementById('myChart').getContext('2d');
var data = $data_json;
var options = {
    responsive: false,
    scales: {
        yAxes: [{
            ticks: {
                beginAtZero: true
            }
        }]
    }
};
var chart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
});
</script>


<style>
    canvas {
        max-width: 100%;
    }

    .chart-container {
        position: relative;
        margin: auto;
        height: 60vh;
        width: 80vw;
    }

    #myChart {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
    }

    .chart-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .chart-legend {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .chart-legend li {
        display: flex;
        align-items: center;
        margin-right: 20px;
    }

    .chart-legend li span {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border-radius: 50%;
    }
</style>



JS;

        // Output the HTML and JavaScript
        echo '<div class="chart-container">' . $html . '</div>' . $js;

    } else {

        $number_year_results = array();
        if ($specific_amount != null) {

            for ($year = $start_year; $year <= $end_year; $year++) {


                // $sql = "SELECT COUNT(*) as count
                //         FROM
                //         placement p
                //         INNER JOIN students_info s ON p.Roll_No = s.roll_no
                //         WHERE
                //         p.Year = '" . $year . "' AND
                //         s.overall_cpi >= '" . $cpi . "' AND
                //         p.Package >= '" . $val . "'";

                $sql = "SELECT COUNT(*) as count
                FROM
                placement p
                INNER JOIN students_info s ON p.Roll_No = s.roll_no
                INNER JOIN Companies c ON p.Company_ID = c.company_id
                WHERE
                p.Year = '" . $year . "' AND
                s.overall_cpi >= '" . $cpi . "' AND
                c.Company_Name IN ('" . implode("','", $companies) . "') AND
                p.Package >= '" . $val . "' AND
                s.batch_year = '" . $year . "' AND
                c.Registering_Year = '" . $year . "'";
        


                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $count = $row['count'];
                $number_year_results[$year] = $count;
            }

        } else {

            foreach ($year_results as $year => $results) {
                if ($highest_package != null) {
                    $val = $results['max_package'];
                } else if ($median_package != null) {
                    $val = $results['avg_package'];
                } else {
                    $val = $results['min_package'];
                }

                // $sql = "SELECT COUNT(*) as count
                // FROM
                // placement p
                // INNER JOIN students_info s ON p.Roll_No = s.roll_no
                // WHERE
                // p.Year = '" . $year . "' AND
                // s.overall_cpi >= '" . $cpi . "' AND
                // p.Package >= '" . $val . "'";

                $sql = "SELECT COUNT(*) as count
                FROM
                placement p
                INNER JOIN students_info s ON p.Roll_No = s.roll_no
                INNER JOIN Companies c ON p.Company_ID = c.company_id
                WHERE
                p.Year = '" . $year . "' AND
                s.overall_cpi >= '" . $cpi . "' AND
                c.Company_Name IN ('" . implode("','", $companies) . "') AND
                p.Package >= '" . $val . "' AND
                s.batch_year = '" . $year . "' AND
                c.Registering_Year = '" . $year . "'";
        
   


                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $count = $row['count'];
                $number_year_results[$year] = $count;
            }
        }

        // Print the results for each year
        // foreach ($number_year_results as $year => $results) {
        //     echo "Year: " . $year . "<br>";
        //     echo "Highest package: " . $number_year_results[$year] . "<br>";
        // }


        // Include the Chart.js library
        echo '<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>';

        // Create an array of labels and data
        $labels = array_keys($number_year_results);
        $data = array_values($number_year_results);

        // Create a canvas element to display the chart
        echo '<canvas id="myChart" width="1000" height="600"></canvas>';


        // Create a script to initialize the chart
        echo '<script>
var ctx = document.getElementById("myChart").getContext("2d");
var chart = new Chart(ctx, {
    type: "bar",
    data: {
        labels: ' . json_encode($labels) . ',
        datasets: [{
            label: "Number of placements",
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
    }


}