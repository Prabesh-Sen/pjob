<?php
// Start the session
session_start();

// Check if the company is signed in and retrieve the company ID
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $c_id = $_SESSION['c_id']; // Get the company ID from the session
    // Other session data...
} else {
    // The company is not signed in
    // Redirect the company to the login page or display an error message
    header("Location: ../signinusr.php");
    exit;
}

// Database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'login';

// Create a connection
$con = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Check if the confirmed parameter is provided in the URL
if (isset($_GET['j_id']) && isset($_GET['confirmed']) && $_GET['confirmed'] === 'true') {
    // Use prepared statement to safely insert job ID
    $jobId = mysqli_real_escape_string($con, $_GET['j_id']);

    // Delete job applications related to the job
    $deleteApplicationsQuery = "DELETE FROM job_applications WHERE job_id = ?";
    if ($deleteApplicationsStmt = mysqli_prepare($con, $deleteApplicationsQuery)) {
        mysqli_stmt_bind_param($deleteApplicationsStmt, "i", $jobId);
        mysqli_stmt_execute($deleteApplicationsStmt);
        mysqli_stmt_close($deleteApplicationsStmt);
    }

    // Now you can safely delete the job record
    $deleteQuery = "DELETE FROM jobs WHERE j_id = ?";
    if ($deleteStmt = mysqli_prepare($con, $deleteQuery)) {
        mysqli_stmt_bind_param($deleteStmt, "i", $jobId);
        if (mysqli_stmt_execute($deleteStmt)) {
            // Job deleted successfully
            echo "<div class='alert alert-success'>Job deleted successfully.</div>";

            header("Location: index.php"); // Redirect to a suitable page after deletion
            exit;
        } else {
            // Error occurred while deleting the job
            echo "Error: " . mysqli_error($con);
        }
        mysqli_stmt_close($deleteStmt);
    }
} else {
    // Handle the case where the confirmed parameter is not provided in the URL
    echo "Confirmation parameter missing.";
}

// Close the connection
mysqli_close($con);
?>
