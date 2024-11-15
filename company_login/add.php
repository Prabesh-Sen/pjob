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

// Fetch company details from the database using the session data
$query = "SELECT email, c_id FROM company WHERE c_name = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['companyname']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if the query was successful and retrieve the email and company ID
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $companyid = $row['c_id'];

    // Set the company ID session variable
    $_SESSION['c_id'] = $companyid;
} else {
    echo "Company not found!";
    exit();
}

// Handle job upload form submission
if (isset($_POST['submit'])) {
    // Collect form data
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
    $query = "INSERT INTO `jobs` (`j_title`, `j_category`, `j_address`, `min_salary`, `maximum_salary`, `j_nature`, `j_description`, `j_qualification`, `j_responsibility`, `c_id`)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind the statement
    $statement = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($statement, "ssssssssss", $title, $category, $address, $min_salary, $max_salary, $job_nature, $job_description, $job_qualification, $job_responsibility, $_SESSION['c_id']);

    // Execute the statement
    $result = mysqli_stmt_execute($statement);

    if ($result) {
        echo '<script>alert("Job Uploaded!");</script>';
        echo '<script>window.location.href = "index.php";</script>';
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    // Close the statement
    mysqli_stmt_close($statement);
}

// Close the connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('common/head.php') ?>

<body>
<?php include('common/nav.php') ?>

<!-- The Modal (Dialog Box) -->
<dialog id="jobModal" class="modal">
    <div class="modal-content">
        <button id="closeModalBtn" class="close-btn">&times;</button>
        <h2 class="modal-heading">Add Job</h2>
        <form action="add.php" method="POST" id="jobForm">
            <div class="input-box">
                <input type="text" name="title" class="form-control" placeholder="Job Title" required />
            </div>
            <div class="input-box">
                <select name="category" class="form-select" required>
                    <option value="">Category</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Customer Service">Customer Service</option>
                    <option value="Human Resource">Human Resource</option>
                    <option value="Project Management">Project Management</option>
                    <option value="Business Development">Business Development</option>
                    <option value="Sales & Communication">Sales & Communication</option>
                    <option value="Teaching & Education">Teaching & Education</option>
                    <option value="Design & Creative">Design & Creative</option>
                </select>
            </div>
            <div class="input-box">
                <select name="address" class="form-select" required>
                    <option value="">Select District</option>
                    <option value="Kathmandu">Kathmandu</option>
                    <option value="Pokhara">Pokhara</option>
                    <option value="Lalitpur">Lalitpur</option>
                    <option value="Bhaktapur">Bhaktapur</option>
                    <option value="Chitwan">Chitwan</option>
                    <option value="Lumbini">Lumbini</option>
                    <option value="Bhairahawa">Bhairahawa</option>
                    <option value="Janakpur">Janakpur</option>
                    <option value="Butwal">Butwal</option>
                    <option value="Biratnagar">Biratnagar</option>
                    <option value="Birgunj">Birgunj</option>
                    <option value="Nepalgunj">Nepalgunj</option>
                    <option value="Hetauda">Hetauda</option>
                </select>
            </div>
            <div class="input-box">
                <input type="number" name="minsal" class="form-control" placeholder="Minimum Salary" required min="1" id="minsal" />
            </div>
            <div class="input-box">
                <input type="number" name="maxsal" class="form-control" placeholder="Maximum Salary" required min="1" id="maxsal" />
            </div>

            <!-- Instant validation for salary -->
            <div id="salaryError" class="error-message">Minimum salary cannot be greater than Maximum salary.</div>
            <div id="negativeSalaryError" class="error-message">Salary cannot be negative.</div>

            <div class="input-box">
                <select name="jnat" class="form-select" required>
                    <option value="">Job Nature</option>
                    <option value="Part time">Part time</option>
                    <option value="Full time">Full time</option>
                </select>
            </div>
            <div class="input-box">
                <textarea name="jdis" class="form-control" rows="5" placeholder="Job Description" required></textarea>
            </div>
            <div class="input-box">
                <textarea name="jres" class="form-control" rows="5" placeholder="Responsibilities" required></textarea>
            </div>
            <div class="input-box">
                <select name="jqual" class="form-select" required>
                    <option value="">Qualification</option>
                    <option value="+2">+2</option>
                    <option value="Bachelor's Degree">Bachelor's Degree</option>
                    <option value="Master's Degree">Master's Degree</option>
                </select>
            </div>

            <div class="submit">
                <button type="submit" class="btn-submit" name="submit">Submit</button>
            </div>
        </form>
    </div>
</dialog>

<!-- Modal Styling and Script -->
<style>
    /* Modal Background */
    .modal {
        display: block; /* Automatically show the modal on page load */
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7); 
        padding-top: 60px;
    }

    /* Modal Content */
    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 30px;
        border-radius: 10px;
        width: 80%;
        max-width: 600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.5s ease-in-out;
    }

    /* Modal Heading */
    .modal-heading {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }

    /* Close Button */
    .close-btn {
        font-size: 30px;
        font-weight: bold;
        color: #aaa;
        background: none;
        border: none;
        position: absolute;
        top: 10px;
        right: 20px;
        cursor: pointer;
    }

    .close-btn:hover {
        color: black;
    }

    /* Form Input Fields */
    .input-box {
        margin-bottom: 20px;
    }

    .form-control,
    .form-select,
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease-in-out;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #007BFF;
        outline: none;
    }

    textarea {
        resize: vertical;
    }

    .submit {
        text-align: center;
    }

    .btn-submit {
        background-color: #007BFF;
        color: white;
        padding: 12px 20px;
        font-size: 18px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }

    /* Error messages */
    .error-message {
        color: red;
        font-size: 14px;
        display: none;
    }

    /* Animation */
    @keyframes fadeIn {
        0% { opacity: 0; }
        100% { opacity: 1; }
    }
</style>

<script>
    // Instant salary validation
    document.getElementById("minsal").addEventListener("input", validateSalary);
    document.getElementById("maxsal").addEventListener("input", validateSalary);

    function validateSalary() {
        var minSalary = parseInt(document.getElementById("minsal").value);
        var maxSalary = parseInt(document.getElementById("maxsal").value);

        var salaryError = document.getElementById("salaryError");
        var negativeSalaryError = document.getElementById("negativeSalaryError");

        // Check for negative salary
        if (minSalary < 0 || maxSalary < 0) {
            negativeSalaryError.style.display = "block";
        } else {
            negativeSalaryError.style.display = "none";
        }

        // Check if minSalary is greater than maxSalary
        if (minSalary >= maxSalary && !isNaN(minSalary) && !isNaN(maxSalary)) {
            salaryError.style.display = "block";
        } else {
            salaryError.style.display = "none";
        }
    }

    // Close modal and redirect to index.php
    document.getElementById("closeModalBtn").onclick = function() {
        window.location.href = "index.php"; // Redirect to index page
    }

    // Prevent modal from closing when clicking outside of it
    window.onclick = function(event) {
        if (event.target !== document.getElementById("jobModal") && !document.getElementById("jobModal").contains(event.target)) {
            event.stopPropagation(); // Prevent closing the modal
        }
    }
</script>

</body>
</html>
