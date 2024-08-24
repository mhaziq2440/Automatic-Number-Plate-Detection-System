<?php
// Assuming you have the student's ID stored in $_SESSION['student_id']
$staffID = $_SESSION['staffID'];

// Query the database to get the student's username
$query = mysqli_query($con, "SELECT staffName FROM staff_login WHERE StaffID='$staffID'");
$row = mysqli_fetch_assoc($query);
$staffUsername = $row['staffName'];
?>    

    <div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="https://www.w3schools.com/howto/img_avatar.png" width="50" class="img-responsive" alt="Icon">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo htmlspecialchars($staffUsername); ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>

		<form role="search" action="search-results.php" name="search" method="POST" enctype="multipart/form-data">

			<!--  -->

		</form>
		<ul class="nav menu">
			<li class="<?php if($page=="st_veh_list") {echo "active";}?>"><a href="st_veh_list.php"><em class="fa fa-dashboard">&nbsp;</em> Vehicle List</a></li>
			<li class="<?php if($page=="st_register") {echo "active";}?>"><a href="st_register.php"><em class="fa fa-car">&nbsp;</em> Vehicle Register</a></li>
			<li class="<?php if($page=="st_pending") {echo "active";}?>"><a href="st_pending.php"><em class="fa fa-car">&nbsp;</em> Status Registration</a></li>
			<li class="<?php if($page=="st_fine") {echo "active";}?>"><a href="st_fine.php"><em class="fa fa-sticky-note">&nbsp;</em> Vehicle Fine</a></li>
		</ul>
		
	</div><!--/.sidebar-->