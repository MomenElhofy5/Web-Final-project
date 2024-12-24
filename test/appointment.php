<?php
include ("config.php");

session_start();
if (!isset ($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
}
if (!isset ($_SESSION['user_phone'])) {
    header('location:Loginpage.php');
}
// Query to retrieve data from the database
$sql = "SELECT Doctor_ID, 	Doctor_FirstName ,Doctor_LastName , Clinic_Number FROM doctor";
$doctors = $conn->query($sql);



if (isset ($_POST['submit'])) {

    $scan_type = $_POST['scan_type'];
    $scan_typeString = implode(',', $scan_type);
    $registered_doctor = $_POST['registered_doctor'];

    // Retrieve values from the form and store them in PHP variables
    $date_format = 'Y-m-d';
    $discountEligibility = $_POST["discount_eligibility"];
    $discountReason = isset ($_POST["discount_reason"]) ? $_POST["discount_reason"] : ""; // Handle if discount_reason is not set
    $userNotes = $_POST["user_notes"];
    $Exam_date_formate = DateTime::createFromFormat($date_format, $_POST['user_exam_date']);
    $userExamDate = $Exam_date_formate->format('Y-m-d');
    ;

    // $select = " SELECT * FROM user WHERE user_phone = '$user_phone' ";
    // $result = mysqli_query($conn, $select);
    // if (mysqli_num_rows($result) > 0) {
    //     $error[] = 'User name already exist!';
    // } else {
    $totalPrice = 0;

    // Loop through each scan type
    foreach ($scan_type as $scan_type) {
        // Prepare and execute query to get price for current scan type
        $stmt = $conn->prepare("SELECT Scan_Type_Price FROM scan_type WHERE Scan_Type = ?");
        $stmt->bind_param("s", $scan_type);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch price from the result set
        if ($row = $result->fetch_assoc()) {
            // Add price to total price
            $totalPrice += $row['Scan_Type_Price'];
        } else {
            // If price not found, handle the situation (e.g., show error message)
            echo "Price not found for scan type: " . $scan_type . "<br>";
        }

        // Close statement
        $stmt->close();
    }
    $_SESSION['scan_typeString'] = $scan_typeString;
    $_SESSION['registered_doctor'] = $registered_doctor;
    $_SESSION['totalPrice'] = $totalPrice;
    //
    $_SESSION["discountEligibility"] = $discountEligibility;
    $_SESSION["discountReason"] = $discountReason; // Handle if discount_reason is not set
    $_SESSION["userNotes"] = $userNotes;
    $_SESSION["userExamDate"] = $userExamDate;

    header('location:payment.php');

    // }




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
        <button class="back-button" onclick="goBack()">Back</button>
        <!-- <a href="register.php"> <button class="back-button">Back</button></a> -->
        <img src="el-shroouk-logo.png" alt="El Shroouk Logo">
        <h1>Patient Appointment</h1>
    </header>

    <form action="" method="post">
        <h2>Patient Information</h2>
        <label for="scan_type">Scan Type:</label>
        <div class="checkbox-group">
            <label><input type="checkbox" id="panoramic_adult_full_arch" name="scan_type[]"
                    value="Panoramic Adult Full Arch"> Panoramic Adult Full Arch</label>
            <label><input type="checkbox" id="panoramic_adult_half_arch" name="scan_type[]"
                    value="Panoramic Adult Half Arch"> Panoramic Adult Half Arch</label>
            <label><input type="checkbox" id="panoramic_child_full_arch" name="scan_type[]"
                    value="Panoramic Child Full Arch"> Panoramic Child Full Arch</label>
            <label><input type="checkbox" id="panoramic_sinus" name="scan_type[]" value="Panoramic Sinus"> Panoramic
                Sinus</label>
            <label><input type="checkbox" id="panoramic_tmj" name="scan_type[]" value="Panoramic TMJ"> Panoramic
                TMJ</label>
            <label><input type="checkbox" id="ceph_image" name="scan_type[]" value="Ceph Image(2D Cephalometry)"> Ceph
                Image (2D Cephalometry)</label>
            <label><input type="checkbox" id="ceph_profile" name="scan_type[]"
                    value="Ceph Profile(Complete Orthodontic Study)"> Ceph Profile (Complete Orthodontic Study)</label>
            <label><input type="checkbox" id="ceph_analysis" name="scan_type[]" value="Ceph Analysis(Tracing)"> Ceph
                Analysis (Tracing)</label>
            <label><input type="checkbox" id="cbct_full_arch" name="scan_type[]" value="3D CBCT Full Arch"> 3D CBCT Full
                Arch</label>
            <label><input type="checkbox" id="cbct_half_arch" name="scan_type[]" value="3D CBCT Half Arch"> 3D CBCT Half
                Arch</label>
            <label><input type="checkbox" id="cbct_quadrant" name="scan_type[]" value="3D CBCT Quadrant"> 3D CBCT
                Quadrant</label>
            <label><input type="checkbox" id="cbct_sinus" name="scan_type[]" value="3D Sinus"> 3D Sinus</label>
            <label><input type="checkbox" id="cbct_tmj" name="scan_type[]" value="3D TMJ"> 3D TMJ</label>
            <label><input type="checkbox" id="cbct_endo_one_tooth" name="scan_type[]" value="3D CBCT Endo one tooth"> 3D
                CBCT Endo one tooth</label>
            <label><input type="checkbox" id="half_bite_wing" name="scan_type[]" value="Half Bite wing 2D Panorama">
                Half Bite wing 2D Panorama</label>
            <label><input type="checkbox" id="package_cbct" name="scan_type[]"
                    value="Package CBCT +2 Panoramic Adult Full Arch"> Package CBCT +2 Panoramic Adult Full Arch</label>
            <label><input type="checkbox" id="panoramic_ceph" name="scan_type[]" value="2D Panoramic +Ceph Image"> 2D
                Panoramic +Ceph Image</label>
            <label><input type="checkbox" id="periapical_x_ray" name="scan_type[]" value="Periapical X-Ray"> Periapical
                X-Ray</label>
            <!-- Add more checkboxes as needed -->
        </div>

        <label for="registered_doctor">Registered Doctor:</label>
        <select id="registered_doctor" name="registered_doctor" required>
            <option value=null> none</option>
            <?php
            // Check if there are rows returned
            if ($doctors->num_rows > 0) {
                // Loop through each row
                while ($row = $doctors->fetch_assoc()) {
                    echo "<option value='" . $row["Doctor_ID"] . "'>" . $row['Clinic_Number'] . " " . $row["Doctor_FirstName"] . " " . $row["Doctor_LastName"] . "</option>";

                }
            } else {
                echo "<option value=''>No options available</option>";
            }
            ?>
        </select>

        <!-- Add the remaining form fields similarly -->

        <hr>

        <h2>Discount Information</h2>
        <label for="discount_eligibility">Discount Eligibility:</label>
        <select id="discount_eligibility" name="discount_eligibility" required onchange="toggleDiscountReason()">
            <option value="yes">Yes</option>
            <option value="no" selected>No</option> <!-- Set default value to "No" -->
        </select>

        <label for="discount_reason" id="discountReasonLabel">Discount Reason:</label>
        <select id="discount_reason" name="discount_reason" required disabled>
            <option value="" disabled selected>Select a reason</option>
            <option value="Referred Patient">Referred Patient</option>
            <option value="Doctor / Doctor Relative">Doctor / Doctor Relative</option>
            <option value="Workers / Workers Relatives">Workers / Workers Relatives</option>
            <option value="People in Need">People in Need</option>
            <option value="Approved by Management">Approved by Management</option>
        </select>

        <script>
            function toggleDiscountReason() {
                var discountEligibility = document.getElementById("discount_eligibility");
                var discountReason = document.getElementById("discount_reason");
                var discountReasonLabel = document.getElementById("discountReasonLabel");

                if (discountEligibility.value === "yes") {
                    discountReason.disabled = false;
                    discountReasonLabel.style.display = "block";
                } else {
                    discountReason.disabled = true;
                    discountReasonLabel.style.display = "none";
                }
            }
        </script>

        <hr>

        <h2>Additional Notes</h2>
        <label for="user_notes">User Notes:</label>
        <textarea id="user_notes" name="user_notes"></textarea>

        <label for="user_exam_date">User Exam Date:</label>
        <input type="date" id="user_exam_date" name="user_exam_date" required>



        <input type="submit" name="submit" value="Submit Registration">
        <!-- <button name="submit">Submit Registration</button> -->
    </form>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>