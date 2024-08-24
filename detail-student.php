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
        $studentId = $_GET['studentid'];
        $studentName = $_POST['studentName'];
        $vehicleCategory = $_POST['vehicleCategory'];
        $vehicleCompany = $_POST['vehicleCompany'];
        $registrationNumber = $_POST['registrationNumber'];
        $ownerName = $_POST['ownerName'];
        $ownerContactNumber = $_POST['ownerContactNumber'];
        $FineCharge = $_POST['fine'];
        $remark = $_POST['remark'];

        $query = mysqli_query($con, "UPDATE student_vehicle_info SET
            studentId='$studentId',
            studentName='$studentName',
            VehicleCategory='$vehicleCategory',
            VehicleCompanyname='$vehicleCompany',
            RegistrationNumber='$registrationNumber',
            OwnerName='$ownerName',
            OwnerContactNumber='$ownerContactNumber',
            FineCharge='$FineCharge',
            Remark='$remark'
            WHERE ID='$cid' AND StudentID='$studentId'");

        if ($query) {
            $msg = "Details updated successfully.";
        } else {
            $msg = "Query execution failed: " . mysqli_error($con);
        }
    }

    if (isset($_GET['updateid']) && isset($_GET['studentid'])) {
        $updateId = $_GET['updateid'];
        $studentId = $_GET['studentid'];

        // Fetch the data from the database based on updateId and studentId
        $query = mysqli_query($con, "SELECT * FROM student_vehicle_info WHERE ID='$updateId' AND StudentID='$studentId'");
        $row = mysqli_fetch_assoc($query);

        // Assign the values to variables
        $studentName = $row['studentName'];
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
    <title>VPS - Student Vehicle Detail</title>
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
    $page = "student-staff-list";
    include 'includes/sidebar.php'
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">
                    <em class="fa fa-home"></em>
                </a></li>
                <li><a href="student-staff-list.php">Registered Vehicles</a></li>
                <li class="active">Student Vehicle Detail</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Student Vehicle Detail</div>
                    <div class="panel-body">

                        <div class="col-md-12">
                            <!-- Display the details received from the previous page -->
                            <form method="POST" action="detail-student.php?updateid=<?php echo $updateId; ?>&studentid=<?php echo $studentId; ?>">
                                
                                <div class="form-group">
                                    <label for="studentId">Student ID:</label>
                                    <input type="text" class="form-control" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="studentName">Student Name:</label>
                                    <input type="text" class="form-control" name="studentName" value="<?php echo htmlspecialchars($studentName); ?>">
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

                                 <!-- Add a new button for deletion -->
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Delete</button>

                            </form>

                            <!-- Delete Confirmation Modal -->
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this record?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <!-- Add a button to trigger the deletion -->
                                            <a href="delete_student.php?deleteid=<?php echo $updateId; ?>&studentid=<?php echo $studentId; ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!--  col-md-12 ends -->
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
