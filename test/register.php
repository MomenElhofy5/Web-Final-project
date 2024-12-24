<?php
include ("config.php");

session_start();
if (!isset ($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
}
// Query to retrieve data from the database
$sql = "SELECT Doctor_ID, 	Doctor_FirstName ,Doctor_LastName , Clinic_Number FROM doctor";
$doctors = $conn->query($sql);



if (isset ($_POST['submit'])) {


    $userName = mysqli_real_escape_string($conn, $_POST['user_name']);
    $branch_chosen = $_POST['branch_chosen'];
    $new_or_existing = $_POST['new_or_existing'];
    $date_format = 'Y-m-d';
    $user_birthday = DateTime::createFromFormat($date_format, $_POST['user_birthday']);
    $birthday = $user_birthday->format('Y-m-d');
    $user_phone = mysqli_real_escape_string($conn, $_POST['user_phone']);
    $preferred_contact_method = $_POST['preferred_contact_method'];



    $select = " SELECT * FROM customer WHERE user_phone = '$user_phone' ";
    $result = mysqli_query($conn, $select);
    if (mysqli_num_rows($result) > 0) {
        $error[] = 'Patient already exist!';
    } else {
        $_SESSION['userName'] = $userName;
        $_SESSION['branch_chosen'] = $branch_chosen;
        $_SESSION['new_or_existing'] = $new_or_existing;
        $_SESSION['birthday'] = $birthday;
        $_SESSION['user_phone'] = $user_phone;
        $_SESSION['preferred_contact_method'] = $preferred_contact_method;
        $insert = "INSERT INTO `customer` (
            `user_name`, `branch_chosen`, `new_or_existing`, `user_birthday`, `user_phone`, 
            `prefered_contact_method`) 
            VALUES (
            '{$_SESSION['userName']}', '{$_SESSION['branch_chosen']}', '{$_SESSION['new_or_existing']}', '{$_SESSION['birthday']}', '{$_SESSION['user_phone']}', 
            '{$_SESSION['preferred_contact_method']}')";

        // Execute the insert query
        mysqli_query($conn, $insert);

        // Retrieve the auto-incremented UserID
        $userID = mysqli_insert_id($conn);

        $_SESSION['userID'] = $userID;

        header('location:appointment.php');

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
        <label for="user_name">Full Name:</label>
        <input type="text" id="user_name" name="user_name" required>

        <label for="branch_chosen">Branch Chosen:</label>
        <select id="branch_chosen" name="branch_chosen" required>
            <option value="Medical Center 3">Medical Center 3</option>
            <option value="EMC">EMC</option>

        </select>

        <label for="new_or_existing">New or Existing Patient:</label>
        <select id="new_or_existing" name="new_or_existing" required>
            <option value="new">New</option>
            <option value="existing">Existing</option>
        </select>

        <label for="user_birthday">Date Of Birth:</label>
        <input type="date" id="user_birthday" name="user_birthday" required>

        <label for="user_phone">User Phone:</label>
        <input type="tel" id="user_phone" name="user_phone" required>

        <label for="preferred_contact_method">Preferred Contact Method:</label>
        <select id="preferred_contact_method" name="preferred_contact_method" required>
            <option value="email">Email</option>
            <option value="phone">Phone</option>
            <option value="text">Text</option>
        </select>
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

        <input type="submit" name="submit" value="Submit Registration">
    </form>

</body>

</html>