<?php
include ("config.php");

session_start();
if (!isset ($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
    // }
// Unset all session variables
// foreach ($_SESSION as $key => $value) {
//     if ($key !== 'Employee_name') {
//         unset($_SESSION[$key]);
//     }
    // Start the session
// session_start();

    // // Save the session variable you want to keep in a separate variable
// $keepVariable = $_SESSION['variableToKeep'];

    // // Unset all session variables
// foreach ($_SESSION as $key => $value) {
//     if ($key !== 'variableToKeep') {
//         unset($_SESSION[$key]);
//     }
// }

    // // Restore the session variable you want to keep
// $_SESSION['variableToKeep'] = $keepVariable;

    // // Destroy the session
// session_destroy();

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            overflow-x: hidden;
            /* Prevent horizontal scrollbar */
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            /* Ensure the body covers the entire viewport height */
        }

        header {
            background-color: rgba(40, 57, 101, .9);
            color: white;
            padding: 20px;
            text-align: center;
            width: 100%;
            display: flex;
            justify-content: space-between;
            /* Adjusts the positioning of elements inside header */
            align-items: center;
            /* Align items vertically */
        }

        header h1 {
            font-family: 'Copperplate Gothic', sans-serif;
            /* Change the font of the h1 element */
            margin: 0;
            /* Remove default margin */
            flex-grow: 1;
            /* Allow the h1 element to grow and take up available space */
        }

        #logout {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            /* Add padding to style as a button */
            background-color: #1c0a6a;
            /* Button background color */
            border-radius: 5px;
            /* Rounded corners */
            margin-right: 20px;
            /* Add space between the "Dashboard" text and the logout button */
        }

        #nav-buttons {
            background-color: #1c0a6a;
            overflow: hidden;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        #nav-buttons a {
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            margin: 0 5px;
            border-radius: 5px;
        }

        #nav-buttons a:hover {
            background-color: #ddd;
            color: black;
        }

        section {
            padding: 20px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        footer {
            background-color: rgba(40, 57, 101, .9);
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
            margin-top: auto;
            /* Push footer to the bottom of the page */
        }

        #main-content span {
            font-family: "Copperplate Gothic", cursive;
            font-size: 100px;
            margin-right: 20px;
        }

        #main-content img {
            width: 500px;
            /* Set the size of the logo */
            height: auto;
        }
    </style>
</head>

<body>
    <header>
        <h1>Dashboard</h1>
        <a id="logout" href="logout.php">Logout</a> <!-- Logout button -->
    </header>

    <div id="nav-buttons">
        <a href="register.php">Add New Patient</a>
        <a href="doctors.php">Add New Doctor</a>
        <a href="checkUser.php">Make Appointment</a>
        <a href="doctors_data.php">Doctor DataBase</a>
        <a href="data.php">Users Database</a>
    </div>

    <section id="main-content">
        <div>
            <span>Welcome to Alshroouk</span>
            <br>
            <span>Scan and Lab</span>
        </div>
        <!-- Ensure the path to your image is correct -->
        <img src="el-shroouk-logo.png" alt="ElShroouk Scan and Lab Logo">
    </section>

    <footer>
        &copy; 2024 ALShroouk Scan and Lab
    </footer>
</body>

</html>