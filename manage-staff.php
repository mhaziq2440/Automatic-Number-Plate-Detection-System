<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconn.php');

if (strlen($_SESSION['vpmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit-vehicle'])) {
        $catename = $_POST['catename'];
        $vehcomp = $_POST['vehcomp'];
        $vehreno = $_POST['vehreno'];
        $ownername = $_POST['ownername'];
        $ownercontno = $_POST['ownercontno'];
        $userType = $_POST['userType'];
        $staffID = $_POST['staffID'];
        $staffName = $_POST['staffname'];

        // Insert data into the staff_vehicle_info table only for staff
        if ($userType == 'staff') {
            $query = mysqli_query($con, "INSERT INTO staff_vehicle_info(StaffID, StaffName, VehicleCategory, VehicleCompanyname, RegistrationNumber, OwnerName, OwnerContactNumber)
                                        VALUES('$staffID', '$staffName', '$catename','$vehcomp','$vehreno','$ownername','$ownercontno')");

            if ($query) {
                echo "<script>alert('Vehicle Entry Detail has been added for staff');</script>";
                echo "<script>window.location.href ='dashboard.php'</script>";
            } else {
                $error_message = mysqli_error($con);
            }
        } else {
            echo "<script>alert('Invalid user type');</script>";
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EGMS</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>

<body>
    <?php include 'includes/navigation.php' ?>

    <?php
    $page = "manage-staff";
    include 'includes/sidebar.php'
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Register Staff Vehicle</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Register Staff Vehicle</div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form method="POST">
                                <div class="form-group">
                                    <label>User Type</label>
                                    <input type="hidden" name="userType" value="staff"> <!-- Set user type to 'staff' -->
                                    <p>Staff</p>
                                </div>

                                <div class="form-group">
                                    <label>Staff ID</label>
                                    <input type="text" class="form-control" placeholder="Enter Staff ID" id="staffID" name="staffID" required>
                                </div>

                                <div class="form-group">
                                    <label>Staff Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Staff Name" id="staffName" name="staffname" required>
                                </div>

                                <div class="form-group">
                                    <label>Registration Number</label>
                                    <input type="text" class="form-control" placeholder="ABC1234" id="vehreno" name="vehreno" required>
                                </div>

                                <div class="form-group">
                                    <label>Vehicle's Model</label>
                                    <input type="text" class="form-control" placeholder="Tesla" id="vehcomp" name="vehcomp" required>
                                </div>

                                <div class="form-group">
                                    <label>Vehicle Category</label>
                                    <select class="form-control" name="catename" id="catename">
                                        <option value="0">Select Category</option>
                                        <?php
                                        $query = mysqli_query($con, "select * from vcategory");
                                        while ($row = mysqli_fetch_array($query)) {
                                        ?>
                                            <option value="<?php echo $row['VehicleCat']; ?>"><?php echo $row['VehicleCat']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Owner's Full Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Here.." id="ownername" name="ownername" required>
                                </div>

                                <div class="form-group">
                                    <label>Owner's Contact</label>
                                    <input type="text" class="form-control" placeholder="Enter Here.." maxlength="11" pattern="[0-9]+" id="ownercontno" name="ownercontno" required>
                                </div>

                                <button type="submit" class="btn btn-success" name="submit-vehicle">Submit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </form>
                        </div> <!-- col-md-12 ends -->
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
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/custom.js"></script>
</body>

</html>

<?php } ?>
