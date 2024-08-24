<?php
session_start();
include('includes/dbconn.php');

if (isset($_GET['deleteid']) && is_numeric($_GET['deleteid'])) {
    $deleteID = $_GET['deleteid'];
    
    // Check if the vehicle belongs to the logged-in student
    $studentID = $_SESSION['studentID'];
    $checkQuery = "SELECT ID FROM student_vehicle_info WHERE ID = $deleteID AND StudentID = $studentID";
    $checkResult = mysqli_query($con, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        // Vehicle belongs to the logged-in student, proceed with deletion
        $deleteQuery = "DELETE FROM student_vehicle_info WHERE ID = $deleteID";
        $deleteResult = mysqli_query($con, $deleteQuery);

        if ($deleteResult) {
            // Deletion successful
            header('Location: s_veh_list.php'); // Redirect to your vehicles list page
            exit();
        } else {
            // Error in deletion
            echo "Error: " . mysqli_error($con);
        }
    } else {
        // Vehicle does not belong to the logged-in student
        echo "You do not have permission to delete this vehicle.";
    }
} else {
    // Invalid or missing deleteid parameter
    echo "Invalid request.";
}
?>
