<?php
session_start(); // Start the session

// Check if the company is signed in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // The company is signed in
    $companyname = $_SESSION['companyname'];
    $email = $_SESSION['email'];
} else {
    // The company is not signed in
    // Redirect the company to the login page or display an error message
    header("Location: signupcomp.php");
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

// Check if the job ID is provided in the URL
if (isset($_GET['j_id'])) {
    // Use prepared statement to safely insert job ID
    $jobId = mysqli_real_escape_string($connection, $_GET['j_id']);

    // Verify if the job belongs to the logged-in company (for security)
    $verifyQuery = "SELECT * FROM jobs WHERE j_id = ? AND c_id = ?";
    
    // Create a prepared statement
    if ($stmt = mysqli_prepare($connection, $verifyQuery)) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "ii", $jobId, $_SESSION['c_id']);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Get the result
        mysqli_stmt_store_result($stmt);
        
        // Check the number of rows returned
        if (mysqli_stmt_num_rows($stmt) === 1) {
            // Job belongs to the logged-in company, allow editing
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Handle the form submission for editing the job
                $title = $_POST['title'];
                $category = $_POST['category'];
                $address = $_POST['address'];
                $min_salary = $_POST['minsal'];
                $max_salary = $_POST['maxsal'];
                $job_nature = $_POST['jnat'];
                $job_description = $_POST['jdis'];
                $job_qualification = $_POST['jqual'];
                $job_responsibility = $_POST['jres'];
                
                // Prepare the query using prepared statements to prevent SQL injection
                $updateQuery = "UPDATE jobs SET j_title=?, j_category=?, j_address=?, min_salary=?, maximum_salary=?, j_nature=?, j_description=?, j_qualification=?, j_responsibility=? WHERE j_id=?";

                // Prepare and bind the statement
                $updateStmt = mysqli_prepare($connection, $updateQuery);
                mysqli_stmt_bind_param($updateStmt, "sssssssssi", $title, $category, $address, $min_salary, $max_salary, $job_nature, $job_description, $job_qualification, $job_responsibility, $jobId);

                // Execute the statement
                $result = mysqli_stmt_execute($updateStmt);

                if ($result) {
                    echo "Job details updated successfully.";
                } else {
                    echo "Failed to update job details: " . mysqli_error($connection);
                }

                // Close the statement
                mysqli_stmt_close($updateStmt);
            } else {
                // Fetch the job details for pre-populating the edit form
                $fetchQuery = "SELECT * FROM jobs WHERE j_id = ?";
                if ($fetchStmt = mysqli_prepare($connection, $fetchQuery)) {
                    // Bind the parameters
                    mysqli_stmt_bind_param($fetchStmt, "i", $jobId);

                    // Execute the fetch statement
                    mysqli_stmt_execute($fetchStmt);

                    // Get the result
                    $result = mysqli_stmt_get_result($fetchStmt);

                    // Fetch job details
                    $jobDetails = mysqli_fetch_assoc($result);

                    // Close the fetch statement
                    mysqli_stmt_close($fetchStmt);
                }
            }
            ?>
<!DOCTYPE html>
<html lang="en">
<?php include('common/head.php') ?>

<body>
    <?php include('common/nav.php') ?> <br><br>

    <div class="reg-box">
        <div class="form-box add">
            <form action="edit-job.php?j_id=<?php echo $jobId; ?>" method="POST">
                <h2>Edit Job</h2>
                <div class="input-box">
                    <input type="text" name="title" class="form-control border-0" placeholder="Job Title"
                        value="<?php echo $jobDetails['j_title']; ?>" required />
                </div>
                <div class="input_box">
                    <select name="category" class="form-select border-0" required>
                        <option value="">Category</option>
                        <option value="Marketing" <?php if ($jobDetails['j_category'] === 'Marketing') echo 'selected'; ?>>
                            Marketing</option>
                        <option value="Costumer Service" <?php if ($jobDetails['j_category'] === 'Costumer Service') echo 'selected'; ?>>
                            Customer Service</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="input-box">
                    <input type="text" name="address" class="form-control border-0" placeholder="Address"
                        value="<?php echo $jobDetails['j_address']; ?>" required />
                </div>
                <div class="input-box">
                    <input type="number" name="minsal" class="form-control border-0" placeholder="Minimum Salary"
                        value="<?php echo $jobDetails['min_salary']; ?>" required />
                </div>
                <div class="input-box">
                    <input type="number" name="maxsal" class="form-control border-0" placeholder="Maximum Salary"
                        value="<?php echo $jobDetails['maximum_salary']; ?>" required />
                </div>
                <div class="input-box">
                    <select name="jnat" class="form-select border-0" required>
                        <option value="">Job Nature</option>
                        <option value="Part time" <?php if ($jobDetails['j_nature'] === 'Part time') echo 'selected'; ?>>
                            Part time</option>
                        <option value="Full time" <?php if ($jobDetails['j_nature'] === 'Full time') echo 'selected'; ?>>
                            Full time</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="input-box">
                    <textarea name="jdis" class="form-control" rows="5" placeholder="Job Description"
                        required><?php echo $jobDetails['j_description']; ?></textarea>
                </div><br><br>
                <div class="input-box">
                    <textarea name="jres" class="form-control" rows="5" placeholder="Responsibility"
                        required><?php echo $jobDetails['j_responsibility']; ?></textarea>
                </div><br><br>
                <div class="input-box">
                    <select name="jqual" class="form-select border-0" required>
                        <option value="">Qualification</option>
                        <option value="+2" <?php if ($jobDetails['j_qualification'] === '+2') echo 'selected'; ?>>+2
                        </option>
                        <option value="Bachelor's Degree" <?php if ($jobDetails['j_qualification'] === "Bachelor's Degree") echo 'selected'; ?>>
                            Bachelor's Degree</option>
                        <option value="Master's Degree" <?php if ($jobDetails['j_qualification'] === "Master's Degree") echo 'selected'; ?>>
                            Master's Degree</option>
                        <!-- Add more options as needed -->
                    </select>
                </div><br>
                <div class="submit">
                    <button type="submit" class="btn1" value="submit" name="submit">Update</button>
                </div>

            </form>
        </div>
    </div>
    <br>
    <br>
</body>

</html>
<?php
        } else {
            // The job does not belong to the logged-in company or not found
            echo "You do not have permission to edit this job or it does not exist.";
        }

        // Close the verification statement
        mysqli_stmt_close($stmt);
    }
} else {
    // Handle the case where the job ID is not provided in the URL
    echo "Invalid Job ID.";
}

// Close the connection
mysqli_close($connection);
?>
