<?php
// Include necessary files and configurations
session_start();
error_reporting(0);
include('includes/dbconn.php');

// Check if the user is logged in
if (strlen($_SESSION['staffID'] == 0)) {
    header('location:logout.php');
} else {
    // Get the fine ID from the URL parameter
    $fineID = $_GET['fine_id'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VPS - Payment Method</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
</head>

<body>
    <?php include 'includes/s_navigation.php' ?>

    <?php
    $page = "payment_method";
    include 'includes/s_sidebar.php'
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Payment Method</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Payment Method</div>
                    <div class="panel-body">
                        <p>Please choose a payment method:</p>

                        <!-- Payment Method Form -->
                        <form method="post" action="st_payment_process.php">
                            <input type="hidden" name="fine_id" value="<?php echo $fineID; ?>">

                            <label>
                                <input type="radio" name="payment_method" value="online_banking" required>
                                Online Banking
                            </label>
                            <br>

                            <!-- Display a dropdown for selecting a bank if online banking is chosen -->
                            <div id="bankDropdown" style="display: none;">
                                <label>Select Bank:</label>
                                <select name="selected_bank">
                                    <option value="maybank">Maybank</option>
                                    <option value="cimb">CIMB</option>
                                    <!-- Add more banks as needed -->
                                </select>
                            </div>
                            <br>

                            <label>
                                <input type="radio" name="payment_method" value="card" required>
                                Credit/Debit Card
                            </label>
                            <br>

                            <!-- Display card information fields if card payment is chosen -->
                            <div id="cardFields" style="display: none;">
                                <label>Card Number:</label>
                                <input type="text" name="card_number" placeholder="Enter card number">
                                <br>
                                
                                <label>Security Code:</label>
                                <input type="text" name="security" placeholder="Enter security code">
                                <br>

                                <label>Expiration Date:</label>
                                <input type="text" name="expiration_date" placeholder="MM/YYYY">
                                <br>
                            </div>
                            <br>

                            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.main-->

    <?php include 'includes/footer.php' ?>

    <script>
        // Script to show/hide bank dropdown and card fields based on the selected payment method
        document.addEventListener("DOMContentLoaded", function() {
            var onlineBankingRadio = document.querySelector('input[value="online_banking"]');
            var cardRadio = document.querySelector('input[value="card"]');
            var bankDropdown = document.getElementById('bankDropdown');
            var cardFields = document.getElementById('cardFields');

            onlineBankingRadio.addEventListener('change', function() {
                bankDropdown.style.display = 'block';
                cardFields.style.display = 'none';
            });

            cardRadio.addEventListener('change', function() {
                cardFields.style.display = 'block';
                bankDropdown.style.display = 'none';
            });
        });
    </script>

</body>

</html>

<?php
}
?>
