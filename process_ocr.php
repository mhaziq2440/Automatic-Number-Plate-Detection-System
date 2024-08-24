<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OCR Image Upload</title>
    <meta charset="utf-8">
          <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <!-- Include Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>

    <?php include 'includes/navigation.php' ?>
    
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="dashboard.php">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Number Plate Recognition</li>
			</ol>
		</div><!--/.row-->
	
		<?php
		$page="upload-image";
		include 'includes/sidebar.php'
		?>

    <?php

if (isset($_FILES['image'])) {
    $file_name = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];
    move_uploaded_file($file_tmp, "images/" . $file_name);
    echo "<h3>Image Upload Success</h3>";
    echo '<img src="images/' . $file_name . '" style="width:100%">';

    // Read the image file and convert to base64
    $image_data = base64_encode(file_get_contents("images/" . $file_name));

    // Call ALPR integration script
    $alpr_script = "alpr_integration.php";
    $response = sendBase64ToAlpr($alpr_script, $image_data);

    // Display ALPR results or error
    if (isset($response['data']['results']) && !empty($response['data']['results'])) {
        $top_candidate = $response['data']['results'][0]['candidates'][0];

        echo "<br><h3>License Plate Recognition Result</h3><br>";
        echo "Plate: " . $top_candidate['plate'] . "<br>";

        // Check if the plate exists in the student database
        $studentResult = checkPlateInDatabase($top_candidate['plate'], 'student_vehicle_info');
        if ($studentResult) {
            echo "Plate found in student database.<br>";

            // Fetch student details from the database
            $studentDetails = getStudentDetailsByPlate($top_candidate['plate']);
            if ($studentDetails) {
                echo "<h3>Student Details</h3>";
                echo "Student ID: " . $studentDetails['StudentID'] . "<br>";
                echo "Student Name: " . $studentDetails['studentName'] . "<br>";
                echo "Vehicle Category: " . $studentDetails['VehicleCategory'] . "<br>";
                echo "Vehicle Model: " . $studentDetails['VehicleCompanyname'] . "<br>";
                echo "Registration Number: " . $studentDetails['RegistrationNumber'] . "<br>";
                echo "Owner Name: " . $studentDetails['OwnerName'] . "<br>";
                echo "Owner Contact Number: " . $studentDetails['OwnerContactNumber'] . "<br>";
                // Include other student details you want to display
                echo '<a href="detail-student.php?updateid=' . $studentDetails['ID'] . '&studentid=' . $studentDetails['StudentID'] . '&category=' . $studentDetails['VehicleCategory'] . '&company=' . $studentDetails['VehicleCompanyname'] . '&reg_number=' . $studentDetails['RegistrationNumber'] . '&owner_name=' . $studentDetails['OwnerName'] . '&contact_number=' . $studentDetails['OwnerContactNumber'] . '&FineCharge=' . $studentDetails['FineCharge'] . '&remark=' . $studentDetails['Remark'] . '">';
                echo '<button type="button" class="btn btn-sm btn-info">Edit Details</button>';
                echo '</a>';
                
            } else {
                echo "Error fetching student details.";
            }
        } else {
            // Check if the plate exists in the staff database
            $staffResult = checkPlateInDatabase($top_candidate['plate'], 'staff_vehicle_info');
            if ($staffResult) {
                echo "Plate found in staff database.<br>";
                // Additional logic for staff data retrieval or actions
            } else {
                echo "Plate not found in student or staff database. Visitor detected.<br>";
                // Additional logic for visitor actions
            }
        }
    } elseif (isset($response['error'])) {
        echo "<br>Error: " . $response['error'];
    }
}

function checkPlateInDatabase($plateNumber, $tableName)
{
    // Implement your database connection here
    // Use proper prepared statements to prevent SQL injection

    include('includes/dbconn.php'); // Include your database connection file

    $sql = "SELECT * FROM $tableName WHERE RegistrationNumber = '$plateNumber'";
    $result = $con->query($sql);

    $con->close();

    return $result->num_rows > 0;
}
    
function getStudentDetailsByPlate($plateNumber)
{
    include('includes/dbconn.php'); // Include your database connection file



    $sql = "SELECT * FROM student_vehicle_info WHERE RegistrationNumber = '$plateNumber'";
    $result = $con->query($sql);

    $con->close();

    return $result->fetch_assoc();
}

function sendBase64ToAlpr($alpr_script, $image_data)
{
    $ch = curl_init();
    $alpr_url = "http://localhost/image2text/{$alpr_script}"; // Update with the correct URL

    curl_setopt($ch, CURLOPT_URL, $alpr_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ['image' => $image_data]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
?>


    <?php include 'includes/footer.php'?>

</body>
</html>






