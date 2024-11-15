<?php include( 'common/head.php') ?>
<body>
<?php include( 'common/nav.php') ?>
<div class='container-xxl py-5'>
    <div class='container'>
        <h1 class='text-center mb-5 wow fadeInUp' data-wow-delay='0.1s'></h1>
        <div class='tab-class text-center wow fadeInUp' data-wow-delay='0.3s'>
            <div class='tab-content'>
                <div id='tab-1' class='tab-pane fade show p-0 active'>
                        <?php
                        if (isset($_GET['category'])) {
                            $category = $_GET['category'];
                            echo "<h1 class='text-center mb-5 wow fadeInUp' data-wow-delay='0.1s'>$category Jobs</h1>";

                            // Connect to the database
                            $db = new mysqli("localhost", "root", "", "login");

                            if ($db->connect_error) {
                                die("Connection failed: " . $db->connect_error);
                            }

                        // Fetch job listings for the selected category

                        $sql = "SELECT * FROM jobs WHERE j_category = '$category'";
                        $result = $db->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
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
                                $db = new mysqli("localhost", "root", "", "login");
                                if (mysqli_connect_errno()) {
                                    die("Failed to connect to MySQL: " . mysqli_connect_error());
                                }

                                // Fetch the company logo from the "company" table
                                $query_logo = "SELECT c_logo FROM company WHERE c_id = $companyId";
                                $result_logo = mysqli_query($db, $query_logo);

                                // Close the logo connection
                                mysqli_close($db);

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
                                            <a class='btn btn-primary' href='job-detail.php?j_id=$jobId; &co_id= $companyId;'>Apply Now</a>

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
                        
                        }


                        ?>
                    </div>    
                </div>
        </div>
    </div>
</div>    
</body>
        <?php include( '../common/footer.php') ?>