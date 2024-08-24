<?php
session_start();
error_reporting(0);
include('includes/dbconn.php');

if (strlen($_SESSION['studentID'] == 0)) {
    header('location:logout.php');
} else {
    $studentID = $_SESSION['studentID'];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EGMS - Student Fine</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datatable.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Include Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Include DataTables JS and CSS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

    <!-- Custom Font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>

<body>
    <?php include 'includes/s_navigation.php' ?>

    <?php
    $page = "s_fine";
    include 'includes/s_sidebar.php'
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">
                        <em class="fa fa-home"></em>
                    </a></li>
                <li class="active">Student Fine</li>
            </ol>
        </div><!--/.row-->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Student Fine</div>
                    <div class="panel-body">

                        <!-- Fine Table -->
                        <table id="fineTable" class="table table-striped table-hover table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vehicle No.</th>
                                    <th>Category</th>
                                    <th>Model</th>
                                    <th>Fine Amount (RM)</th>
                                    <th>Remark</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch vehicles with fines for the specific student
                                $query = "SELECT ID, RegistrationNumber, VehicleCategory, VehicleCompanyname, OwnerName, OwnerContactNumber, FineCharge, Remark FROM student_vehicle_info WHERE StudentID = $studentID AND FineCharge > 0";
                                $ret = mysqli_query($con, $query);
                                $cnt = 1;

                                while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $cnt; ?></td>
                                        <td><?php echo $row['RegistrationNumber']; ?></td>
                                        <td><?php echo $row['VehicleCategory']; ?></td>
                                        <td><?php echo $row['VehicleCompanyname']; ?></td>
                                        <td><?php echo $row['FineCharge']; ?></td>
                                        <td><?php echo $row['Remark']; ?></td>
                                        <td>
                                            <a href="s_payment_method.php?fine_id=<?php echo $row['ID']; ?>">
                                                <button type="button" class="btn btn-sm btn-success">Pay Fine</button>
                                            </a>
                                        </td>
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
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#fineTable').DataTable();
        });
    </script>

</body>

</html>

<?php
}
?>
