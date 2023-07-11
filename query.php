<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="query.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="query.js"></script>
    <script>

        function uncheckAllCheckboxes() {

            var checkboxes = document.getElementsByName('highest_Package');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
            checkboxes = document.getElementsByName('median_Package');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }

            checkboxes = document.getElementsByName('lowest_Package');
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }

        }



        function uncheckOtherCheckboxes(clickedCheckboxName) {

            var amountInput = document.getElementById('specific_amount');
            amountInput.value = '';

            var checkboxes = document.getElementsByName('highest_Package');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].name !== clickedCheckboxName) {
                    checkboxes[i].checked = false;
                }
            }
            checkboxes = document.getElementsByName('median_Package');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].name !== clickedCheckboxName) {
                    checkboxes[i].checked = false;
                }
            }
            checkboxes = document.getElementsByName('lowest_Package');
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].name !== clickedCheckboxName) {
                    checkboxes[i].checked = false;
                }
            }
        }


    </script>
</head>

<body>
    <!-- Student and Package Data -->
    <h2 class="center-heading animate__animated animate__bounce">Student and Package Data</h2>
    <nav>
        <form action="query_result_student.php" method="POST">
            <div class="dropdown-menu">
                <button class="menu-btn">Company</button>
                <div class="menu-content">
                    <div class="checkbox-container">
                        <label>
                            <input type="checkbox" name="all" value="All" onchange="toggleCheckboxes(this)">
                            All
                        </label>


                        <?php
                        // database connection details
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

                        // retrieve company data from the database
                        $sql = "SELECT company_name FROM Company";
                        $result = mysqli_query($conn, $sql);

                        // display the company data in the checkboxes
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<label>';
                                echo '<input type="checkbox" name="company[]" value="' . $row["company_name"] . '">';
                                echo $row["company_name"];
                                echo '</label>';
                            }
                        } else {
                            echo "No companies found";
                        }

                        // close database connection
                        mysqli_close($conn);
                        ?>

                    </div>
                </div>
            </div>

            <div class="dropdown-menu">
                <button class="menu-btn">Option</button>
                <div class="menu-content">
                    <div class="checkbox-container">
                        <label>
                            <input type="checkbox" name="package" value="Package" onchange="hide_package(this)">
                            Package
                        </label>
                        <label>
                            <input type="checkbox" name="number" value="Number">
                            Number
                        </label>

                        <label>
                            <input type="checkbox" name="eligibility" value="Eligibility"
                                onchange="hide_eligiblity(this)">
                            Eligibility
                        </label>
                    </div>

                </div>
            </div>



            <div class="dropdown-menu">

                <button class="menu-btn">Year</button>
                <div class="menu-content">

                    <div class="year-dropdown">
                        <label for="start-year">Starting Year:</label>
                        <input type="number" id="start-year" name="start-year" placeholder="e.g. 2020">
                    </div>
                    <div class="year-dropdown">
                        <label for="end-year">Ending Year:</label>
                        <input type="number" id="end-year" name="end-year" placeholder="e.g. 2022">
                    </div>

                </div>

            </div>

            <div class="hide_menu" id="hide_menu">
                <div class="dropdown-menu">
                    <button class="menu-btn">Package</button>
                    <div class="menu-content">

                        <label>
                            <input type="checkbox" name="highest_Package" value="Highest_Package"
                                onclick="uncheckOtherCheckboxes('highest_Package')">
                            Highest_Package
                        </label>

                        <label>
                            <input type="checkbox" name="median_Package" value="Median_Package"
                                onclick="uncheckOtherCheckboxes('median_Package')">
                            Median_Package
                        </label>

                        <label>
                            <input type="checkbox" name="lowest_Package" value="Lowest_Package"
                                onclick="uncheckOtherCheckboxes('lowest_Package')">
                            Lowest_Package
                        </label>

                        <div class="year-dropdown">
                            <label for="specific_amount">Amount:</label>
                            <input type="number" id="specific_amount" name="specific_amount" placeholder="22 Lakh"
                                oninput="uncheckAllCheckboxes()">
                        </div>

                    </div>
                </div>
            </div>

            <div class="hide_menus" id="hide_menus">
                <div class="dropdown-menu">
                    <button class="menu-btn">Eligibility</button>
                    <div class="menu-content">
                        <div class="year-dropdown">
                            <label for="cpi">CPI:</label>
                            <input type="number" id="cpi" name="cpi" step="any" placeholder="eg: 8.2">

                        </div>
                    </div>
                </div>

            </div>


            <div class="dropdown-menu">
                <button class="menu-btn" type="submit">Search</button>
                </a>
            </div>

        </form>

    </nav>


    <!-- Company Data -->
    <h2 class="center-heading animate__animated animate__bounce">Company Data</h2>
    <nav>
        <form action="query_result_company.php" method="POST">

            <div class="dropdown-menu">

                <button class="menu-btn">Year</button>
                <div class="menu-content">

                    <div class="year-dropdown">
                        <label for="start-year">Starting Year:</label>
                        <input type="number" id="start-year" name="start-year" placeholder="e.g. 2020">
                    </div>
                    <div class="year-dropdown">
                        <label for="end-year">Ending Year:</label>
                        <input type="number" id="end-year" name="end-year" placeholder="e.g. 2022">
                    </div>

                </div>

            </div>



            <div class="dropdown-menu">
                <button class="menu-btn">Option</button>
                <div class="menu-content">
                    <div class="year-dropdown">
                        <label for="cpi">Top Package:</label>
                        <input type="number" id="top_package" name="top_package" placeholder="Enter the number">
                    </div>
                </div>
            </div>



            <div class="dropdown-menu">
                <button class="menu-btn" type="submit">Search</button>
                </a>
            </div>
        </form>
    </nav>


    <!-- Company and Student data -->

    <h2 class="center-heading animate__animated animate__bounce">Student And Company Data</h2>
    <nav>
        <form action="query_result_student_company.php" method="POST">

            <div class="dropdown-menu">
                <button class="menu-btn">Company</button>
                <div class="menu-content">
                    <div class="checkbox-container">
                        <label>
                            <input type="checkbox" name="all" value="All" onchange="toggleCheckboxes(this)">
                            All
                        </label>


                        <?php
                        // database connection details
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

                        // retrieve company data from the database
                        $sql = "SELECT company_name FROM Company";
                        $result = mysqli_query($conn, $sql);

                        // display the company data in the checkboxes
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<label>';
                                echo '<input type="checkbox" name="company[]" value="' . $row["company_name"] . '">';
                                echo $row["company_name"];
                                echo '</label>';
                            }
                        } else {
                            echo "No companies found";
                        }

                        // close database connection
                        mysqli_close($conn);
                        ?>

                    </div>
                </div>
            </div>


            <div class="dropdown-menu">

                <button class="menu-btn">Year</button>
                <div class="menu-content">

                    <div class="year-dropdown">
                        <label for="start-year">Starting Year:</label>
                        <input type="number" id="start-year" name="start-year" placeholder="e.g. 2020">
                    </div>
                    <div class="year-dropdown">
                        <label for="end-year">Ending Year:</label>
                        <input type="number" id="end-year" name="end-year" placeholder="e.g. 2022">
                    </div>

                </div>

            </div>


            <div class="dropdown-menu">
                <button class="menu-btn">CPI</button>
                <div class="menu-content">
                    <div class="year-dropdown">
                        <label for="cpi">CPI:</label>
                        <input type="number" id="cpi" name="cpi" step="any" placeholder="eg: 8.2">
                    </div>
                </div>

            </div>


            <div class="dropdown-menu">
                <button class="menu-btn">Package</button>
                <div class="menu-content">
                    <div class="year-dropdown">
                    <label for="specific_amount">Amount:</label>
                            <input type="number" id="specific_amount" name="specific_amount" placeholder="22 Lakh">
                    </div>
                </div>

            </div>


            <div class="dropdown-menu">
                <button class="menu-btn" type="submit">Search</button>
                </a>
            </div>

        </form>
    </nav>

</body>

</html>