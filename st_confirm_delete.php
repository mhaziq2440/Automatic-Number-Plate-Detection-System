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
        // Vehicle belongs to the logged-in staff, show confirmation prompt
        echo '<script>
                var confirmDelete = confirm("Are you sure you want to delete this vehicle?");
                if (confirmDelete) {
                    window.location.href = "st_delete_vehicle.php?confirmed=1&deleteid=' . $deleteID . '";
                } else {
                    window.location.href = "staff_veh_list.php";
                }
              </script>';
        exit();
    } else {
        // Vehicle does not belong to the logged-in staff
        echo "You do not have permission to delete this vehicle.";
    }
} else if (isset($_GET['confirmed']) && $_GET['confirmed'] == 1) {
    // Handle confirmed deletion
    $deleteID = $_GET['deleteid'];
    $deleteQuery = "DELETE FROM staff_vehicle_info WHERE ID = $deleteID";
    $deleteResult = mysqli_query($con, $deleteQuery);

    if ($deleteResult) {
        // Deletion successful
        echo "Delete successful";
    } else {
        // Error in deletion
        echo "Error: " . mysqli_error($con);
    }
} else {
    // Invalid or missing deleteid parameter
    echo "Invalid request.";
}
?>