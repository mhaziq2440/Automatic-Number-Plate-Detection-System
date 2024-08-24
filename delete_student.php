<?php
// delete-student.php

session_start();
include('includes/dbconn.php');

if (isset($_GET['deleteid']) && isset($_GET['studentid'])) {
    $deleteId = $_GET['deleteid'];
    $studentId = $_GET['studentid'];

    $deleteQuery = mysqli_query($con, "DELETE FROM student_vehicle_info WHERE ID='$deleteId' AND StudentID='$studentId'");

    if ($deleteQuery) {
        $msg = "Record deleted successfully.";

        // Display a popup box for successful deletion
        echo "<script>
            setTimeout(function() {
                alert('Record deleted successfully.');
                window.location.href = 'student-staff-list.php?studentid=$studentId&msg=$msg&deletesuccess=true';
            }, 1000); // 1000 milliseconds = 1 second
        </script>";
    } else {
        $msg = "Deletion failed: " . mysqli_error($con);

        // Display a popup box for failed deletion
        echo "<script>
            setTimeout(function() {
                alert('Deletion failed. $msg');
                window.location.href = 'student-staff-list.php?studentid=$studentId&msg=$msg';
            }, 3000); // 3000 milliseconds = 3 seconds
        </script>";
    }
} else {
    // Redirect to the previous page if deleteid or studentid is not set
    echo "<script>
        setTimeout(function() {
            window.location.href = 'student-staff-list.php?studentid=$studentId';
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>";
}
?>
