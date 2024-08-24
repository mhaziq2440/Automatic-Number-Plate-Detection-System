<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('includes/dbconn.php');

if (strlen($_SESSION['vpmsaid']) == 0) {
    header('location:logout.php');
} else {
    $query = null;

    if (isset($_POST['submit-update'])) {
        $cid = $_GET['updateid'];
        $staffId = $_GET['staffid'];
        $staffName = $_POST['staffName'];
        $vehicleCategory = $_POST['vehicleCategory'];
        $vehicleCompany = $_POST['vehicleCompany'];
        $registrationNumber = $_POST['registrationNumber'];
        $ownerName = $_POST['ownerName'];
        $ownerContactNumber = $_POST['ownerContactNumber'];
        $FineCharge = $_POST['fine'];
        $remark = $_POST['remark'];

        $query = mysqli_query($con, "UPDATE staff_vehicle_info SET
            StaffID='$staffId',
            StaffName='$staffName',
            VehicleCategory='$vehicleCategory',
            VehicleCompanyname='$vehicleCompany',
            RegistrationNumber='$registrationNumber',
            OwnerName='$ownerName',
            OwnerContactNumber='$ownerContactNumber',
            FineCharge='$FineCharge',
            Remark='$remark'
            WHERE ID='$cid' AND StaffID='$staffId'");

        if ($query) {
            $msg = "Details updated successfully.";
        } else {
            $msg = "Query execution failed: " . mysqli_error($con);
        }
    }

    if (isset($_POST['submit-delete'])) {
    // Get the ID and StaffID for deletion
    $deleteId = $_GET['updateid'];
    $deleteStaffId = $_GET['staffid'];

    // Perform the deletion
    $deleteQuery = mysqli_query($con, "DELETE FROM staff_vehicle_info WHERE ID='$deleteId' AND StaffID='$deleteStaffId'");

    if ($deleteQuery) {
        $msg = "Record deleted successfully.";
        sleep(1);

        header('Location: student-staff-list.php');
    } else {
        $msg = "Deletion failed: " . mysqli_error($con);
    }
    }
    
    if (isset($_GET['updateid']) && isset($_GET['staffid'])) {
        $updateId = $_GET['updateid'];
        $staffId = $_GET['staffid'];

        // Fetch the data from the database based on updateId and staffId
        $query = mysqli_query($con, "SELECT * FROM staff_vehicle_info WHERE ID='$updateId' AND StaffID='$staffId'");
        $row = mysqli_fetch_assoc($query);

        // Assign the values to variables
        $staffName = $row['StaffName'];
        $regNumber = $row['RegistrationNumber'];
        $category = $row['VehicleCategory'];
        $company = $row['VehicleCompanyname'];
        $ownerName = $row['OwnerName'];
        $contactNumber = $row['OwnerContactNumber'];
        $FineCharge = $row['FineCharge'];
        $remark = $row['Remark'];
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>VPS - Staff Vehicle Detail</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datatable.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

</head>

<body>
    <?php include 'includes/navigation.php' ?>

    <?php
    $page = "staff-list";
    include 'includes/sidebar.php'
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li><a href="student-staff-list.php">Registered Vehicles</a></li>
                <li class="active">Staff Vehicle Detail</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Staff Vehicle Detail</div>
                    <div class="panel-body">

                        <div class="col-md-12">
                            <!-- Display the details received from the previous page -->
                            <form method="POST" action="detail-staff.php?updateid=<?php echo $updateId; ?>&staffid=<?php echo $staffId; ?>">

                                <div class="form-group">
                                    <label for="staffId">Staff ID:</label>
                                    <input type="text" class="form-control" name="staffId" value="<?php echo htmlspecialchars($staffId); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="staffName">Staff Name:</label>
                                    <input type="text" class="form-control" name="staffName" value="<?php echo htmlspecialchars($staffName); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="registrationNumber">Registration Number:</label>
                                    <input type="text" class="form-control" name="registrationNumber" value="<?php echo htmlspecialchars($regNumber); ?>">
                                </div>

                                <div class="form-group">
                                    <label>Vehicle Category</label>
                                    <select class="form-control" name="vehicleCategory" id="vehicleCategory">
                                        <?php
                                        $query = mysqli_query($con, "select * from vcategory");
                                        while ($row = mysqli_fetch_array($query)) {
                                            $optionValue = $row['VehicleCat'];
                                            $isSelected = ($optionValue == $category) ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $optionValue; ?>" <?php echo $isSelected; ?>><?php echo $optionValue; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="vehicleCompany">Company:</label>
                                    <input type="text" class="form-control" name="vehicleCompany" value="<?php echo htmlspecialchars($company); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="ownerName">Owner Name:</label>
                                    <input type="text" class="form-control" name="ownerName" value="<?php echo htmlspecialchars($ownerName); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="ownerContactNumber">Contact Number:</label>
                                    <input type="text" class="form-control" name="ownerContactNumber" value="<?php echo htmlspecialchars($contactNumber); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="fine">Fine (RM):</label>
                                    <input type="text" class="form-control" name="fine" value="<?php echo htmlspecialchars($FineCharge); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="remark">Remark:</label>
                                    <input type="text" class="form-control" name="remark" value="<?php echo htmlspecialchars($remark); ?>">
                                </div>

                                <button type="submit" name="submit-update" class="btn btn-primary">Update Details</button>
                                <button type="submit" name="submit-delete" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">Delete</button>
                               
                            </form>
                        </div> <!-- col-md-12 ends -->
                    </div>
                                </div>
            </div>
        </div>
    </div><!--/.main-->

    <?php include 'includes/footer.php'?>

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
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>

    <script>
    // Display PHP error message in a JavaScript alert
    <?php if ($msg !== ""): ?>
        alert("<?php echo $msg; ?>");
    <?php endif; ?>
    </script>

</body>
</html>

