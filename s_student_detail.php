<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('includes/dbconn.php');

if (!isset($_SESSION['studentID'])) {
    header('Location: student-login.php');
    exit();
} else {
    $msg = '';

    if (isset($_POST['submit-update'])) {
        $cid = $_GET['updateid'];
        $studentId = $_GET['studentid'];
        $studentName = $_POST['studentName'];
        $vehicleCategory = $_POST['vehicleCategory'];
        $vehicleCompany = $_POST['vehicleCompany'];
        $registrationNumber = $_POST['registrationNumber'];
        $ownerName = $_POST['ownerName'];
        $ownerContactNumber = $_POST['ownerContactNumber'];

        $query = mysqli_query($con, "UPDATE student_vehicle_info SET
            studentName='$studentName',
            VehicleCategory='$vehicleCategory',
            VehicleCompanyname='$vehicleCompany',
            RegistrationNumber='$registrationNumber',
            OwnerName='$ownerName',
            OwnerContactNumber='$ownerContactNumber'
            WHERE ID='$cid' AND StudentID='$studentId'");

        if ($query) {
            $msg = "Details updated successfully.";
        } else {
            $msg = "Query execution failed: " . mysqli_error($con);
        }
    }

    $cid = $_GET['updateid'];
    $studentId = $_GET['studentid'];

    // Fetch the data from the database based on updateId and studentId
    $query = mysqli_query($con, "SELECT * FROM student_vehicle_info WHERE ID='$cid' AND StudentID='$studentId'");
    $row = mysqli_fetch_assoc($query);

    // Assign the values to variables
    $studentName = $row['studentName'];
    $registrationNumber = $row['RegistrationNumber'];
    $vehicleCategory = $row['VehicleCategory'];
    $vehicleCompany = $row['VehicleCompanyname'];
    $ownerName = $row['OwnerName'];
    $ownerContactNumber = $row['OwnerContactNumber'];
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EGMS - Student Vehicle Detail</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datatable.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

</head>

<body>
    <?php include 'includes/s_navigation.php' ?>

    <?php
    $page = "student-staff-list";
    include 'includes/s_sidebar.php'
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
                            <!-- Display the details received from the database -->
                            <?php if (!empty($msg)) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $msg; ?>
                                </div>
                            <?php endif; ?>

                            <form method="POST" action="s_student_detail.php?updateid=<?php echo $cid; ?>&studentid=<?php echo $studentId; ?>">

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
                                    <input type="text" class="form-control" name="registrationNumber" value="<?php echo htmlspecialchars($registrationNumber); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="vehicleCategory">Vehicle Category:</label>
                                    <select class="form-control" name="vehicleCategory" id="vehicleCategory">
                                        <?php
                                        $query = mysqli_query($con, "select * from vcategory");
                                        while ($row = mysqli_fetch_array($query)) {
                                            $optionValue = $row['VehicleCat'];
                                            $isSelected = ($optionValue == $vehicleCategory) ? 'selected' : '';
                                        ?>
                                            <option value="<?php echo $optionValue; ?>" <?php echo $isSelected; ?>><?php echo $optionValue; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="vehicleCompany">Model:</label>
                                    <input type="text" class="form-control" name="vehicleCompany" value="<?php echo htmlspecialchars($vehicleCompany); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="ownerName">Owner Name:</label>
                                    <input type="text" class="form-control" name="ownerName" value="<?php echo htmlspecialchars($ownerName); ?>">
                                </div>

                                <div class="form-group">
                                    <label for="ownerContactNumber">Contact Number:</label>
                                    <input type="text" class="form-control" name="ownerContactNumber" value="<?php echo htmlspecialchars($ownerContactNumber); ?>">
                                </div>

                                <button type="submit" name="submit-update" class="btn btn-primary">Update Details</button>
                            </form>
                        </div> <!-- col-md-12 ends -->
                    </div>
                </div>
            </div>
        </div>
    </div> <!--/.main-->

    <?php include 'includes/footer.php' ?>

</body>

</html>
