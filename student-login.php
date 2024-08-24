<?php
session_start();
error_reporting(0);
include('includes/dbconn.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check in the student_login table
    $student_query = mysqli_query($con, "SELECT StudentID, studentName FROM student_login WHERE Username='$username' AND Password='$password'");
    $student_ret = mysqli_fetch_assoc($student_query);

    if ($student_ret) {
        // Set session variables for student
        $_SESSION['studentID'] = $student_ret['StudentID'];
        $_SESSION['studentName'] = $student_ret['studentName'];

        header('location: s_veh_list.php');
        exit();
    }

    // Check in the staff_login table
    $staff_query = mysqli_query($con, "SELECT StaffID, staffName FROM staff_login WHERE Username='$username' AND Password='$password'");
    $staff_ret = mysqli_fetch_assoc($staff_query);

    if ($staff_ret) {
        // Set session variables for staff
        $_SESSION['staffID'] = $staff_ret['StaffID'];
        $_SESSION['staffName'] = $staff_ret['staffName'];

        header('location: st_veh_list.php');
        exit();
    }

    $msg = "Login Failed !!";
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>EGMS</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<style>
        body {
            background-image: url('uitmgate.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        /* Add this to adjust the panel's appearance on top of the background */
        .panel {
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the alpha channel as needed for transparency */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
		<center><h2><b>Entrance Gate Monitoring System</b></h2></center>
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Please Log In To Continue - Student/Staff</div>
				<div class="panel-body">
					<form method="POST">
					<?php if($msg)
						echo "<div class='alert bg-danger' role='alert'>
						<em class='fa fa-lg fa-warning'>&nbsp;</em> 
						$msg
						<a href='#' class='pull-right'>
						<em class='fa fa-lg fa-close'>
						</em></a></div>" ?> 
                        

						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Username" name="username" type="text">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" value="">
							</div>
							<div class="checkbox">
								
								<div>
                                    <div style="text-align: right; float: right;">
                                        <a href="index.php" style="text-decoration:none;">Admin Login Here</a>
                                    </div>
                                    <div style="clear: both;"></div>
                                </div>
							</div>
							<button class="btn btn-success" type="submit" name="login">Login</button></fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	

<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
