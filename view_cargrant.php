<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('includes/dbconn.php');

if (strlen($_SESSION['vpmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_GET['detailid'])) {
        $detailId = $_GET['detailid'];

        // Fetch the CarGrant PDF file name from the student_pending table based on detailId
        $query = mysqli_query($con, "SELECT CarGrant FROM student_pending WHERE ID='$detailId'");
        $row = mysqli_fetch_assoc($query);

        // Get the CarGrant PDF file name
        $carGrantFileName = $row['CarGrant'];

        // Construct the path to the CarGrant PDF file
        $carGrantFilePath = 'uploads/' . $carGrantFileName;

        // Check if the file exists
        if (file_exists($carGrantFilePath)) {
            // Output the PDF file
            header('Content-type: application/pdf');
            readfile($carGrantFilePath);
        } else {
            echo 'CarGrant PDF not found.';
        }
    }
}
?>
