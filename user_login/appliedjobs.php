<?php
session_start(); // Start the session

// Ensure user ID is present in the URL
if (isset($_GET['u_id'])) {
    $u_id = $_GET['u_id'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'login');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a SQL query to select job_id and status where user_id equals u_id
    $query = "SELECT job_id, status FROM job_applications WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $u_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize an array to store job data
    $jobData = array();

    if ($result->num_rows > 0) {
        // User has applied to one or more jobs
        while ($row = $result->fetch_assoc()) {
            $job_id = $row['job_id'];
            $status = $row['status']; // Fetch the status for this job application

            // Fetch job data from the 'jobs' table for each job_id
            $jobQuery = "SELECT * FROM jobs WHERE j_id = ?";
            $jobStmt = $conn->prepare($jobQuery);
            $jobStmt->bind_param("i", $job_id);
            $jobStmt->execute();
            $jobResult = $jobStmt->get_result();

            if ($jobResult->num_rows > 0) {
                while ($jobRow = $jobResult->fetch_assoc()) {
                    // Initialize an array to store job details
                    $jobDetails = array();
                    $jobDetails["j_id"] = $jobRow["j_id"];
                    $jobDetails["j_title"] = $jobRow["j_title"];
                    $jobDetails["j_address"] = $jobRow["j_address"];
                    $jobDetails["j_nature"] = $jobRow["j_nature"];
                    $jobDetails["min_salary"] = $jobRow["min_salary"];
                    $jobDetails["maximum_salary"] = $jobRow["maximum_salary"];
                    $jobDetails["date_added"] = $jobRow["date_added"];
                    $jobDetails["c_id"] = $jobRow["c_id"];
                    $jobDetails["status"] = $status; // Add the status to job details

                    // Fetch the company logo from the "company" table using c_id
                    $companyLogoQuery = "SELECT c_logo FROM company WHERE c_id = ?";
                    $companyLogoStmt = $conn->prepare($companyLogoQuery);
                    $companyLogoStmt->bind_param("i", $jobDetails["c_id"]);
                    $companyLogoStmt->execute();
                    $companyLogoResult = $companyLogoStmt->get_result();

                    if ($companyLogoResult->num_rows > 0) {
                        $companyLogoRow = $companyLogoResult->fetch_assoc();
                        $jobDetails["c_logo"] = $companyLogoRow["c_logo"];
                    } else {
                        // Use a default logo if logo not found
                        $jobDetails["c_logo"] = "default_logo.png"; // Replace with the default logo filename and path
                    }

                    // Append job details to the jobData array
                    $jobData[] = $jobDetails;
                }
            }
        }
    } else {
        // User has not applied to any jobs
        echo "User with u_id $u_id has not applied to any jobs.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Handle the case where u_id is not provided
    echo "User ID is missing.";
}
?>

<!-- HTML for displaying job data and status -->
<!DOCTYPE html>
<html lang="en">
<?php include('common/head.php') ?>
<?php include('common/nav.php') ?>

<body>
    <!-- Jobs Start -->
    <div class='container-xxl py-5'>
        <div class='container'>
            <h1 class='text-center mb-5 wow fadeInUp' data-wow-delay='0.1s'>Applied Job(s)</h1>
            <div class='tab-class text-center wow fadeInUp' data-wow-delay='0.3s'>
                <div class='tab-content'>
                    <div id='tab-1' class='tab-pane fade show p-0 active'>
                        <?php
                        if (count($jobData) > 0) {
                            foreach ($jobData as $job) {
                                // Access job data
                                $jobId = $job["j_id"];
                                $jobTitle = $job["j_title"];
                                $jobAddress = $job["j_address"];
                                $jobNature = $job["j_nature"];
                                $minSalary = $job["min_salary"];
                                $maxSalary = $job["maximum_salary"];
                                $dateAdded = $job["date_added"];
                                $companyId = $job["c_id"];
                                $companyLogo = $job["c_logo"]; // Assuming you have fetched this in your query
                                $status = $job["status"]; // Get the status for the job application

                                // Construct the company logo path
                                $companyLogoPath = '../uploads/' . $companyLogo;

                                // Display job item with company logo and status
                                echo "
                                <div class='job-item p-4 mb-4'>
                                    <div class='row g-4'>
                                        <div class='col-sm-12 col-md-8 d-flex align-items-center'>
                                            <img class='flex-shrink-0 img-fluid border rounded-circle' src='$companyLogoPath' alt='Company Logo' style='width: 80px; height: 80px;'>
                                            <div class='text-start ps-4'>
                                                <h5 class='mb-3'>$jobTitle</h5>
                                                <span class='text-truncate me-3'><i class='fa fa-map-marker-alt text-primary me-2'></i>$jobAddress</span>
                                                <span class='text-truncate me-3'><i class='far fa-clock text-primary me-2'></i>$jobNature</span>
                                                <span class='text-truncate me-0'><i class='far fa-money-bill-alt text-primary me-2'></i>$minSalary - $maxSalary</span>
                                            </div>
                                        </div>
                                        <div class='col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center'>
                                            <div class='d-flex mb-3'>
                                                <a class='btn btn-primary' href=''>Status: $status</a> <!-- Displaying the status -->
                                            </div>
                                            <small class='text-truncate'><i class='far fa-id-badge text-primary me-2'></i> $jobId </small>
                                            <small class='text-truncate'><i class='far fa-calendar-alt text-primary me-2'></i>$dateAdded</small>
                                        </div>
                                    </div>
                                </div>
                                ";
                            }
                        } else {
                            echo "No jobs found.";
                        }
                        ?>
                    </div><br>
                    <a class='btn btn-primary py-3 px-5' href='job-list.php'>Browse More Jobs</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Jobs End -->
    
    <?php include('../common/footer.php') ?>
</body>
</html>
