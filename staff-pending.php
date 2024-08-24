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
        <title>EGMS - Student Vehicle Detail</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/datatable.css" rel="stylesheet">
        <link href="css/datepicker3.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    </head>

    <body>
        <?php include 'includes/navigation.php' ?>

        <?php
        $page = "staff_pending"; // Change the page variable to "staff_pending"
        include 'includes/sidebar.php'
        ?>

        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="dashboard.php">
                            <em class="fa fa-home"></em>
                        </a></li>
                    <li class="active">Staff Pending</li> <!-- Change breadcrumb to "Staff Pending" -->
                </ol>
            </div><!--/.row-->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Staff Pending</div> <!-- Change panel heading to "Staff Pending" -->
                        <div class="panel-body">
                            <!-- Vehicle Table -->
                            <table id="example" class="table table-striped table-hover table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vehicle No.</th>
                                        <th>Category</th>
                                        <th>Model</th>
                                        <th>Owner Name</th>
                                        <th>Contact Number</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Fetch vehicles from the staff_pending table with 'Pending' status
                                    $query = "SELECT ID, RegistrationNumber, VehicleCategory, VehicleCompanyname, OwnerName, OwnerContactNumber, Status FROM staff_pending WHERE Status IN ('Pending', 'Rejected')";
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
                                            <td><?php echo $row['Status']; ?></td>
                                            <td>
                                                <a href="staff_detail_pending.php?detailid=<?php echo $row['ID']; ?>">
                                                    <button type="button" class="btn btn-sm btn-info">Take Action</button>
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
        <!-- Include other scripts as needed -->

    </body>

    </html>

<?php
}
?>
