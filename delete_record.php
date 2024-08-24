<?php
session_start();
include('includes/dbconn.php');

if (isset($_GET['deleteid']) && is_numeric($_GET['deleteid']) && isset($_GET['userType'])) {
    $deleteID = $_GET['deleteid'];
    $userType = $_GET['userType'];

    $tableName = ($userType == 'student') ? 'student_vehicle_info' : 'staff_vehicle_info';

    // Perform the deletion with proper SQL injection prevention
    $deleteQuery = "DELETE FROM $tableName WHERE ID = ?";
    $stmt = mysqli_prepare($con, $deleteQuery);
    
    // Bind the ID parameter
    mysqli_stmt_bind_param($stmt, "i", $deleteID);

    // Execute the statement
    $deleteResult = mysqli_stmt_execute($stmt);

    // Check if deletion was successful
    if ($deleteResult) {
        // Deletion successful
        header('Location: student-staff-list.php'); // Redirect to your vehicles list page
        exit();
    } else {
        // Error in deletion
        echo "Error: " . mysqli_error($con);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Invalid or missing parameters
    echo "Invalid request.";
}
?>
