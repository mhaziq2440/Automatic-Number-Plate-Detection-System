<?php
// s_print_receipt.php

session_start();
error_reporting(0);
include('includes/dbconn.php');

// Get the student ID from the session
$studentID = $_SESSION['studentID'];

$fineID = $_GET['fine_id'];

// Fetch the latest payment details for the given student ID
$query = "SELECT * FROM student_vehicle_info WHERE StudentID='$studentID' AND ID='$fineID'";
$result = mysqli_query($con, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);

    // Update the 'FineCharge' and 'Remark' columns to NULL after fetching the data
    $fineID = $row['ID'];
    mysqli_query($con, "UPDATE student_vehicle_info SET FineCharge=NULL, Remark=NULL WHERE ID='$fineID'");
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

    <a href="s_veh_list.php"><button class="btn btn-primary">Back to Vehicle List</button></a>
</div><!--/.main-->
<div class="col-lg-2"></div>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/chart.min.js"></script>
<script src="js/chart-data.js"></script>
<script src="js/easypiechart.js"></script>
<script src="js/easypiechart-data.js"></script>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap4.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/custom.js"></script>
<script>
    window.onload = function () {
        var chart1 = document.getElementById("line-chart").getContext("2d");
        window.myLine = new Chart(chart1).Line(lineChartData, {
            responsive: true,
            scaleLineColor: "rgba(0,0,0,.2)",
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleFontColor: "#c5c7cc"
        });
    };
</script>

<script>
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>

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
