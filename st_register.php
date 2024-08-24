<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconn.php');

if (!isset($_SESSION['staffID'])) {
    header('Location: student-login.php'); // Redirect to the staff login page if not logged in
    exit();
}

$staffID = $_SESSION['staffID'];
$staffName = isset($_SESSION['staffName']) ? $_SESSION['staffName'] : '';

if (isset($_POST['submit-vehicle'])) {
    // Check if the form is submitted
    // Check if keys exist in the $_POST array
    $catename = isset($_POST['catename']) ? $_POST['catename'] : '';
    $vehcomp = isset($_POST['vehcomp']) ? $_POST['vehcomp'] : '';
    $vehreno = isset($_POST['vehreno']) ? $_POST['vehreno'] : '';
    $ownername = isset($_POST['ownername']) ? $_POST['ownername'] : '';
    $ownercontno = isset($_POST['ownercontno']) ? $_POST['ownercontno'] : '';

    // Additional code for uploading CarGrant in PDF format
    $carGrantFileName = ''; // Initialize the variable to store the file name

    if ($_FILES['carGrant']['error'] == 0) {
        // File uploaded successfully
        $carGrantFileName = $_FILES['carGrant']['name'];
        $carGrantTempName = $_FILES['carGrant']['tmp_name'];
        $carGrantPath = 'uploads/' . $carGrantFileName; // Specify the upload directory

        // Move the uploaded file to the specified directory
        move_uploaded_file($carGrantTempName, $carGrantPath);
    }

    // Insert data into the staff_pending table
    $query = mysqli_query($con, "INSERT INTO staff_pending(StaffID, StaffName, VehicleCategory, VehicleCompanyname, RegistrationNumber, OwnerName, OwnerContactNumber, CarGrant, Status)
                                VALUES('$staffID', '$staffName', '$catename','$vehcomp','$vehreno','$ownername','$ownercontno', '$carGrantFileName', 'Pending')");

    if ($query) {
        echo "<script>alert('Vehicle Entry Detail has been added for staff');</script>";
        echo "<script>window.location.href ='st_register.php'</script>";
    } else {
        $error_message = mysqli_error($con);
        echo "<script>alert('Error: $error_message');</script>";
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
    <?php include 'includes/s_navigation.php' ?>

    <?php
    $page = "st_register";
    include 'includes/st_sidebar.php'
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Register Staff</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <!-- <h1 class="page-header">Vehicle Management</h1> -->
            </div>
        </div><!--/.row-->

        <div class="panel panel-default">
            <div class="panel-heading">Register Staff</div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="POST" enctype="multipart/form-data">

                        <!-- Student ID input (read-only) -->
                        <div class="form-group">
                            <label>Staff ID</label>
                            <input type="text" class="form-control" value="<?php echo $staffID; ?>" readonly>
                        </div>

                        <!-- Student Name input (read-only) -->
                        <div class="form-group">
                            <label>Staff Name</label>
                            <input type="text" class="form-control" value="<?php echo $staffName; ?>" readonly>
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
                        
                        <div class="form-group">
                            <label>CarGrant (PDF)</label>
                            <input type="file" class="form-control" name="carGrant">
                        </div>

                        <button type="submit" class="btn btn-success" name="submit-vehicle">Submit</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                    </form>
                </div> <!-- col-md-12 ends -->
            </div>
        </div>
        <?php include 'includes/footer.php' ?>
    </div> <!--/.main-->

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


<?php   ?>