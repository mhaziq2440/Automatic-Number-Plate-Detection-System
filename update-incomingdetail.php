<?php
session_start();
error_reporting(0);
include('includes/dbconn.php');

if (strlen($_SESSION['vpmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit-in']) || isset($_POST['submit-edit'])) {
        $cid = $_GET['updateid'];
        $vehicleCategory = $_POST['vehicleCategory'];
        $vehicleCompanyname = $_POST['vehicleCompanyname'];
        $registrationNumber = $_POST['registrationNumber'];
        $ownerName = $_POST['ownerName'];
        $ownerContactNumber = $_POST['ownerContactNumber'];
        $inTime = $_POST['inTime'];
        $outTime = $_POST['outTime'];
        $remark = $_POST['remark'];
        $status = isset($_POST['submit-in']) ? $_POST['status'] : $_POST['currentStatus'];
        $fine = isset($_POST['fine']) ? 1 : 0;
        $FineCharge = $fine == 1 ? $_POST['FineCharge'] : '';

        if (isset($_POST['submit-edit'])) {
            // If "Edit" button is clicked, set the status to the current status
            $status = $row['Status'];
        }

        $query = mysqli_query($con, "UPDATE vehicle_info SET 
            VehicleCategory='$vehicleCategory', 
            VehicleCompanyname='$vehicleCompanyname', 
            RegistrationNumber='$registrationNumber', 
            OwnerName='$ownerName', 
            OwnerContactNumber='$ownerContactNumber', 
            InTime='$inTime', 
            OutTime='$outTime', 
            Remark='$remark', 
            Status='$status', 
            Fine=$fine, 
            FineCharge='$FineCharge' 
            WHERE ID='$cid'");
        
        if ($query) {
            $msg = "All details have been updated.";
        } else {
            $msg = "Something went wrong";
        }
    }
?>

<!-- ... (rest of the HTML code) -->



<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VPS</title>
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
    $page="in-vehicle";
    include 'includes/sidebar.php'
    ?>
    
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <ol class="breadcrumb">
                <li><a href="dashboard.php">
                    <em class="fa fa-home"></em>
                </a></li>
                <li class="active">Vehicle Category Management</li>
            </ol>
        </div><!--/.row-->
        
        <div class="row">
            <div class="col-lg-12">
                <!-- <h1 class="page-header">Vehicle Management</h1> -->
            </div>
        </div><!--/.row-->
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Manage Incoming Vehicles</div>
                    <div class="panel-body">

                        <?php 
                        if($msg)
                            echo "<div class='alert bg-info ' role='alert'>
                            <em class='fa fa-lg fa-warning'>&nbsp;</em> 
                            $msg
                            <a href='#' class='pull-right'>
                            <em class='fa fa-lg fa-close'>
                            </em></a></div>";
                        ?> 
                        
                        <div class="col-md-12">
                            <form method="POST">
                                <?php
                                $cid=$_GET['updateid'];
                                $ret=mysqli_query($con,"SELECT * from vehicle_info where ID='$cid'");
                                $cnt=1;
                                while ($row=mysqli_fetch_array($ret)) {
                                ?> 

                                <div class="form-group">
                                    <label>Vehicle Registration Number</label>
                                    <input type="text" class="form-control" value="<?php echo $row['RegistrationNumber'];?>" name="registrationNumber">
                                </div>

                                <div class="form-group">
                                    <label>Model</label>
                                    <input type="text" class="form-control" value="<?php echo $row['VehicleCompanyname'];?>" name="vehicleCompanyname">
                                </div>

                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" class="form-control" value="<?php echo $row['VehicleCategory'];?>" name="vehicleCategory">
                                </div>

                                <div class="form-group">
                                    <label>Vehicle IN Time</label>
                                    <input type="text" class="form-control" value="<?php echo $row['InTime'];?>" name="inTime">
                                </div>

                                <div class="form-group">
                                    <label>Vehicle Owned By</label>
                                    <input type="text" class="form-control" value="<?php echo $row['OwnerName'];?>" name="ownerName">
                                </div>

                                <div class="form-group">
                                    <label>Vehicle Owner Contact</label>
                                    <input type="text" class="form-control" value="<?php echo $row['OwnerContactNumber'];?>" name="ownerContactNumber">
                                </div>

                                <div class="form-group">
                                    <label>Current Status</label>
                                    <input type="text" class="form-control" value="<?php echo "Vehicle out";?>" name="currentStatus">
                                </div>

                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required="true">
                                        <option value="Out" <?php echo ($row['Status'] == 'Out') ? 'selected' : ''; ?>>Outgoing Vehicle</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Remarks</label>
                                    <input type="text" class="form-control" value="<?php echo $row['Remark'];?>" name="remark">
                                </div>
                                
                                <div class="form-group">
                                    <label>Fine</label>
                                    <input id="fineCheckbox" type="checkbox" name="fine">
                                </div>

                                <div class="form-group">
                                    <label>Fine Charge</label>
                                    <input id="FineCharge" type="text" name="FineCharge" value="<?php echo $row['FineCharge'];?>">
                                </div>

                                <button type="submit" class="btn btn-success" name="submit-in">Submit For Out-Going</button>
                                <button type="submit" class="btn btn-warning" name="submit-edit">Edit</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            <?php } ?>
                            </form>
                        </div> <!--  col-md-12 ends -->
                    </div>
                </div>
            </div>
        </div>
    </div><!--/.row-->

    <?php include 'includes/footer.php'?>
</div> <!--/.main-->

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/chart.min.js"></script>
<script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script>
    document.getElementById('fineCheckbox').addEventListener('change', function() {
        var parkingChargeInput = document.getElementById('FineCharge');
        parkingChargeInput.readOnly = !this.checked;
        parkingChargeInput.value = !this.checked ? 0 : ''; // Reset value if unchecked
    });
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trigger the initial state of the fine charge input
            document.getElementById('fineCheckbox').dispatchEvent(new Event('click'));
        });
    </script>
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
} );
    </script>
		
</body>
</html>

<?php }  ?>