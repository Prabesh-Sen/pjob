<?php
session_start(); // Start the session

// Check if the company is signed in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $user = $_SESSION["u_name"];
    $email = $_SESSION['email'];
    $_SESSION['status'] = "Signed In successfully";
    $_SESSION['status_code'] = "success";
} else {
    $_SESSION['status'] = "Sign In First!";
    $_SESSION['status_code'] = "error";
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

// Retrieve user details based on logged-in user
$query = "SELECT email, u_id, address FROM users WHERE u_name = ?"; // Correct column name 'address'
$stmt = mysqli_prepare($con, $query);

if ($stmt === false) {
    // Error preparing the statement
    die('Error preparing the query: ' . mysqli_error($con));
}

mysqli_stmt_bind_param($stmt, 's', $user); // Bind the username to the prepared statement
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['u_id'] = $row['u_id'];
    $_SESSION['username'] = $user;
    $_SESSION['email'] = $row['email'];
    $user_address = $row['address'];  // Use 'address' column
}

// Fetch all job details with the company logo
$sql = "SELECT j.j_id, j.j_title, j.j_address, j.j_nature, j.min_salary, j.maximum_salary, j.date_added, c.c_logo 
        FROM jobs j
        INNER JOIN company c ON j.c_id = c.c_id";
$result1 = mysqli_query($con, $sql);

// Fetch categories (if needed)
$query = "SELECT * FROM `category`";
$res = mysqli_query($con, $query);

// Job recommendations based on user address and search history
$recommended_jobs = [];
if (!empty($user_address)) {
    // First, get the search history for the user
    $history_query = "SELECT DISTINCT searched_keyword FROM user_search_history WHERE u_id = ? ORDER BY searched_time DESC LIMIT 5";
    $stmt_history = mysqli_prepare($con, $history_query);
    if ($stmt_history === false) {
        die('Error preparing the history query: ' . mysqli_error($con));
    }
    
    mysqli_stmt_bind_param($stmt_history, 'i', $_SESSION['u_id']);
    mysqli_stmt_execute($stmt_history);
    $result_history = mysqli_stmt_get_result($stmt_history);
    
    // Get all the searched keywords
    $search_keywords = [];
    while ($history_row = mysqli_fetch_assoc($result_history)) {
        $search_keywords[] = $history_row['searched_keyword'];
    }
    
    // Create a base query for job recommendations (both address and search history)
    $recommend_query = "SELECT j.j_id, j.j_title, j.j_address, j.j_nature, j.min_salary, j.maximum_salary, j.date_added, c.c_logo 
                        FROM jobs j
                        INNER JOIN company c ON j.c_id = c.c_id
                        WHERE j.j_address LIKE ? ";
    
    // Add conditions for search keywords if there are any
    if (count($search_keywords) > 0) {
        $search_conditions = [];
        foreach ($search_keywords as $keyword) {
            $search_conditions[] = "j.j_title LIKE ? OR j.j_category LIKE ? OR j.j_nature LIKE ?";
        }
        $recommend_query .= " AND (" . implode(" OR ", $search_conditions) . ")";
    }
    
    $recommend_query .= " ORDER BY j.date_added DESC LIMIT 5";  // Limit the recommendations to 5
    
    // Prepare the final recommendation query
    $stmt_recommend = mysqli_prepare($con, $recommend_query);
    if ($stmt_recommend === false) {
        die('Error preparing the recommendation query: ' . mysqli_error($con));
    }
    
    // Bind the parameters for address and search history keywords
    $search_address = "%$user_address%";
    $params = [$search_address];
    foreach ($search_keywords as $keyword) {
        $params[] = "%" . $keyword . "%";  // Add the search keyword for job title, category, or nature
        $params[] = "%" . $keyword . "%";
        $params[] = "%" . $keyword . "%";
    }
    
    // Bind dynamic parameters to the prepared statement
    mysqli_stmt_bind_param($stmt_recommend, str_repeat('s', count($params)), ...$params);
    
    // Execute the statement
    mysqli_stmt_execute($stmt_recommend);
    $result_recommend = mysqli_stmt_get_result($stmt_recommend);
    
    if ($result_recommend && mysqli_num_rows($result_recommend) > 0) {
        while ($recommended_job = mysqli_fetch_assoc($result_recommend)) {
            $recommended_jobs[] = $recommended_job;
        }
    }
}
?>

<?php include('common/head.php'); ?>

<body>
    <?php include('common/nav.php'); ?>

    <!-- Carousel Start -->
    <div class="container-fluid p-0">
        <div class="owl-carousel header-carousel position-relative">
            <div class="owl-carousel-item position-relative">
                <img class="img-fluid" src="img/5.jpg" alt="">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(43, 57, 64, .5);">
                    <div class="container">
                        <div class="row justify-content-start">
                            <div class="col-10 col-lg-8">
                                <h1 class="display-3 text-white animated slideInDown mb-4">Find The Perfect Job That You Deserved</h1>
                                <p class="fs-5 fw-medium text-white mb-4 pb-2">Search, Apply & Get Jobs in Nepal - Free</p>
                                <a href="job-list.php" class="btn btn-primary py-md-3 px-md-5 me-3 animated slideInLeft">Find job.</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->
    <?php include('../common/search.php'); ?>

    <!-- Job Recommendations Based on User's Address and Search History -->
    <?php if (count($recommended_jobs) > 0): ?>
    <div class="container my-5">
        <h2 class="text-center">Job Recommendations</h2>
        <div class="row">
            <?php foreach ($recommended_jobs as $job): ?>
                <div class="col-md-4">
                    <div class="job-item p-4 mb-4" style="display: flex; flex-direction: column; background: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); height: 100%;">
                        <div class="row g-4 d-flex flex-column" style="flex-grow: 1;">
                            <div class="col-sm-12 col-md-8 d-flex align-items-center mb-3">
                                <img class="flex-shrink-0 img-fluid border rounded-circle" src="../uploads/<?php echo htmlspecialchars($job['c_logo']); ?>" alt="Company Logo" style="width: 80px; height: 80px;">
                                <div class="text-start ps-4">
                                    <h5 class="mb-3" style="font-size: 1.2rem; font-weight: bold;"><?php echo htmlspecialchars($job['j_title']); ?></h5>
                                    <span class="text-truncate me-3" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><i class="fa fa-map-marker-alt text-primary me-2"></i><?php echo htmlspecialchars($job['j_address']); ?></span>
                                    <span class="text-truncate me-3" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><i class="far fa-clock text-primary me-2"></i><?php echo htmlspecialchars($job['j_nature']); ?></span>
                                    <span class="text-truncate me-0" style="display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><i class="far fa-money-bill-alt text-primary me-2"></i><?php echo htmlspecialchars($job['min_salary']); ?> - <?php echo htmlspecialchars($job['maximum_salary']); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-end" style="margin-top: auto;">
                                <a class="btn btn-primary" href="job-detail.php?j_id=<?php echo htmlspecialchars($job['j_id']); ?>">Apply Now!</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <p class="text-center">No job recommendations based on your location or search history.</p>
<?php endif; ?>


    <!-- Categories and About Sections -->
    <?php include('../common/allcategory.php'); ?>
    <?php include('../common/allabout.php'); ?>

    <!-- Jobs Start -->
    <div class='container-xxl py-5'>
        <div class='container'>
            <h1 class='text-center mb-5 wow fadeInUp' data-wow-delay='0.1s'>Job Listing</h1>
            <div class='tab-class text-center wow fadeInUp' data-wow-delay='0.3s'>
                <div class='tab-content'>
                    <div id='tab-1' class='tab-pane fade show p-0 active'>
                        <?php
                        if (mysqli_num_rows($result1) > 0) {
                            while ($row = mysqli_fetch_assoc($result1)) {
                                // Access job data
                                $jobId = $row["j_id"];
                                $jobTitle = $row["j_title"];
                                $jobAddress = $row["j_address"];
                                $jobNature = $row["j_nature"];
                                $minSalary = $row["min_salary"];
                                $maxSalary = $row["maximum_salary"];
                                $dateAdded = $row["date_added"];
                                $companyLogo = $row["c_logo"] ? $row["c_logo"] : "default_logo.png";

                                // Display job item with company logo
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
                                                <a class='btn btn-primary' href='job-detail.php?j_id=$jobId'>Apply Now!</a>
                                            </div>
                                            <small class='text-truncate'><i class='far fa-id-badge text-primary me-2'></i>$jobId</small>
                                            <small class='text-truncate'><i class='far fa-calendar-alt text-primary me-2'></i>$dateAdded</small>
                                        </div>   
                                    </div>
                                </div>";
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

    <?php include('../common/footer.php'); ?>
</body>
</html>

<?php 
// Close the connection at the end
mysqli_close($con);
?>
