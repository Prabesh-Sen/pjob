<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['u_id'])) {
    header("Location: signin.php");
    exit;
}

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a connection to the database
$db = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

$u_id = $_SESSION['u_id']; // Get the user ID from the session

// Fetch the current user data from the database
$query = "SELECT * FROM users WHERE u_id = '$u_id'";
$result = mysqli_query($db, $query);

if (!$result) {
    die("Error fetching user data: " . mysqli_error($db));
}

$user = mysqli_fetch_assoc($result);

// Handle form submission to update profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize it
    $username = isset($_POST['u_name']) ? mysqli_real_escape_string($db, $_POST['u_name']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($db, $_POST['email']) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($db, $_POST['address']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $cpassword = isset($_POST['cpassword']) ? $_POST['cpassword'] : '';

    // Check if passwords match
    if ($password && $password !== $cpassword) {
        $error = "Passwords do not match!";
    }

    // If passwords are provided and match, hash the password
    if (empty($error) && $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $updatePassword = ", password = '$password'";
    } else {
        $updatePassword = '';
    }

    // Handle file upload (profile photo)
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
        $logo = $_FILES['logo']['name'];
        $logoTmpName = $_FILES['logo']['tmp_name'];
        $logoPath = "../uploads/" . basename($logo);

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($logoTmpName, $logoPath)) {
            $updateLogo = ", u_image = '$logo'";
        }
    } else {
        $updateLogo = '';
    }

    // If no errors, update the user data in the database
    if (empty($error)) {
        $query = "UPDATE users SET u_name = '$username', email = '$email', address = '$address' $updatePassword $updateLogo WHERE u_id = '$u_id'";
        
        if (mysqli_query($db, $query)) {
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: update-profile.php?status=success");
            exit;
        } else {
            $_SESSION['error'] = "Error updating profile: " . mysqli_error($db);
        }
    }
}

// Close the database connection
mysqli_close($db);

// List of cities in Nepal for the address dropdown
$nepalCities = [
    "Kathmandu", "Pokhara", "Lalitpur", "Bhaktapur", "Biratnagar", 
    "Nepalgunj", "Birganj", "Dharan", "Janakpur", "Butwal",
    "Hetauda", "Rajbiraj", "Itahari", "Banepa", "Khandbari",
    "Bhairahawa", "Dhangadhi", "Mahendranagar", "Dang", "Rupandehi"
];
?>

<!DOCTYPE html>
<html lang="en">
<?php include('common/head.php') ?>

<body>
    <?php include('common/nav.php') ?>

    <br>
    <div class="reg-box">
        <div class="form-box register">
            <form method="post" action="update-profile.php" enctype="multipart/form-data">

                <h2 style="color: #00B074;">Update Profile</h2>   

                <!-- Display Success or Error Message -->
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success" id="successMessage">
                        <?php echo $_SESSION['success']; ?>
                        <button id="okBtn" class="btn btn-success">OK</button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger" id="errorMessage">
                        <?php echo $_SESSION['error']; ?>
                        <button id="okBtnError" class="btn btn-danger">OK</button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Username Field -->
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-user"></i></span>                
                    <input type="text" class="input" name="u_name" value="<?php echo isset($user['u_name']) ? htmlspecialchars($user['u_name']) : ''; ?>" required> 
                    <label for="u_name">Username</label>               
                </div>

                <!-- Email Field -->
                <div class="input-box">
                    <span class="icon"><i class="fa-regular fa-envelope"></i></span>                
                    <input type="email" class="input" name="email" value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" required> 
                    <label for="email">Email</label>              
                </div>

                <!-- Address Dropdown (Nepal cities) -->
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-map-marker-alt"></i></span>
                    <select class="input" name="address" required>
                        <option value="">Select Address</option>
                        <?php foreach ($nepalCities as $city): ?>
                            <option value="<?php echo $city; ?>" <?php echo ($user['address'] == $city) ? 'selected' : ''; ?>>
                                <?php echo $city; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Profile Photo Field -->
                <div class="logo-box">
                    <label for="logo" class="logo-label">Profile Photo</label>   
                    <span class="icon"><i class="fa-solid fa-upload"></i></span>
                    <input type="file" class="input" name="logo" accept="image/*">
                    <!-- Display current profile photo -->
                    <?php if (isset($user['u_image']) && $user['u_image']): ?>
                        <div class="current-logo">
                            <img src="../uploads/<?php echo htmlspecialchars($user['u_image']); ?>" alt="Profile Photo" width="100">
                        </div>
                    <?php endif; ?>
                </div>

                <div class="submit">
                    <button type="submit" name="update" class="btn1">Update Profile</button>
                </div>

            </form>
        </div>          
    </div>

    <script>
        // Success Button Click Event
        document.getElementById('okBtn')?.addEventListener('click', function() {
            window.location.href = 'index.php';  // Redirect to the index page
        });

        // Error Button Click Event
        document.getElementById('okBtnError')?.addEventListener('click', function() {
            document.getElementById('errorMessage').style.display = 'none';  // Hide the error message
        });
    </script>

    <?php include('common/footer.php') ?>

</body>
</html>
