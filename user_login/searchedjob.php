<?php
session_start(); // Start the session

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login"; // Replace with your actual database name

// Create a connection to the database
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Get the search keyword from the URL (GET request) and sanitize it
$keyword = '';
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = trim($_GET['keyword']);
}

// If no keyword is provided, redirect to the home page (optional)
if (empty($keyword)) {
    header("Location: index.php");
    exit;
}

// Check if the user is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    $user_id = $_SESSION['u_id']; // Get user ID from session
} else {
    // If user is not logged in, redirect to login page
    header("Location: signinusr.php");
    exit();
}

// Insert search history into the database
$searched_time = date("Y-m-d H:i:s"); // Get current timestamp
$searchQuery = "INSERT INTO user_search_history (u_id, searched_time, searched_keyword) VALUES (?, ?, ?)";
$stmt = $db->prepare($searchQuery);

// Check if the statement was prepared successfully
if ($stmt === false) {
    die('Error preparing the query: ' . $db->error);
}

$stmt->bind_param("iss", $user_id, $searched_time, $keyword);
$stmt->execute();
$stmt->close();

// SQL Query to search for jobs based on the keyword
$sql = "SELECT * FROM jobs WHERE 
        LOWER(j_title) LIKE ? OR 
        LOWER(j_category) LIKE ? OR 
        LOWER(j_address) LIKE ? OR 
        LOWER(j_nature) LIKE ? OR 
        LOWER(j_qualification) LIKE ?";

// Prepare the statement
$stmt = $db->prepare($sql);

// Bind parameters to the query
$searchTerm = "%" . strtolower($keyword) . "%";
$stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch all results into an array
$jobs = [];
while ($row = $result->fetch_assoc()) {
    // Fetch the company logo
    $companyId = $row['c_id'];
    $logoQuery = "SELECT c_logo FROM company WHERE c_id = ?";
    $logoStmt = $db->prepare($logoQuery);
    $logoStmt->bind_param("i", $companyId);
    $logoStmt->execute();
    $logoResult = $logoStmt->get_result();
    $row['companyLogo'] = 'default_logo.png'; // Default logo if none is found

    if ($logoResult && $logoResult->num_rows > 0) {
        $logoRow = $logoResult->fetch_assoc();
        $row['companyLogo'] = $logoRow['c_logo'];
    }

    $jobs[] = $row; // Add the job entry to the array
}

// Close the statement and connection
$stmt->close();
$db->close();
?>

<?php include('common/head.php'); ?>

<body>
<?php include('common/nav.php'); ?>
<?php include('../common/search.php'); ?>

<!-- Main Content -->
<div class="container-xxl py-5">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Search Results</h1>

        <!-- Check if results exist -->
        <?php if (count($jobs) > 0): ?>
            <div class="row">
                <?php foreach ($jobs as $job): ?>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow-sm border-0 rounded">
                            <div class="card-body">
                                <!-- Display company logo -->
                                <img src="../uploads/<?php echo htmlspecialchars($job['companyLogo']); ?>" alt="Company Logo" class="img-fluid border rounded-circle" style="width: 80px; height: 80px;">
                                
                                <!-- Job Title and Details -->
                                <h5 class="mt-3"><?php echo htmlspecialchars($job['j_title']); ?></h5>
                                <p class="text-muted"><?php echo htmlspecialchars($job['j_category']); ?></p>
                                <p><i class="fa fa-map-marker-alt"></i> <?php echo htmlspecialchars($job['j_address']); ?></p>
                                <p><i class="far fa-clock"></i> <?php echo htmlspecialchars($job['j_nature']); ?></p>
                                <p><i class="far fa-money-bill-alt"></i> <?php echo htmlspecialchars($job['min_salary']); ?> - <?php echo htmlspecialchars($job['maximum_salary']); ?></p>
                                <p><i class="far fa-calendar-alt"></i> Posted on: <?php echo htmlspecialchars($job['date_added']); ?></p>

                                <!-- Apply Now Button -->
                                <a href="job-detail.php?j_id=<?php echo $job['j_id']; ?>&co_id=<?php echo $job['c_id']; ?>" class="btn btn-primary">Apply Now</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No jobs found for your search criteria.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
