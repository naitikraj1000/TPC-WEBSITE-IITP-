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
    $companies = isset($_POST['company']) ? $_POST['company'] : array();
    $start_year = isset($_POST['start-year']) ? $_POST['start-year'] : "";
    $end_year = isset($_POST['end-year']) ? $_POST['end-year'] : "";
    $cpi = isset($_POST['cpi']) ? $_POST['cpi'] : "";
    $specific_amount = isset($_POST['specific_amount']) ? $_POST['specific_amount'] : "";


    // echo "<p><strong>Companies:</strong> " . implode(", ", $companies) . "</p>";
    // echo "<p><strong>Package:</strong> " . $package . "</p>";
    // echo "<p><strong>Number:</strong> " . $number . "</p>";
    // echo "<p><strong>Eligibility:</strong> " . $eligibility . "</p>";
    // echo "<p><strong>Start Year:</strong> " . $start_year . "</p>";
    // echo "<p><strong>End Year:</strong> " . $end_year . "</p>";
    // echo "<p><strong>Highest Package:</strong> " . $highest_package . "</p>";
    // echo "<p><strong>Median Package:</strong> " . $median_package . "</p>";
    // echo "<p><strong>Lowest Package:</strong> " . $lowest_package . "</p>";
    // echo "<p><strong>Specific Amount:</strong> " . $specific_amount . "</p>";
    // echo "<p><strong>CPI:</strong> " . $cpi . "</p>";

    // Retrieve company ID from Companies table based on company name

    // Retrieve eligible students for each company and store the results in an array
    $companyCounts = array();
    foreach ($companies as $companyName) {
        $sql = "SELECT company_id FROM Companies WHERE Company_Name = '$companyName'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $companyId = intval($row["company_id"]);
            $sql = "SELECT COUNT(*) as count 
        FROM students_info 
        JOIN placement ON students_info.roll_no = placement.Roll_No 
        JOIN Companies ON placement.Company_ID = Companies.company_id
        AND Companies.Registering_Year  = students_info.batch_year 
        WHERE students_info.batch_year BETWEEN $start_year AND $end_year 
        AND students_info.overall_cpi >= $cpi 
        AND students_info.package < $specific_amount  AND Companies.company_id=$companyId";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $count = intval($row["count"]);
                $companyCounts[$companyName] = $count;
            }
        } else {
            echo "Company not found: $companyName.<br>";
        }
    }

    // Generate data for Chart.js
    $companyNames = array_keys($companyCounts);
    $counts = array_values($companyCounts);
    $chartData = array(
        'labels' => $companyNames,
        'datasets' => array(
            array(
                'label' => 'Eligible Students',
                'backgroundColor' => 'rgba(54, 162, 235, 0.5)',
                'borderColor' => 'rgba(54, 162, 235, 1)',
                'borderWidth' => 1,
                'data' => $counts,
            )
        )
    );

    // Generate options for Chart.js
    $chartOptions = array(
        'responsive' => false,
        'scales' => array(
            'yAxes' => array(
                array(
                    'ticks' => array(
                        'beginAtZero' => true,
                    ),
                ),
            ),
        ),
    );
    // echo "Total No of Eligible Students: $ans.<br>";

}
?>

<!-- // Generate HTML and JavaScript for Chart.js -->
<div>
    <canvas id="myChart"></canvas>
</div>
<style>
    #myChart {
        width: 1000;
        height: 600;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: <?php echo json_encode($chartData); ?>,
    options: <?php echo json_encode($chartOptions); ?>
});
</script>

