<?php
// Function to fetch job applications for a specific company along with job title
function getJobApplications($c_id) {
    $conn = new mysqli('localhost', 'root', '', 'login');
    
    // Check for connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Updated query to join job_applications and jobs tables to fetch job title (j_title)
    $query = "
        SELECT ja.application_id, ja.user_id, ja.job_id, ja.a_name, ja.email, ja.cover_letter, 
               ja.resume_filename, ja.status, j.j_title
        FROM job_applications ja
        JOIN jobs j ON ja.job_id = j.j_id  -- Correct column name 'j_id' in the jobs table
        WHERE ja.company_id = ?";
    
    // Prepare the SQL statement
    $stmt = $conn->prepare($query);

    // Check if the preparation of the statement was successful
    if ($stmt === false) {
        die("Error preparing query: " . $conn->error); // Output the error message
    }

    // Bind parameters (company ID should be an integer)
    $stmt->bind_param("i", $c_id);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    $jobApplications = array();

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $jobApplications[] = $row;
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return $jobApplications;
}

// Handle approve/deny actions when buttons are clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['application_id']) && isset($_POST['action'])) {
        $application_id = intval($_POST['application_id']);
        $action = $_POST['action'];

        // Validate the action (approve or deny)
        if ($action == 'approve' || $action == 'deny') {
            $conn = new mysqli('localhost', 'root', '', 'login');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $status = ($action == 'approve') ? 'approved' : 'denied';
            $query = "UPDATE job_applications SET status = ? WHERE application_id = ?";
            $stmt = $conn->prepare($query);
            
            if ($stmt === false) {
                die("Error preparing query: " . $conn->error); // Output the error message
            }

            $stmt->bind_param('si', $status, $application_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Application $status successfully.');</script>";
            } else {
                echo "<script>alert('Error updating application status.');</script>";
            }

            $stmt->close();
            $conn->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include('common/head.php'); ?>

<body>
    <?php include('common/nav.php'); ?>
    <div class='container-xxl py-5'>
        <div class='container'>
            <h1 class='text-center mb-5 wow fadeInUp' data-wow-delay='0.1s'>Job Applications</h1>

            <?php
            // Check if c_id is provided and sanitize
            if (isset($_GET['c_id'])) {
                $c_id = intval($_GET['c_id']); // Sanitize company ID
                $jobApplications = getJobApplications($c_id);

                // Display job applications in a table
                if (!empty($jobApplications)) {
                    echo '<div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Application ID</th>
                                    <th>User ID</th>
                                    <th>Job ID</th>
                                    <th>Job Title</th>  <!-- New column for Job Title -->
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Cover Letter</th>
                                    <th>Resume Filename</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

                    foreach ($jobApplications as $application) {
                        // Assign status tag based on the application status
                        $statusTag = '';
                        if ($application['status'] == 'approved') {
                            $statusTag = '<span class="badge bg-success">Approved</span>';
                        } elseif ($application['status'] == 'denied') {
                            $statusTag = '<span class="badge bg-danger">Rejected</span>';
                        }

                        // Only display the action buttons if the status is 'pending'
                        $actionButtons = '';
                        if ($application['status'] == 'pending') {
                            $actionButtons = "
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='application_id' value='{$application['application_id']}'>
                                    <button type='submit' name='action' value='approve' class='btn btn-outline-success btn-sm'>Approve</button>
                                </form>
                                <form action='' method='POST' style='display:inline;'>
                                    <input type='hidden' name='application_id' value='{$application['application_id']}'>
                                    <button type='submit' name='action' value='deny' class='btn btn-outline-danger btn-sm'>Deny</button>
                                </form>
                            ";
                        }

                        echo "<tr>
                                <td>{$application['application_id']}</td>
                                <td>{$application['user_id']}</td>
                                <td>{$application['job_id']}</td>
                                <td>{$application['j_title']}</td>  <!-- Display job title -->
                                <td>{$application['a_name']}</td>
                                <td>{$application['email']}</td>
                                <td>{$application['cover_letter']}</td>
                                <td>
                                    <a href='../uploads/{$application['resume_filename']}' target='_blank' class='btn btn-outline-info btn-sm'>Download</a>
                                </td>
                                <td>
                                    <!-- Status tag in the action column -->
                                    $statusTag
                                    
                                    <!-- Action buttons only if status is 'pending' -->
                                    $actionButtons
                                </td>
                            </tr>";
                    }

                    echo '</tbody></table></div>';
                } else {
                    echo "No job applications found for company with c_id $c_id.";
                }
            } else {
                echo "Company ID is missing.";
            }
            ?>
        </div>
    </div>

    <?php include('../common/footer.php'); ?>

</body>

</html>
