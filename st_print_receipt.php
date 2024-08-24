<?php
// s_print_receipt.php

session_start();
error_reporting(0);
include('includes/dbconn.php');

// Get the staff ID from the session
$staffID = $_SESSION['staffID'];

$fineID = $_GET['fine_id'];

// Fetch the latest payment details for the given staff ID
$query = "SELECT * FROM staff_vehicle_info WHERE StaffID='$staffID' AND ID='$fineID'";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Update the 'FineCharge' and 'Remark' columns to NULL after fetching the data
    $fineID = $row['ID'];
    mysqli_query($con, "UPDATE staff_vehicle_info SET FineCharge=NULL, Remark=NULL WHERE ID='$fineID'");
} else {
    // Handle the error or redirect to an error page
    header("Location: error.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VPS - Receipt</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datatable.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>

<body>

<div class="col-lg-2"></div>
<div class="col-lg-8">
    <div class="row">
        <!-- Invoice Content -->
        <div id="exampl">
            <table id="dom-jqry" class="table table-striped table-bordered">
                <tr>
                    <th colspan="4" style="text-align: center; font-size: 22px;">Receipt of Fine</th>
                </tr>
                <tr>
                    <th>Registration Number</th>
                    <td><?php echo $row['RegistrationNumber']; ?></td>
                    <th>Vehicle Category</th>
                    <td><?php echo $row['VehicleCategory']; ?></td>
                </tr>
                <tr>
                    <th>Vehicle Model</th>
                    <td><?php echo $row['VehicleCompanyname']; ?></td>
                    <th>Fine</th>
                    <td><?php echo $row['FineCharge']; ?></td>
                </tr>
                <tr>
                    <th>Owner Name</th>
                    <td><?php echo $row['OwnerName']; ?></td>
                    <th>Owner Contact Number</th>
                    <td><?php echo $row['OwnerContactNumber']; ?></td>
                </tr>
                <tr>
                    <th>Remarks</th>
                    <td colspan="3"><?php echo $row['Remark']; ?></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:center; cursor:pointer"><i class="fa fa-print fa-4x" aria-hidden="true"
                                                                                OnClick="CallPrint(this.value)"></i></td>
                </tr>
            </table>
        </div>
    </div><!--/.row-->

    <a href="st_veh_list.php"><button class="btn btn-primary">Back to Vehicle List</button></a>
</div><!--/.main-->
<div class="col-lg-2"></div>

<!-- Include scripts and closing tags -->
<script src="js/jquery-1.11.1.min.js"></script>
<!-- Include other scripts as needed -->

<script>
    function CallPrint(strid) {
        var prtContent = document.getElementById("exampl");
        var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
    }
</script>

</body>

</html>
