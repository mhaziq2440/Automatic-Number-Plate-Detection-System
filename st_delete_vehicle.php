<?php
session_start();
include('includes/dbconn.php');

if (isset($_GET['deleteid']) && is_numeric($_GET['deleteid'])) {
    $deleteID = $_GET['deleteid'];
    
    // Check if the vehicle belongs to the logged-in staff
    $staffID = $_SESSION['staffID'];
    $checkQuery = "SELECT ID FROM staff_vehicle_info WHERE ID = $deleteID AND StaffID = $staffID";
    $checkResult = mysqli_query($con, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // Vehicle belongs to the logged-in staff, proceed with deletion
        $deleteQuery = "DELETE FROM staff_vehicle_info WHERE ID = $deleteID";
        $deleteResult = mysqli_query($con, $deleteQuery);

        if ($deleteResult) {
            // Deletion successful
            header('Location: st_veh_list.php'); // Redirect to staff vehicles list page
            exit();
        } else {
            // Error in deletion
            echo "Error: " . mysqli_error($con);
        }
    } else {
        // Vehicle does not belong to the logged-in staff
        echo "You do not have permission to delete this vehicle.";
    }
} else {
    // Invalid or missing deleteid parameter
    echo "Invalid request.";
}
?>
