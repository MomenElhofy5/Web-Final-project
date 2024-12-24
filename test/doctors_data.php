<?php
include ("config.php");
session_start();
if (!isset ($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
} else {
    // Default query to fetch all data
    $sql = "SELECT * FROM doctor";
    $result = mysqli_query($conn, $sql);

    // Function to handle filtering
    function filterData($conn, $searchTerm)
    {
        $sql = "SELECT * FROM doctor WHERE Doctor_Phone LIKE '%$searchTerm%'";
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    if (isset ($_GET['search'])) {
        $searchTerm = mysqli_real_escape_string($conn, $_GET['search']);
        $result = filterData($conn, $searchTerm);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Table</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <!-- <button class="back-button" onclick="goBack()">Back</button> -->
        <!-- <button class="back-button"><a href="dashboard.php">Back</a></button> -->
        <a href="dashboard.php"> <button class="back-button">Back</button></a>
        <h1>Database Viewer</h1>
        <img src="el-shroouk-logo.png" alt="Your Logo">
    </header>

    <form method="GET">
        <input type="text" name="search" placeholder="Search with Phone Number">
        <button type="submit">Search</button>
    </form>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Clinic Number</th>
                    <th>Clinic Address</th>
                    <th>Doctor Discount</th>
                    <th>Clinic_Name</th>

                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['Doctor_ID'] . "</td>";
                        echo "<td>" . $row['Doctor_FirstName'] . " " . $row['Doctor_LastName'] . "</td>";
                        echo "<td>" . $row['Doctor_Email'] . "</td>";
                        echo "<td>" . $row['Doctor_Phone'] . "</td>";
                        echo "<td>" . $row['Clinic_Number'] . "</td>";
                        echo "<td>" . $row['Clinic_Address'] . "</td>";
                        echo "<td>" . $row['Doctor_Discount'] . "</td>";
                        echo "<td>" . $row['Clinic_Name'] . "</td>";


                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td class='no-data' colspan='11'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function goBack() {
            window.history.back();
        }
        // window.addEventListener('beforeunload', function (event) {
        //     // Send AJAX request to end session
        //     var xhr = new XMLHttpRequest();
        //     xhr.open('GET', 'logout.php', true);
        //     xhr.send();
        // });
    </script>

</body>

</html>