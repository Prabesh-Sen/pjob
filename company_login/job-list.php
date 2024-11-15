<?php
session_start(); // Start the session

// Check if the company is signed in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $companyname = $_SESSION['companyname'];
    $email = $_SESSION['email'];
    $companyId = $_SESSION['c_id']; // Assume companyId is stored in session
} else {
    header("Location: ../signinusr.php");
    exit;
}

// Establish the database connection
$host = "localhost";
$username = "root";
$password = "";
$dbName = "login";

// Create the database connection
$connection = mysqli_connect($host, $username, $password, $dbName);

// Check if the connection was successful
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get search parameters from the URL (GET request)
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($connection, $_GET['keyword']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($connection, $_GET['category']) : '';
$location = isset($_GET['location']) ? mysqli_real_escape_string($connection, $_GET['location']) : '';

// Build the base SQL query to fetch only jobs of the logged-in company
$sql = "SELECT j.*, c.c_logo FROM jobs j 
        INNER JOIN company c ON j.c_id = c.c_id 
        WHERE j.c_id = '$companyId'"; // Restrict to jobs of the signed-in company

// Add conditions based on the search parameters
if ($keyword) {
    $sql .= " AND j.j_title LIKE '%$keyword%'";
}

if ($category) {
    $sql .= " AND j.j_category = '$category'";
}

if ($location) {
    $sql .= " AND j.j_address LIKE '%$location%'";
}

// Execute the query
$result1 = mysqli_query($connection, $sql);

// Fetch categories for the dropdown in the search form
$query_category = "SELECT * FROM category";
$res_category = mysqli_query($connection, $query_category);

// Close the connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('common/head.php') ?>

<body>
<?php include('common/nav.php') ?>

<div class="container-xxl py-5">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Your Job Listings</h1>
        <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.3s">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane fade show p-0 active">
                    <?php
                    // Check if the company has any jobs
                    if (mysqli_num_rows($result1) > 0) {
                        // Loop through the results and display the jobs
                        while ($row = mysqli_fetch_assoc($result1)) {
                            $jobId = $row["j_id"];
                            $jobTitle = $row["j_title"];
                            $jobAddress = $row["j_address"];
                            $jobNature = $row["j_nature"];
                            $minSalary = $row["min_salary"];
                            $maxSalary = $row["maximum_salary"];
                            $dateAdded = $row["date_added"];
                            $companyId = $row["c_id"];
                            $companyLogo = $row["c_logo"];

                            echo "
                            <div class='job-item p-4 mb-4'>
                                <div class='row g-4'>
                                    <div class='col-sm-12 col-md-8 d-flex align-items-center'>
                                        <img class='flex-shrink-0 img-fluid border rounded-circle' src='../uploads/$companyLogo' alt='Company Logo' style='width: 80px; height: 80px;'>
                                        <div class='text-start ps-4'>
                                            <h5 class='mb-3'>$jobTitle</h5>
                                            <span class='text-truncate me-3'><i class='fa fa-map-marker-alt text-primary me-2'></i>$jobAddress</span>
                                            <span class='text-truncate me-3'><i class='far fa-clock text-primary me-2'></i>$jobNature</span>
                                            <span class='text-truncate me-0'><i class='far fa-money-bill-alt text-primary me-2'></i>$minSalary - $maxSalary</span>
                                        </div>
                                    </div>
                                    <div class='col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center'>
                                        <div class='d-flex mb-3'>
                                            <a class='btn btn-primary' href='job-detail.php?j_id=$jobId&co_id=$companyId'>View</a>
                                        </div>
                                        <small class='text-truncate'><i class='far fa-id-badge text-primary me-2'></i> $jobId </small>
                                        <small class='text-truncate'><i class='far fa-calendar-alt text-primary me-2'></i>$dateAdded</small>
                                    </div>   
                                </div>
                            </div>
                        ";
                        }
                    } else {
                        // If no jobs found, display message and Add Job button
                        echo "<p>No jobs found for your company.</p>";
                        echo "<a class='btn btn-success py-3 px-5' href='add.php'>Add Job</a>";
                    }
                    ?>
                </div><br>
                <a class="btn btn-primary py-3 px-5" href="job-list.php">Browse More Jobs</a>
            </div>
        </div>    
    </div>
</div>

<?php include('../common/footer.php') ?>

</body>
</html>
