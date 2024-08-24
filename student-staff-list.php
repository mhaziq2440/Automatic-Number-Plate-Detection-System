<?php
session_start();
error_reporting(0);
include('includes/dbconn.php');
if (strlen($_SESSION['vpmsaid'] == 0)) {
    header('location:logout.php');
} else {
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EGMS - Registered Vehicles</title>
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
                <li class="active">Registered Vehicles</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Registered Vehicles</div>
                    <div class="panel-body">

                        <!-- Filter Form -->
                        <form method="post" action="">
                            <label for="userTypeFilter">Filter by User Type:</label>
                            <select name="userTypeFilter" id="userTypeFilter">
                                <option value="all">All</option>
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                            </select>
                            <button type="submit" name="applyFilter">Apply Filter</button>
                        </form>

                        <!-- Vehicle Table -->
                        <table id="example" class="table table-striped table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vehicle No.</th>
                                    <th>Category</th>
                                    <th>Company</th>
                                    <th>Owner Name</th>
                                    <th>Contact Number</th>
                                    <th>Fine</th>
                                    <?php
                                    // Check if the filter form is submitted
                                    if (isset($_POST['applyFilter'])) {
                                        // Check if the filter is not set to "all"
                                        if ($_POST['userTypeFilter'] != 'all') {
                                            echo '<th></th>'; // Display the last column with buttons when a filter is applied and not set to "all"
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Check if the filter form is submitted
                                if (isset($_POST['applyFilter'])) {
                                    $filter = $_POST['userTypeFilter'];
                                    if ($filter == 'all') {
                                        $query = "SELECT ID, StudentID, RegistrationNumber, VehicleCategory, VehicleCompanyname, OwnerName, OwnerContactNumber, FineCharge, Remark FROM student_vehicle_info UNION SELECT ID, StaffID, RegistrationNumber, VehicleCategory, VehicleCompanyname, OwnerName, OwnerContactNumber, FineCharge, Remark FROM staff_vehicle_info";

                                    } else {
                                        $query = "SELECT * FROM " . ($filter == 'student' ? 'student_vehicle_info' : 'staff_vehicle_info');
                                    }
                                } else {
                                    // Default query to show all records
                                    $query = "SELECT ID, StudentID, RegistrationNumber, VehicleCategory, VehicleCompanyname, OwnerName, OwnerContactNumber, FineCharge, Remark FROM student_vehicle_info UNION SELECT ID, StaffID, RegistrationNumber, VehicleCategory, VehicleCompanyname, OwnerName, OwnerContactNumber, FineCharge, Remark FROM staff_vehicle_info";
                                }

                                $ret = mysqli_query($con, $query);
                                $cnt = 1;

                                while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo $row['RegistrationNumber']; ?></td>
                                        <td><?php echo $row['VehicleCategory']; ?></td>
                                        <td><?php echo $row['VehicleCompanyname']; ?></td>
                                        <td><?php echo $row['OwnerName']; ?></td>
                                        <td><?php echo $row['OwnerContactNumber']; ?></td>
                                        <td><?php echo !empty($row['FineCharge']) ? $row['FineCharge'] : 'No'; ?></td>
                                        <?php
                // Check if the filter form is submitted
                if (isset($_POST['applyFilter'])) {
                    $editDetailsURL = '';
                    $editButtonLabel = '';

                    // Check if the record is associated with a student or a staff
                    if (!empty($row['StudentID']) && empty($row['StaffID'])) {
                        $editDetailsURL = 'detail-student.php';
                        $editButtonLabel = 'Edit Student';
                    } elseif (!empty($row['StaffID']) && empty($row['StudentID'])) {
                        $editDetailsURL = 'detail-staff.php';
                        $editButtonLabel = 'Edit Staff';
                    } elseif (!empty($row['StudentID']) && !empty($row['StaffID'])) {
                        // If both StudentID and StaffID are present, prioritize the staff link
                        $editDetailsURL = 'detail-staff.php';
                        $editButtonLabel = 'Edit Staff';
                    }

                    // Display the Edit and Delete buttons if the URL and label are set and the filter is not set to "all"
                    if ($editDetailsURL && $editButtonLabel && $_POST['userTypeFilter'] != 'all') {
                        echo '<td>
                                <a href="' . $editDetailsURL . '?updateid=' . $row['ID'] . '&'
                            . (!empty($row['StudentID']) ? 'studentid' : 'staffid') . '='
                            . (!empty($row['StudentID']) ? $row['StudentID'] : $row['StaffID']) . '&'
                            . 'category=' . $row['VehicleCategory'] . '&company=' . $row['VehicleCompanyname']
                            . '&reg_number=' . $row['RegistrationNumber'] . '&owner_name=' . $row['OwnerName']
                            . '&contact_number=' . $row['OwnerContactNumber'] . '&FineCharge=' . $row['FineCharge']
                            . '&remark=' . $row['Remark'] . '">
                                <button type="button" class="btn btn-sm btn-info">' . $editButtonLabel . '</button>
                                </a>
                                
                            </td>';
                    } elseif ($_POST['userTypeFilter'] != 'all') {
                        // If not associated with a student or staff, display a default button
                        echo '<td><button type="button" class="btn btn-sm btn-secondary">Edit</button></td>';
                    }
                }
                ?>
                                    </tr>
                                <?php
                                    $cnt = $cnt + 1;
                                }
                                ?>
                            </tbody>
                        </table>
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

</body>

</html>

<?php } ?>
