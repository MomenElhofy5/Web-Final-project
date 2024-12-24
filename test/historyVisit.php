<?php
include ("config.php");
session_start();

if (!isset ($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
    exit();
} else {
    // Default query to fetch all data
    if (isset ($_GET['id'])) {
        // Retrieve the user ID from the URL
        $userID = mysqli_real_escape_string($conn, $_GET['id']);
        $userName = $_GET['name'];

        // Fetch user history based on the user ID
        $sql = "SELECT * FROM visit WHERE UserID = '$userID'";
        $result = mysqli_query($conn, $sql);
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
        <a href="data.php"> <button class="back-button">Back</button></a>
        <h1>Database Viewer</h1>
        <img src="el-shroouk-logo.png" alt="Your Logo">
    </header>

    <form method="GET">
        <input type="text" name="search" placeholder="Search...">
        <button type="submit">Search</button>
    </form>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Patient Name</th>
                    <th>Scan Type</th>
                    <th>Registered Doctor</th>
                    <th>Total price</th>
                    <th>Discount Eligibility</th>
                    <th>Discount percent</th>
                    <th>Discount Reason</th>
                    <th>Final_Price</th>
                    <th>Time Stamp</th>
                    <th>Amount Paid</th>
                    <th>Amount_left</th>
                    <th>user_Notes</th>
                    <th>User_Exam_Date</th>
                   
                </tr>
                <a href=""></a>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        echo "<tr>";
                        // echo "<td>" . $row['UserID'] . "</td>"; user_name
                        echo "<td>" . $userName . "</td>";
                        echo "<td>" . $row['Scan_Type'] . "</td>";
                        echo "<td>" . $row['Registered_Doctor'] . "</td>";
                        echo "<td>" . $row['Total_price'] . "</td>";
                        echo "<td>" . $row['Discount_Eligibility'] . "</td>";
                        echo "<td>" . $row['Discount_percent'] . "</td>";
                        echo "<td>" . $row['Discount_Reason'] . "</td>";
                        // echo "<td>" . $row['Discount_percent'] . "</td>";
                        echo "<td>" . $row['Final_Price'] . "</td>";
                        echo "<td>" . $row['Time_Stamp'] . "</td>";
                        echo "<td>" . $row['Amount_Paid'] . "</td>";
                        echo "<td>" . $row['Amount_left'] . "</td>";
                        echo "<td>" . $row['user_Notes'] . "</td>";
                        echo "<td>" . $row['User_Exam_Date'] . "</td>";
                 

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
        
    </script>

</body>

</html>
