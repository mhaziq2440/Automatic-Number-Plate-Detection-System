<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="https://www.w3schools.com/howto/img_avatar.png" width="50" class="img-responsive" alt="Icon">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name">Admin</div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>

		<form role="search" action="search-results.php" name="search" method="POST" enctype="multipart/form-data">

			<!--  -->

			<div class="form-group">
				<input type="text" class="form-control" id="searchdata" name="searchdata" placeholder="Search Vehicle-Reg">
			</div>

		</form>
		<ul class="nav menu">
			<li class="<?php if($page=="dashboard") {echo "active";}?>"><a href="dashboard.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<!-- Menu category with sub-items -->
            <li class="parent <?php if($page=="student-staff") {echo "active";}?>">
                <a data-toggle="collapse" href="#student-staff">
                    <em class="fa fa-car">&nbsp;</em> Student/Staff
                    <span data-toggle="collapse" href="#student-staff" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="student-staff">
                    <li><a class="<?php if($page=="manage-student") {echo "active";}?>" href="manage-student.php">Student Register</a></li>
                    <li><a class="<?php if($page=="manage-staff") {echo "active";}?>" href="manage-staff.php">Staff Register</a></li>
                    <li><a class="<?php if($page=="pending") {echo "active";}?>" href="pending.php">Student Pending</a></li>
                    <li><a class="<?php if($page=="staff-pending") {echo "active";}?>" href="staff-pending.php">Staff Pending</a></li>
                    <li><a class="<?php if($page=="student-staff-list") {echo "active";}?>" href="student-staff-list.php">Student/Staff List</a></li>
                </ul>
            </li>
			<li class="parent <?php if($page=="visitor") {echo "active";}?>">
                <a data-toggle="collapse" href="#visitor">
                    <em class="fa fa-car">&nbsp;</em> Visitor
                    <span data-toggle="collapse" href="#visitor" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="visitor">
                    <li><a class="<?php if($page=="manage-vehicles") {echo "active";}?>" href="manage-vehicles.php">Visitor Entry</a></li>
                    <li><a class="<?php if($page=="in-vehicle") {echo "active";}?>" href="in-vehicles.php">IN Visitor</a></li>
                    <li><a class="<?php if($page=="out-vehicle") {echo "active";}?>" href="out-vehicles.php">OUT Visitor</a></li>
                </ul>
            </li>
			<li class="<?php if($page=="reports") {echo "active";}?>"><a href="reports.php"><em class="fa fa-file">&nbsp;</em> View Reports</a></li>
			<li class="<?php if($page=="upload-image") {echo "active";}?>"><a href="upload-image.php"><em class="fa fa-th-large">&nbsp;</em> Plate Recognition</a></li>
			
		</ul>
		
	</div><!--/.sidebar-->