<?php
// Establish a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

        
// Perform a job count query for the "Marketing" category
$categoryName = "Marketing";
$jobCountQuery = "SELECT COUNT(*) AS job_count FROM jobs WHERE j_category = '$categoryName'";
$jobCountResult = mysqli_query($conn, $jobCountQuery);
$jobCountRow = mysqli_fetch_assoc($jobCountResult);
$marketingJobCount = $jobCountRow["job_count"];

// Perform a job count query for the "Customer Service" category
$categoryName = "Customer Service";
$jobCountQuery = "SELECT COUNT(*) AS job_count FROM jobs WHERE j_category = '$categoryName'";
$jobCountResult = mysqli_query($conn, $jobCountQuery);
$jobCountRow = mysqli_fetch_assoc($jobCountResult);
$customerServiceJobCount = $jobCountRow["job_count"];

// Perform a job count query for the "Human Resource" category
$categoryName = "Human Resource";
$jobCountQuery = "SELECT COUNT(*) AS job_count FROM jobs WHERE j_category = '$categoryName'";
$jobCountResult = mysqli_query($conn, $jobCountQuery);
$jobCountRow = mysqli_fetch_assoc($jobCountResult);
$humanResourceJobCount = $jobCountRow["job_count"];

// Perform a job count query for the "Project Management" category
$categoryName = "Project Management";
$jobCountQuery = "SELECT COUNT(*) AS job_count FROM jobs WHERE j_category = '$categoryName'";
$jobCountResult = mysqli_query($conn, $jobCountQuery);
$jobCountRow = mysqli_fetch_assoc($jobCountResult);
$projectManagementJobCount = $jobCountRow["job_count"];

// Perform a job count query for the "Business Development" category
$categoryName = "Business Development";
$jobCountQuery = "SELECT COUNT(*) AS job_count FROM jobs WHERE j_category = '$categoryName'";
$jobCountResult = mysqli_query($conn, $jobCountQuery);
$jobCountRow = mysqli_fetch_assoc($jobCountResult);
$businessDevelopmentJobCount = $jobCountRow["job_count"];

// Perform a job count query for the "Sales & Communication" category
$categoryName = "Sales & Communication";
$jobCountQuery = "SELECT COUNT(*) AS job_count FROM jobs WHERE j_category = '$categoryName'";
$jobCountResult = mysqli_query($conn, $jobCountQuery);
$jobCountRow = mysqli_fetch_assoc($jobCountResult);
$salesCommunicationJobCount = $jobCountRow["job_count"];

// Perform a job count query for the "Teaching & Education" category
$categoryName = "Teaching & Education";
$jobCountQuery = "SELECT COUNT(*) AS job_count FROM jobs WHERE j_category = '$categoryName'";
$jobCountResult = mysqli_query($conn, $jobCountQuery);
$jobCountRow = mysqli_fetch_assoc($jobCountResult);
$teachingEducationJobCount = $jobCountRow["job_count"];

// Perform a job count query for the "Design & Creative" category
$categoryName = "Design & Creative";
$jobCountQuery = "SELECT COUNT(*) AS job_count FROM jobs WHERE j_category = '$categoryName'";
$jobCountResult = mysqli_query($conn, $jobCountQuery);
$jobCountRow = mysqli_fetch_assoc($jobCountResult);
$designCreativeJobCount = $jobCountRow["job_count"];

?>

        <!-- Category Start -->
        <div class="container-xxl py-5">
    <div class="container">
        <h1 class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">Explore By Category</h1>
        <div class="row g-4">
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
            <a class="cat-item rounded p-4" href="joblisting.php?category=Marketing" >
                    <i class="fa fa-3x fa-mail-bulk text-primary mb-4"></i>
                    <h6 class="mb-3">Marketing</h6>
                    <p class="mb-0"><?php echo $marketingJobCount; ?> Vacancy(s)</p>
                </a>
            </div>
            <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
    <a class="cat-item rounded p-4" href="joblisting.php?category=Customer Service">
        <i class="fa fa-3x fa-headset text-primary mb-4"></i>
        <h6 class="mb-3">Customer Service</h6>
        <p class="mb-0"><?php echo $customerServiceJobCount; ?> Vacancy(s)</p>
    </a>
</div>

                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                    <a class="cat-item rounded p-4" href="joblisting.php?category=Human Resource">
                        <i class="fa fa-3x fa-user-tie text-primary mb-4"></i>
                        <h6 class="mb-3">Human Resource</h6>
                        <p class="mb-0"><?php echo $humanResourceJobCount; ?> Vacancy(s)</p>
                    </a>
                </div>

                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                    <a class="cat-item rounded p-4" href="joblisting.php?category=Project Management">
                        <i class="fa fa-3x fa-tasks text-primary mb-4"></i>
                        <h6 class="mb-3">Project Management</h6>
                        <p class="mb-0"><?php echo $projectManagementJobCount; ?> Vacancy(s)</p>
                    </a>
                </div>

                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                    <a class="cat-item rounded p-4" href="joblisting.php?category=Business Development">
                        <i class="fa fa-3x fa-chart-line text-primary mb-4"></i>
                        <h6 class="mb-3">Business Development</h6>
                        <p class="mb-0"><?php echo $businessDevelopmentJobCount; ?> Vacancy(s)</p>
                    </a>
                </div>

                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                <a class="cat-item rounded p-4" href="joblisting.php?category=Sales%20%26%20Communication">
                        <i class="fa fa-3x fa-hands-helping text-primary mb-4"></i>
                        <h6 class="mb-3">Sales & Communication</h6>
                        <p class="mb-0"><?php echo $salesCommunicationJobCount; ?> Vacancy(s)</p>
                    </a>
                </div>

                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.5s">
                <a class="cat-item rounded p-4" href="joblisting.php?category=Teaching%20%26%20Education">
                        <i class="fa fa-3x fa-book-reader text-primary mb-4"></i>
                        <h6 class="mb-3">Teaching & Education</h6>
                        <p class="mb-0"><?php echo $teachingEducationJobCount; ?> Vacancy(s)</p>
                    </a>
                </div>

                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.7s">
                <a class="cat-item rounded p-4" href="joblisting.php?category=Design%20%26%20Creative">
                        <i class="fa fa-3x fa-drafting-compass text-primary mb-4"></i>
                        <h6 class="mb-3">Design & Creative</h6>
                        <p class="mb-0"><?php echo $designCreativeJobCount; ?> Vacancy(s)</p>
                    </a>
                </div>

        </div>
    </div>
</div>
<script>
    function showJobList(category) {
        // Send an AJAX request to fetch job listings for the selected category
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var jobListContainer = document.getElementById("jobListContainer");
                jobListContainer.innerHTML = xhr.responseText;
            }
        };
        
        xhr.open("GET", "common/joblisting.php?category=" + encodeURIComponent(category), true);
        xhr.send();
    }
</script>

        <!-- Category End -->