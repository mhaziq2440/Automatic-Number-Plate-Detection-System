<?php
// Function to insert visitor details into the database without checking for duplicates
function insertVisitorDetails($con, $plateNumber)
{
    // Fixed values for vehicle category, company name, owner full name, and contact number
    $vehicleCategory = 'Four-Wheel';  // Fixed value for four-wheel
    $companyName = null;              // Null value for company name
    $ownerFullName = null;            // Null value for owner full name
    $ownerContactNumber = null;       // Null value for contact number

    // Insert data into the visitor_vehicle_info table
    $sql = "INSERT INTO vehicle_info (RegistrationNumber, VehicleCategory, VehicleCompanyname, OwnerName, OwnerContactNumber)
            VALUES ('$plateNumber', '$vehicleCategory', '$companyName', '$ownerFullName', '$ownerContactNumber')";

    $result = $con->query($sql);

    if (!$result) {
        die('Error: ' . $con->error);
    }

    return $result;
}

session_start();
error_reporting(0);
include('includes/dbconn.php');

if (strlen($_SESSION['vpmsaid'] == 0)) {
    header('location:logout.php');
} else {
    if (isset($_FILES['image'])) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($file_tmp, "images/" . $file_name);

        // Read the image file and convert to base64
        $image_data = base64_encode(file_get_contents("images/" . $file_name));

        // Call ALPR integration script
        $alpr_script = "alpr_integration.php";
        $response = sendBase64ToAlpr($alpr_script, $image_data, $con);

        // Display ALPR results or error
        if (isset($response['data']['results']) && !empty($response['data']['results'])) {
            $top_candidate = $response['data']['results'][0]['candidates'][0];

            // Insert visitor details into the database
            $insertResult = insertVisitorDetails($con, $top_candidate['plate']);

            if ($insertResult) {
                echo "<script>alert('Vehicle Entry Detail has been added');</script>";
                echo "<script>window.location.href ='dashboard.php'</script>";
            } else {
                echo "Error registering visitor.<br>";
            }
        } elseif (isset($response['error'])) {
            echo "<br>Error: " . $response['error'];
        }
    }

    // Include the rest of your code here...
}

function checkPlateInDatabase($con, $plateNumber, $tableName)
{
    // Implement your database connection here
    // Use proper prepared statements to prevent SQL injection

    $sql = "SELECT * FROM $tableName WHERE RegistrationNumber = '$plateNumber'";
    $result = $con->query($sql);

    if (!$result) {
        die('Error: ' . $con->error);
    }

    return $result->num_rows > 0;
}

function sendBase64ToAlpr($alpr_script, $image_data, $con)
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

<?php include 'includes/footer.php' ?>
<!-- Include the rest of your code here... -->
</body>
</html>