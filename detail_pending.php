<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('includes/dbconn.php');

if (strlen($_SESSION['vpmsaid']) == 0) {
    header('location:logout.php');
} else {
    $query = null;

    if (isset($_GET['detailid'])) {
        $detailId = $_GET['detailid'];

        // Fetch the data from the student_pending table based on detailId
        $query = mysqli_query($con, "SELECT * FROM student_pending WHERE ID='$detailId'");
        $row = mysqli_fetch_assoc($query);

        // Assign the values to variables
        $studentId = $row['StudentID'];
        $studentName = $row['studentName'];
        $regNumber = $row['RegistrationNumber'];
        $category = $row['VehicleCategory'];
        $company = $row['VehicleCompanyname'];
        $ownerName = $row['OwnerName'];
        $contactNumber = $row['OwnerContactNumber'];
        $status = $row['Status'];
        $carGrantFileName = $row['CarGrant'];
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["accept"])) {
            // Process the Accept button
            // Update the student_vehicle_info table with the accepted details
            $query = mysqli_query($con, "INSERT INTO student_vehicle_info (StudentID, VehicleCategory, VehicleCompanyname, RegistrationNumber, OwnerName, OwnerContactNumber, FineCharge, Remark, studentName) VALUES ('$studentId', '$category', '$company', '$regNumber', '$ownerName', '$contactNumber', '0', '', '$studentName')");
            
            if ($query) {
                // Update the status in student_pending table
                mysqli_query($con, "UPDATE student_pending SET Status='Accepted' WHERE ID='$detailId'");
                echo '<script>alert("Vehicle details accepted successfully."); window.location.href = "student-staff-list.php";</script>';
                exit();
            } else {
                echo "Error accepting vehicle details: " . mysqli_error($con);
            }
        } elseif (isset($_POST["reject"])) {
            // Process the Reject button
            // Update the status in student_pending table
            mysqli_query($con, "UPDATE student_pending SET Status='Rejected' WHERE ID='$detailId'");
            echo '<script>alert("Vehicle details rejected."); window.location.href = "student-staff-list.php";</script>';
            exit();
        }
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
    $page = "pending";
    include 'includes/sidebar.php'
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li><a href="pending.php">Registered Vehicles</a></li>
                <li class="active">Student Pending Detail</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Student Pending Detail</div>
                    <div class="panel-body">

                        <div class="col-md-12">
                            <!-- Display the details received from the previous page -->
                            <form method="post">

                                <div class="form-group">
                                    <label for="studentId">Student ID:</label>
                                    <input type="text" class="form-control" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="studentName">Student Name:</label>
                                    <input type="text" class="form-control" name="studentName" value="<?php echo htmlspecialchars($studentName); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="registrationNumber">Registration Number:</label>
                                    <input type="text" class="form-control" name="registrationNumber" value="<?php echo htmlspecialchars($regNumber); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label>Vehicle Category</label>
                                    <input type="text" class="form-control" name="vehicleCategory" value="<?php echo htmlspecialchars($category); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="vehicleCompany">Model:</label>
                                    <input type="text" class="form-control" name="vehicleCompany" value="<?php echo htmlspecialchars($company); ?>" readonly>
                                </div>
                                
                                <div class="form-group">
                                    <label for="status"> Car Grant: <br></label>
                                <a href="view_cargrant.php?detailid=<?php echo $detailId; ?>" class="btn btn-primary">View</a>
                                </div>

                                <div class="form-group">
                                    <label for="ownerName">Owner Name:</label>
                                    <input type="text" class="form-control" name="ownerName" value="<?php echo htmlspecialchars($ownerName); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="ownerContactNumber">Contact Number:</label>
                                    <input type="text" class="form-control" name="ownerContactNumber" value="<?php echo htmlspecialchars($contactNumber); ?>" readonly>
                                </div>
                                
                                 <!-- Add Accept and Reject buttons -->
                                <button type="submit" name="accept" class="btn btn-success">Accept</button>
                                <button type="submit" name="reject" class="btn btn-danger">Reject</button>
                                
                            </form>
                        </div> <!--  col-md-12 ends -->
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.main-->

    <?php include 'includes/footer.php' ?>

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

</body>

</html>
