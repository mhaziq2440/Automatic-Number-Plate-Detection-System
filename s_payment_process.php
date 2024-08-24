<?php
// Include necessary files and configurations
session_start();
error_reporting(0);
include('includes/dbconn.php');

// Check if the user is logged in
if (strlen($_SESSION['studentID'] == 0)) {
    header('location:logout.php');
} else {
    // Get the fine ID and payment method from the form submission
    $fineID = $_POST['fine_id'];
    $paymentMethod = $_POST['payment_method'];

    // Initialize variables for payment data based on the selected method
    $bankName = '';
    $cardNumber = '';
    $expirationDate = '';

    if ($paymentMethod == 'online_banking') {
        // Get the selected bank from the dropdown
        $bankName = $_POST['selected_bank'];
        // Additional processing for online banking payment
        // ...

    } elseif ($paymentMethod == 'card') {
        // Get card information from the form
        $cardNumber = $_POST['card_number'];
        $expirationDate = $_POST['expiration_date'];
        // Additional processing for card payment
        // ...
    }

    // Save the payment details to the database or perform payment processing logic
        // Update the newly added columns 'CardNumber' and 'ExpirationDate', 'FineCharge', and 'Remark'
        $updateQuery = "UPDATE student_vehicle_info SET PaymentMethod='$paymentMethod', BankName='$bankName', CardNumber='$cardNumber', ExpirationDate='$expirationDate' WHERE ID='$fineID'";
        $updateResult = mysqli_query($con, $updateQuery);


    if ($updateResult) {
        // Redirect to the receipt page with the fine ID
        header("Location: s_print_receipt.php?fine_id=$fineID");
        exit();
    } else {
        echo "Payment processing failed: " . mysqli_error($con);
        // Handle the error and redirect the user accordingly
    }
}
?>
