<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['c_id'])) {
    // If not logged in or c_id is not set, redirect to the login page
    header("Location: signincomp.php");
    exit;
}

// Fetch the company ID from the session
$companyId = $_SESSION['c_id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Failed to connect: " . $conn->connect_error);
}

// Fetch current company profile details
$sql = "SELECT * FROM company WHERE c_id = '$companyId'";
$result = $conn->query($sql);
$company = $result->fetch_assoc();

// If no company is found
if (!$company) {
    die("Company not found!");
}

// Handle profile update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyname = $_POST['username'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $description = $_POST['description'];
    
    $logoName = $company['c_logo']; // Keep the current logo if not updating

    // If logo is uploaded, handle file upload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logoName = $_FILES['logo']['name'];
        $logoTmpName = $_FILES['logo']['tmp_name'];
        $logoDestination = 'uploads/' . $logoName;
        move_uploaded_file($logoTmpName, $logoDestination);
    }

    $currentDate = date('Y-m-d H:i:s');
    
    // Update the company details in the database
    $updateQuery = "UPDATE company SET c_name = ?, email = ?, c_add = ?, c_logo = ?, c_detail = ?, added_date = ? WHERE c_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssss", $companyname, $email, $address, $logoName, $description, $currentDate, $companyId);

    if ($stmt->execute()) {
        $_SESSION['status'] = "Profile updated successfully!";
        $_SESSION['status_code'] = "success";
        header("Location: edit-profile.php"); // Redirect after successful update
        exit;
    } else {
        $_SESSION['status'] = "Error updating profile!";
        $_SESSION['status_code'] = "error";
    }

    $stmt->close();
}

$conn->close();
?>

<?php include('common/head.php') ?>

<body>
    <?php include('common/nav.php') ?>

    <!-- Edit Profile Form -->
    <br><br><br><br><br><br>
    <div class="reg-box">
        <div class="form-box register">
            <form method="POST" action="edit-profile.php" enctype="multipart/form-data">
                <h2 style="color: #00B074;">Edit Profile</h2>
                
                <!-- Show Status Message -->
                <?php if (isset($_SESSION['status'])) { ?>
                    <p class="<?php echo $_SESSION['status_code']; ?>"><?php echo $_SESSION['status']; ?></p>
                    <?php unset($_SESSION['status'], $_SESSION['status_code']); ?>
                <?php } ?>

                <!-- Company Name -->
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="input" name="username" value="<?php echo htmlspecialchars($company['c_name']); ?>" required>
                    <label for="username">Company Name</label>
                </div>

                <!-- Email -->
                <div class="input-box">
                    <span class="icon"><i class="fa-regular fa-envelope"></i></span>
                    <input type="email" class="input" name="email" value="<?php echo htmlspecialchars($company['email']); ?>" required>
                    <label for="email">Email</label>
                </div>

                <!-- Address -->
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-map-marker"></i></span>
                    <input type="text" class="input" name="address" value="<?php echo htmlspecialchars($company['c_add']); ?>" required>
                    <label for="address">Company Address</label>
                </div>

                <!-- Company Logo -->
                <div class="logo-box">
                    <label for="logo" class="logo-label">Company Logo</label>
                    <span class="icon"><i class="fa-solid fa-upload"></i></span>
                    <input type="file" class="input" name="logo" accept="image/*">
                    <?php if (!empty($company['c_logo'])): ?>
                        <div>
                            <img src="uploads/<?php echo $company['c_logo']; ?>" alt="Company Logo" class="img-fluid mt-3" style="max-width: 150px;">
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Company Description -->
                <div class="description-box">
                    <label for="description" class="description-label">Company Description</label>
                    <span class="icon"><i class="fa-solid fa-align-left"></i></span>
                    <textarea class="input" name="description" required><?php echo htmlspecialchars($company['c_detail']); ?></textarea>
                </div>

                <!-- Submit Button -->
                <div class="submit">
                    <button type="submit" name="save" class="btn1">Save Changes</button>
                </div>

                <div class="login-register">
                    <p>Don't want to update? <a href="company-dashboard.php" class="login-link">Cancel</a></p>
                </div>
            </form>
        </div>
    </div>
    <br><br><br><br><br>

    <script>
    // Function to toggle password visibility (if needed for future features)
    function togglePasswordVisibility(inputField, iconClass) {
        var passwordInput = document.getElementById(inputField);
        var eyeIcon = document.querySelector("." + iconClass);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
    </script>

<?php include('../common/footer.php') ?>
</body>
</html>
