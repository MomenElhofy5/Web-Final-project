<?php
@include 'config.php';
session_start();
if (!isset ($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
}
if (isset ($_POST['submit'])) {
    // Prepare and bind parameters
    // Set parameters and execute
    $doctor_first_name = $_POST['doctor_first_name'];
    $doctor_last_name = $_POST['doctor_last_name'];
    $doctor_email = $_POST['doctor_email'];
    $doctor_phone = $_POST['doctor_phone'];
    $clinic_number = $_POST['clinic_number'];
    $clinic_address = $_POST['clinic_address'];
    $doctor_discount = $_POST['doctor_discount'];
    $clinic_name = $_POST['clinic_name'];

    $select = " SELECT * FROM doctor WHERE Doctor_Phone = '$doctor_phone' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $error[] = 'Doctor already exist!';

    } else {


        $insert = "INSERT INTO doctor (Doctor_FirstName, Doctor_LastName, Doctor_Email, Doctor_Phone, Clinic_Number, Clinic_Address, Doctor_Discount, Clinic_Name) 
       VALUES (
     '$doctor_first_name', '$doctor_last_name', '$doctor_email', '$doctor_phone', '$clinic_number', '$clinic_address', '$doctor_discount', '$clinic_name')";

        mysqli_query($conn, $insert);
        header('location:dashboard.php');

    }

}
;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>
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
            max-width: 600px;
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
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
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
        <a href="dashboard.php"><button class="back-button">Back</button></a>
        <img src="el-shroouk-logo.png" alt="Your Logo">
        <h1>Doctor Registration</h1>
    </header>

    <form action="" method="post">

        <h2>Doctor Information</h2>

        <label for="doctor_first_name">First Name:</label>
        <input type="text" id="doctor_first_name" name="doctor_first_name" required>

        <label for="doctor_last_name">Last Name:</label>
        <input type="text" id="doctor_last_name" name="doctor_last_name" required>

        <label for="doctor_email">Email:</label>
        <input type="email" id="doctor_email" name="doctor_email" required>

        <label for="doctor_phone">Phone:</label>
        <input type="tel" id="doctor_phone" name="doctor_phone" required>

        <label for="clinic_number">Clinic Number:</label>
        <input type="text" id="clinic_number" name="clinic_number" required>

        <label for="clinic_address">Clinic Address:</label>
        <textarea id="clinic_address" name="clinic_address" rows="4" required></textarea>

        <label for="doctor_discount">Doctor Discount:</label>
        <input type="number" id="doctor_discount" name="doctor_discount" required>

        <label for="clinic_name">Clinic Name:</label>
        <input type="text" id="clinic_name" name="clinic_name" required>

        <!-- <button name="submit">Register Doctor </button> -->
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
        <input type="submit" name="submit" value="Register Doctor">

    </form>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>