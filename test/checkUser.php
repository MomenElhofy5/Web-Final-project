<?php
include ("config.php");

session_start();
if (!isset ($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
}
// Query to retrieve data from the database
// $sql = "SELECT Doctor_ID, 	Doctor_FirstName ,Doctor_LastName , Clinic_Number FROM doctor";
// $doctors = $conn->query($sql);



if (isset ($_POST['submit'])) {



    $user_phone = mysqli_real_escape_string($conn, $_POST['user_phone']);

    $select = " SELECT * FROM customer WHERE user_phone = '$user_phone' ";
    $result = mysqli_query($conn, $select);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $_SESSION['userName'] = $row['user_name'];
        $_SESSION['user_phone'] = $row['user_phone'];
        header('location:appointment.php');
    } else {

        $error[] = 'Patient Phone Number is not found!';
        // header('location:appointment.php');

    }




}
;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration</title>
    <style>
        body {
            margin: 0;
            color: #6a6f8c;
            background: #c8c8c8;
            font: 600 16px/18px 'Open Sans', sans-serif;
        }

        *,
        :after,
        :before {
            box-sizing: border-box;
        }

        .clearfix:after,
        .clearfix:before {
            content: '';
            display: table;
        }

        .clearfix:after {
            clear: both;
            display: block;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        header {
            background-color: rgba(40, 57, 101, .9);
            color: white;
            text-align: center;
            padding: 1em;
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .back-button {
            background-color: rgba(40, 57, 101, .9);
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        header img {
            max-width: 150px;
            height: auto;
            position: absolute;
            top: 50%;
            right: 20px;
            transform: translateY(-50%);
        }

        h1 {
            flex-grow: 1;
            margin: 0;
        }

        form {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        input[type="tel"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }

        select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding: 12px;
            background: url('arrow-down.png') no-repeat right #fff;
            background-size: 20px;
            background-position: 95%;
        }

        .checkbox-group {
            margin-top: 8px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
        }

        input[type="checkbox"] {
            margin-top: 5px;
            margin-right: 5px;
        }

        input[type="submit"] {
            background-color: rgba(40, 57, 101, .9);
            color: white;
            padding: 14px 20px;
            border: none;
            margin-top: 20px;
            cursor: pointer;
            border-radius: 6px;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: rgba(40, 57, 101, .9);
        }

        hr {
            border: none;
            border-top: 1px solid #ddd;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        h2 {
            color: rgba(40, 57, 101, .9);
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <!-- <button class="back-button" onclick="goBack()">Back</button> -->
        <a href="dashboard.php"> <button class="back-button">Back</button></a>
        <img src="el-shroouk-logo.png" alt="El Shroouk Logo">
        <h1>Patient Registration</h1>
    </header>

    <form action="" method="post">
        <h2>Patient Information</h2>
        <p>
            <?php
            if (isset ($error)) {
                foreach ($error as $error) {
                    echo '<span style="color:#FF0000;" class="error-msg">' . $error . '</span>';
                }
                ;
            }
            ;
            ?>
        </p>
        <label for="user_name">Customer Phone Number:</label>
        <input type="text" id="user_name" name="user_phone" required>
        <input type="submit" name="submit" value="Submit Registration">
    </form>

</body>

</html>