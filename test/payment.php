<?php
@include 'config.php';
session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
    exit;
}

// Validate and retrieve registered doctor details
$doctor = "SELECT * FROM doctor WHERE Doctor_ID = '" . $_SESSION["registered_doctor"] . "'";
$result_doctor = mysqli_query($conn, $doctor);

if (mysqli_num_rows($result_doctor) > 0) {
    $row = mysqli_fetch_array($result_doctor);
    $discount_percent = $row['Doctor_Discount'];
} else {
    $discount_percent = 0; // Default discount percentage
}

// Ensure userID is set in the session
if (!isset($_SESSION['userID'])) {
    die('User ID not set in session. Please log in again.');
}

// Handle form submission
if (isset($_POST['submit_payment'])) {
    // Retrieve form data
    $total_price = $_POST['total_price'];
    $discount_percent = $_POST['discount_percent'];
    $total_after_discount = $_POST['total_after_discount'];
    $amount_paid = $_POST['amount_paid'];
    $amount_left = $_POST['amount_left'];

    // Set session variables for later use
    $_SESSION['total_price'] = $total_price;
    $_SESSION['discount_percent'] = $discount_percent;
    $_SESSION['total_after_discount'] = $total_after_discount;
    $_SESSION['amount_paid'] = $amount_paid;
    $_SESSION['amount_left'] = $amount_left;

    // Insert into `visit` table
    $ins = "INSERT INTO `visit` (
        `UserID`, `Scan_Type`, `Registered_Doctor`, `Total_price`, 
        `Discount_Eligibility`, `Discount_percent`, `Discount_Reason`, `Final_Price`, 
        `Did_Customer_pay`, `Time_Stamp`, `Amount_Paid`, `Amount_left`, `user_Notes`, 
        `User_Exam_Date`, `Customer_Message`, `Doctor_ID`
    ) 
    VALUES (
        '{$_SESSION['userID']}', '{$_SESSION['scan_typeString']}', '{$_SESSION['registered_doctor']}', '$total_price', 
        '{$_SESSION["discountEligibility"]}', '$discount_percent', '{$_SESSION["discountReason"]}', '$total_after_discount', 
        NULL, current_timestamp(), '$amount_paid', '$amount_left', '{$_SESSION["userNotes"]}', '{$_SESSION["userExamDate"]}', NULL, NULL
    )";

    if (mysqli_query($conn, $ins)) {
        // Save visit ID in session and redirect
        $visitID = mysqli_insert_id($conn);
        $_SESSION['visitID'] = $visitID;
        header('location:invoice.php');
        exit;
    } else {
        die('Error inserting visit: ' . mysqli_error($conn));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Calculator</title>
    <style>
        /* Add your CSS here */
        body {
            font-family: Arial, sans-serif;
            background-color: #c8c8c8;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: rgba(40, 57, 101, .9);
        }

        header img {
            max-width: 100%;
            max-height: 170px;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: rgba(40, 57, 101, .9);
            color: white;
            padding: 10px 20px;
            border: none;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <header>
        <button onclick="goBack()">Back</button>
        <h2>Payment Calculator</h2>
        <img src="el-shroouk-logo.png" alt="El Shroouk Logo">
    </header>
    <div class="container">
        <form action="" method="post">
            <label for="total_price">Total Price:</label>
            <input type="number" id="total_price" name="total_price" value="<?php echo $_SESSION['totalPrice']; ?>" readonly>

            <label for="discount_percent">Discount Percent:</label>
            <input type="number" id="discount_percent" name="discount_percent" value="<?php echo $discount_percent; ?>" readonly>

            <button type="button" onclick="calculateTotal()">Calculate Total</button>

            <label for="total_after_discount">Total Price After Discount:</label>
            <input type="text" id="total_after_discount" name="total_after_discount" readonly>

            <label for="amount_paid">Amount Paid:</label>
            <input type="number" id="amount_paid" name="amount_paid" required>

            <button type="button" onclick="saveRemainingAmount()">Save Remaining Amount</button>

            <label for="amount_left">Remaining Amount:</label>
            <input type="text" id="amount_left" name="amount_left" readonly>

            <button type="submit" name="submit_payment">Submit</button>
        </form>
    </div>

    <script>
        function calculateTotal() {
            const totalPrice = parseFloat(document.getElementById('total_price').value) || 0;
            const discountPercent = parseFloat(document.getElementById('discount_percent').value) || 0;
            const discountAmount = (discountPercent / 100) * totalPrice;
            const totalAfterDiscount = totalPrice - discountAmount;
            document.getElementById('total_after_discount').value = totalAfterDiscount.toFixed(2);
        }

        function saveRemainingAmount() {
            const totalAfterDiscount = parseFloat(document.getElementById('total_after_discount').value) || 0;
            const amountPaid = parseFloat(document.getElementById('amount_paid').value) || 0;
            const amountLeft = totalAfterDiscount - amountPaid;
            document.getElementById('amount_left').value = amountLeft.toFixed(2);
        }

        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
