
<?php
session_start(); // Start the session

// Check if the company is signed in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // The company is signed in
    $user =$_SESSION["u_name"];
    $email = $_SESSION['email'];
    

    // Continue with the desired code for a signed-in company
    // For example, display the company's dashboard or perform authorized actions
    $_SESSION['status']="Signed In successfully";
    $_SESSION['status_code']="success";

} else {
    // The company is not signed in
    // Redirect the company to the login page or display an error message
    $_SESSION['status']="Sign In First!";
    $_SESSION['status_code']="error";
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
$username = "u_name";

$query = "SELECT email, u_id FROM users WHERE u_name = '$username'";

$result = mysqli_query($connection, $query);

// Check if the query was successful and retrieve the email value
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $userid= $row['u_id'];

    // Set the username and email session variables
    $_SESSION['u_id'] = $userid;
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    
}



?>
<?php
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

// Perform database operations here...
$sql = "SELECT * FROM `jobs`";
$result = mysqli_query($con, $sql);
$query= "SELECT * FROM `category`";
$res = mysqli_query($con,$query);

// Close the connection
mysqli_close($con);
?>
<?php
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

// Perform database operations here...
$sql = "SELECT * FROM `jobs`";
$sql = "SELECT j.*, c.c_logo FROM jobs j
                              INNER JOIN company c ON j.c_id = c.c_id";
$result1 = mysqli_query($con, $sql);
$query= "SELECT * FROM `category`";
$res = mysqli_query($con,$query);

// Close the connection
mysqli_close($con);
?>





<?php include( 'common/head.php') ?>


<body>
<?php include( 'common/nav.php') ?>
    

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
        <?php include( '../common/search.php') ?>

         
        <?php include( '../common/allcategory.php') ?>

        <?php include( '../common/allabout.php') ?>
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

                            // Access company ID to fetch the company logo
                            $companyId = $row["c_id"];
                            
                            // Create a connection to fetch the company logo
                            $con_logo = mysqli_connect($hostname, $username, $password, $database);
                            if (mysqli_connect_errno()) {
                                die("Failed to connect to MySQL: " . mysqli_connect_error());
                            }

                            // Fetch the company logo from the "company" table
                            $query_logo = "SELECT c_logo FROM company WHERE c_id = $companyId";
                            $result_logo = mysqli_query($con_logo, $query_logo);

                            // Close the logo connection
                            mysqli_close($con_logo);

                            if ($result_logo && mysqli_num_rows($result_logo) > 0) {
                                $row_logo = mysqli_fetch_assoc($result_logo);
                                $companyLogo = $row_logo["c_logo"];
                            } else {
                                // Use a default logo if logo not found
                                $companyLogo = "default_logo.png"; // Replace with the default logo filename and path
                            }

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
                                            <a class='btn btn-primary' href='job-detail.php?j_id= $jobId'>Apply Now!</a>

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

            </div>

        <!-- Jobs End -->

         <!-- featuerd company  start-->
    <section class="companies" id="companies">
        <h1 class="section-title"> Featured Companies</h1>
        
        <div class="featured-wrap">
                <?php
                // Retrieve company data from the database
                $companyQuery = "SELECT * FROM company";
                $companyResult = mysqli_query($conn, $companyQuery);

                if (mysqli_num_rows($companyResult) > 0) {
                    while ($companyRow = mysqli_fetch_assoc($companyResult)) {
                        $companyName = $companyRow['c_name'];
                        $companyImage = $companyRow['c_logo'];
                    ?>
            <div class="featured-card1">
                <img class="featured-image" src="img/<?php echo $companyImage; ?>">
                <p><?php echo $companyName; ?></p>
                <button class="featured-button2">View jobs</button>
            </div>
            <?php
        }
    }
    ?>
        </div>
    </section>
    <!-- featured company end -->

    <?php include( '../common/footer.php') ?>