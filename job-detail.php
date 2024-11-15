<?php include( 'connection.php') ?>

<?php

// Check if the job ID is provided in the URL
if (isset($_GET['j_id'])) {
    $jobId = $_GET['j_id'];

    // Retrieve the job details from the "jobs" table
    $query = "SELECT * FROM jobs WHERE j_id = $jobId"; // Make sure to use the correct column name (e.g., 'j_id')
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
        $companyId = $jobData["c_id"]; // Assuming the foreign key column is named 'c_id'

        // Close the result set
        mysqli_free_result($result);

        // Now retrieve the company details from the "companies" table based on the fetched company ID
        $queryCompany = "SELECT * FROM company WHERE c_id = $companyId";
        $resultCompany = mysqli_query($con, $queryCompany);

        if ($resultCompany && mysqli_num_rows($resultCompany) > 0) {
            // Fetch company data
            $companyData = mysqli_fetch_assoc($resultCompany);
            $companyName = $companyData["c_name"];
            $companyLocation = $companyData["c_add"];
            $companydetail = $companyData["c_detail"];
            $companylogo = $companyData["c_logo"];
            // ... and other company-related data

            // Close the company result set
            mysqli_free_result($resultCompany);
        } else {
            // Company data not found or error occurred
            // Handle the case where the company data is not found in the database
            $companyName = "Company Not Found";
            $companyLocation = "N/A";
            // ... and other default values for company data
        }
    } else {
        // Job not found or error occurred
        // Handle the case where the job is not found in the database
        $jobTitle = "Job Not Found";
        $jobAddress = "N/A";
        // ... and other default values for job data
    }
} else {
    // Handle the case where the job ID is not provided in the URL
    $jobTitle = "Invalid Job ID";
    $jobAddress = "N/A";
    // ... and other default values for job data
}

// Close the connection
mysqli_close($con);
?>
<?php include( 'common/head.php') ?>



<body>
<?php include( 'common/navbar.php') ?>

        <!-- Header End -->
        <div class="container-xxl py-5 bg-dark page-header mb-5">
            <div class="container my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Job Detail</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-uppercase">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        
                        <li class="breadcrumb-item text-white active" aria-current="page">Job Detail</li>
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
                    <img class="flex-shrink-0 img-fluid border rounded" src="uploads/<?php echo $companylogo; ?>" alt="" style="width: 80px; height: 80px;">
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

                    <p></p>
                    
                </div>

                <div class="">
                    <h4 class="mb-4">Apply For The Job</h4>
                    <form>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="email" class="form-control" placeholder="Your Email">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="text" class="form-control" placeholder="Portfolio Website">
                            </div>
                            <div class="col-12 col-sm-6">
                                <input type="file" class="form-control bg-white">
                            </div>
                            <div class="col-12">
                                <textarea class="form-control" rows="5" placeholder="Coverletter"></textarea>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Apply Now</button>
                            </div>
                        </div>
                    </form>
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
</div>

        <!-- Job Detail End -->


        <?php include( 'common/footer.php') ?>