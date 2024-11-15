<?php include( 'connection.php') ?>

<?php

// Perform database operations here...
$sql = "SELECT * FROM `jobs`";
$result = mysqli_query($con, $sql);
// Close the connection
mysqli_close($con);
?>
        <?php include( 'common/head.php') ?>
<body>
    <?php include( 'common/navbar.php') ?>


        <!-- Header End -->
        <div class="container-xxl py-5 bg-dark page-header mb-5">
            <div class="container my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Job List</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-uppercase">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        
                        <li class="breadcrumb-item text-white active" aria-current="page">Job List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Header End -->
    <?php include( 'common/search.php') ?>

        <div class='container-xxl py-5'>
    <div class='container'>
        <h1 class='text-center mb-5 wow fadeInUp' data-wow-delay='0.1s'>Job Listing</h1>
        <div class='tab-class text-center wow fadeInUp' data-wow-delay='0.3s'>
            <div class='tab-content'>
                <div id='tab-1' class='tab-pane fade show p-0 active'>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
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
                                        <img class='flex-shrink-0 img-fluid border rounded-circle' src='uploads/$companyLogo' alt='Company Logo' style='width: 80px; height: 80px;'>
                                        <div class='text-start ps-4'>
                                            <h5 class='mb-3'>$jobTitle</h5>
                                            <span class='text-truncate me-3'><i class='fa fa-map-marker-alt text-primary me-2'></i>$jobAddress</span>
                                            <span class='text-truncate me-3'><i class='far fa-clock text-primary me-2'></i>$jobNature</span>
                                            <span class='text-truncate me-0'><i class='far fa-money-bill-alt text-primary me-2'></i>$minSalary - $maxSalary</span>
                                        </div>
                                    </div>
                                    <div class='col-sm-12 col-md-4 d-flex flex-column align-items-start align-items-md-end justify-content-center'>
                                        <div class='d-flex mb-3'>
                                            <a class='btn btn-primary' href='job-detail.php?j_id= $jobId'>View Details</a>

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
                
            </div>
        </div>    
    </div>
</div>

            </div>
        <!-- Jobs End -->


            <?php include( 'common/footer.php') ?>