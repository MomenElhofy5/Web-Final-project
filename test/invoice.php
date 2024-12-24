<?php
// Fetch invoice data from database (replace this with your database retrieval code)
include ("config.php");

session_start();
if (!isset ($_SESSION['Employee_name'])) {
    header('location:Loginpage.php');
}
if (isset ($_SESSION['userName'])) {
    $customer_name = $_SESSION['userName'];
    $invoice_number = $_SESSION['visitID'];
    $total_amount = $_SESSION['totalPrice'];
    $scan_type = $_SESSION['scan_typeString'];
    $exam_date = $_SESSION["userExamDate"];
}
if (isset ($_POST['DashBoard'])) {

    header('location:dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            /* Right-to-left layout for Arabic text */
        }

        .invoice {
            width: 50%;
            /* Reduced width for printing */
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: right;
            /* Align all text to the right */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add shadow for better appearance */
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .customer-info {
            margin-bottom: 10px;
        }

        .invoice-items {
            margin-bottom: 10px;
        }

        .total-amount {
            text-align: right;
            /* Align total amount to the left */
            margin-top: 20px;
            /* Add some space between items */
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 5px;
        }

        .print-button {
            background-color: rgba(40, 57, 101, 0.9);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .print-button:hover {
            background-color: rgba(40, 57, 101, 1);
        }

        @media print {
            .invoice-container {
                width: 100%;
                margin: 0;
                border: none;
                padding: 0;
                box-shadow: none;
            }

            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice">
        <div class="logo">
            <img src="el-shroouk-logo.png" alt="El Shroouk Logo" width="100">
        </div>
        <div class="header">
            <h2>إيصال استلام نقدية</h2>
            <p>رقم الإيصال: <span id="invoice_number">
                    <?php echo $invoice_number; ?>
                </span></p>
        </div>
        <div class="customer-info">
            <p>موظق الاستقبال: <span id="customer_name">
                    <?php echo $_SESSION['Employee_name']; ?>
                </span></p>
            <p>الاسم: <span id="customer_name">
                    <?php echo $customer_name; ?>
                </span></p>
            <p>الفحص: <span id="scan_type">
                    <?php echo $scan_type; ?>
                </span></p>
            <p>تاريخ الفحص: <span id="exam_date">
                    <?php echo $exam_date; ?>
                </span></p>
            <div class="total-amount">
                <p>المبلغ الإجمالي قبل الخصم: <span id="total_amount">
                        <?php echo $total_amount; ?>
                    </span></p>
                <p>المبلغ الإجمالي بعد الخصم: <span id="total_amount">
                        <?php echo $_SESSION['total_after_discount']; ?>
                    </span></p>
                <p>المبلغ المدفوع: <span id="total_amount">
                        <?php echo $_SESSION['amount_paid']; ?>
                    </span></p>
                <p>المبلغ المتبقي: <span id="total_amount">
                        <?php echo $_SESSION['amount_left']; ?>
                    </span></p>
            </div>
            <hr>
            <center>
                <p>عيادة 353 – المركز الطبي 3 – شارع ابو داوود الظاهرى – المنطقة الحادية عشر – مدينة نصر<span
                        id="exam_date">

                    </span></p>
            </center>
            <center>
                <p>ت : 15184 - 0128887187<span id="exam_date">

                    </span></p>
            </center>

        </div>
    </div>
    </div>
    <center> <button class="print-button" onclick="printPage()" name="print">Print Invoice</button>

        <form action="" method="post">

            <button class="print-button" name="DashBoard">Back to DashBoard</button>

        </form>
    </center>

    <script>

        // function printInvoice() {
        //     var printWindow = window.open('', '_blank');
        //     printWindow.document.open();
        //     var invoiceContent = document.querySelector('.invoice').outerHTML; // Include the parent div with class 'invoice'
        //     var styleContent = document.querySelector('style').outerHTML; // Include all styles defined in the <style> tag
        //     printWindow.document.write('<!DOCTYPE html><html><head><title>Print Invoice</title>' + styleContent + '</head><body>' + invoiceContent + '</body></html>');
        //     printWindow.document.close();
        //     printWindow.print();
        // }

        function printPage() {
            window.print();
        }


    </script>
</body>

</html>