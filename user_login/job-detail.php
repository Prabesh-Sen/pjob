<?php
session_start(); // Start the session

// Check if the company is signed in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // The company is signed in
    $user = $_SESSION["u_name"];
    $email = $_SESSION['email'];
    $user_id = $_SESSION['u_id']; // User ID from the session
} else {
    // The company is not signed in
    header("Location: ../signinusr.php");
    exit;
}

// Database connection
$hostname = 'localhost';  
$username = 'root';       
$password = '';   
$database = 'login';      
$con = mysqli_connect($hostname, $username, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Check if the job ID is provided in the URL
if (isset($_GET['j_id'])) {
    $jobId = $_GET['j_id'];

    // Retrieve the job details from the "jobs" table
    $query = "SELECT * FROM jobs WHERE j_id = $jobId";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch job data
        $jobData = mysqli_fetch_assoc($result);
        $jobTitle = $jobData["j_title"];
        $jobAddress = $jobData["j_address"];
        $jobNature = $jobData["j_nature"];
        $minSalary = $jobData["min_salary"];
        $maxSalary = $jobData["maximum_salary"];
        $detail = $jobData["j_description"];
        $respo = $jobData["j_responsibility"];
        $qual = $jobData["j_qualification"];
        $date = $jobData["date_added"];
        $companyId = $jobData["c_id"]; 

        // Close the result set
        mysqli_free_result($result);

        // Now retrieve the company details from the "company" table based on the fetched company ID
        $queryCompany = "SELECT * FROM company WHERE c_id = $companyId";
        $resultCompany = mysqli_query($con, $queryCompany);

        if ($resultCompany && mysqli_num_rows($resultCompany) > 0) {
            // Fetch company data
            $companyData = mysqli_fetch_assoc($resultCompany);
            $companyName = $companyData["c_name"];
            $companyLocation = $companyData["c_add"];
            $companydetail = $companyData["c_detail"];
            $companylogo = $companyData["c_logo"];
            mysqli_free_result($resultCompany);
        } else {
            // Company data not found or error occurred
            $companyName = "Company Not Found";
            $companyLocation = "N/A";
        }
    } else {
        // Job not found
        $jobTitle = "Job Not Found";
        $jobAddress = "N/A";
    }
} else {
    // Handle the case where the job ID is not provided in the URL
    $jobTitle = "Invalid Job ID";
    $jobAddress = "N/A";
}

// Close the database connection
mysqli_close($con);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure user is logged in
    if (!isset($_SESSION['u_id'])) {
        echo "User not authenticated.";
        exit;
    }

    // Retrieve the user ID from the session
    $user_id = $_SESSION['u_id'];

    // Get the job ID from the form data
    $job_id = $_POST['jid'];

    // Get the company ID from the form data
    $company_id = $_POST['company_id']; 

    // Connect to the database again (for application submission)
    $conn = new mysqli('localhost', 'root', '', 'login');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the application already exists for the same job and user
    $check_sql = "SELECT COUNT(*) AS count FROM job_applications WHERE job_id = ? AND user_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ii", $job_id, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Application already exists, do not insert again
        echo '<script>alert("Application already submitted for this job!");</script>';
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        // Application does not exist, proceed with insertion

        // Sanitize and store form data
        $cover_letter = $_POST["cover_letter"];
        $resume_filename = $_FILES["resume"]["name"];

        // Move the uploaded resume to the "uploads" folder
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($resume_filename);
        move_uploaded_file($_FILES["resume"]["tmp_name"], $target_file);

        // Insert data into the database
        $insert_sql = "INSERT INTO job_applications (company_id, user_id, job_id, a_name, email, cover_letter, resume_filename) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("iiissss", $company_id, $user_id, $job_id, $user, $email, $cover_letter, $resume_filename);

        if ($stmt->execute()) {
            echo '<script>alert("Application submitted successfully!");</script>';
            echo '<script>window.location.href = "index.php";</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('common/head.php') ?>

<body>
    <?php include('common/nav.php') ?>

    <!-- Header Start -->
    <div class="container-xxl py-5 bg-dark page-header mb-5">
        <div class="container my-5 pt-5 pb-4">
            <h1 class="display-3 text-white mb-3 animated slideInDown"><?php echo $jobTitle; ?></h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page"><?php echo $jobTitle; ?></li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Header End -->

    <!-- Job Detail Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gy-5 gx-4">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-5">
                        <img class="flex-shrink-0 img-fluid border rounded" src="../uploads/<?php echo $companylogo; ?>" alt="" style="width: 80px; height: 80px;">
                        <div class="text-start ps-4">
                            <h3 class="mb-3"><?php echo $jobTitle; ?></h3>
                            <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo $jobAddress; ?></span>
                            <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i><?php echo $jobNature; ?></span>
                            <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>NRs <?php echo $minSalary; ?> - NRs <?php echo $maxSalary; ?></span>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h4 class="mb-3">Job description</h4>
                        <p><?php echo $detail; ?></p>
                        <h4 class="mb-3">Responsibility</h4>
                        <p><?php echo $respo; ?></p>
                        <h4 class="mb-3">Qualifications</h4>
                        <p><?php echo $qual; ?></p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                        <h4 class="mb-4">Job Summery</h4>
                        <p><i class="fa fa-angle-right text-primary me-2"></i>Published On: <?php echo $date; ?></p>
                        <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: 123 Position</p>
                        <p><i class="fa fa-angle-right text-primary me-2"></i>Job Nature: <?php echo $jobNature; ?></p>
                        <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: NRs <?php echo $minSalary; ?> - NRs <?php echo $maxSalary; ?></p>
                        <p><i class="fa fa-angle-right text-primary me-2"></i>Location: <?php echo $jobAddress; ?></p>
                    </div>

                    <div class="bg-light rounded p-5 wow slideInUp" data-wow-delay="0.1s">
                        <h4 class="mb-4">Company Detail</h4>
                        <?php echo $companydetail; ?>
                    </div>
                </div>
            </div>

            <!-- Application Form Start -->
            <div class="">
                <h4 class="mb-4">Apply For The Job</h4>
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="company_id" value="<?php echo $companyId; ?>">

                    <!-- Hidden User Info (Automatically filled) -->
                    <input type="hidden" name="name" value="<?php echo $user; ?>">
                    <input type="hidden" name="email" value="<?php echo $email; ?>">

                    <div class="row g-3">
                        <!-- Cover Letter Section -->
                        <div class="col-12">
                            <textarea class="form-control" rows="5" name="cover_letter" placeholder="Coverletter" required></textarea>
                        </div>
                        <!-- Resume Upload Section -->
                        <div class="col-12 col-sm-6">
                            <input type="file" class="form-control bg-white" name="resume" accept=".pdf, .txt, .doc, .docx" required>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit">Apply Now</button>
                        </div>
                    </div>
                    <input type="hidden" name="jid" value="<?php echo htmlspecialchars($jobId); ?>">
                </form>
            </div>
            <!-- Application Form End -->
        </div>
    </div>
    <!-- Job Detail End -->

    <?php include('../common/footer.php') ?>
</body>
</html>
