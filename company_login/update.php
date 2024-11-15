<?php
// Check if the application ID and status are provided
if (isset($_POST['applicationId']) && isset($_POST['status'])) {
    $applicationId = $_POST['applicationId'];
    $status = $_POST['status'];

    // Connect to the database
    $conn = new mysqli('localhost', 'username', 'password', 'database_name');

    // Check the database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL query to update the "status" column in the "job_applications" table
    $query = "UPDATE job_applications SET status = ? WHERE application_id = ?";
    $stmt = $conn->prepare($query);

    // Bind parameters
    $stmt->bind_param('si', $status, $applicationId);

    // Execute the query
    if ($stmt->execute()) {
        echo 'Application ' . ucfirst($status) . 'ed successfully.';
    } else {
        echo 'Error ' . $status . 'ing application.';
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
} else {
    echo 'Application ID and status not provided.';
}
?>
