<?php
session_start(); // Start the session at the beginning of the script

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $companyname = $_POST["companyname"];
    $userPassword = $_POST["pass"];

    // Your database connection code here
    $servername = "localhost";
    $username = "root";
    $dbPassword = "";
    $dbname = "login";

    // Create a connection
    $conn = new mysqli($servername, $username, $dbPassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT c_id, password, email FROM company WHERE c_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $companyname);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Company exists in the database

        // Password checking logic
        $row = $result->fetch_assoc();
        $storedPassword = $row["password"];
        $storedEmail = $row["email"];
        $storedId = $row['c_id'];

        // Compare the passwords without hashing
        if ($userPassword === $storedPassword) {
            // Password matches, login successful

            // Store company information in session variables
            $_SESSION['c_id'] = $storedId;
            $_SESSION["companyname"] = $companyname;
            $_SESSION["email"] = $storedEmail;
            $_SESSION["loggedin"] = true;

            // Redirect to the company's dashboard or protected area
            header('Location: company_login/index.php');
            exit();
        } else {
            // Password does not match
            $error_message = "Incorrect password";
            echo "Error Message: " . $error_message;
        }
    } else {
        // Company does not exist
        $error_message = "Company does not exist";
        echo "Error Message: " . $error_message;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
        <?php include( 'common/head.php') ?>

<body>
    <?php include( 'common/navbar.php') ?>

        <!-- sign in box. -->
        
           <br><br>
    <div class="reg-box">
        <div class="form-box login">
            <form action="signincomp.php" method="post">
                <h2 style="color: #00B074;">Company <br>Sign in</h2>
                <?php if (isset($error_message)) { ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php } ?>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="input" name="companyname" required>
                    <label for="companyname">Company name</label>
                </div>
                <div class="input-box">
                <span class="icon"><i class="fa-solid fa-lock"></i></span>

                    <input type="password" class="input" name="pass" id="pass" required>
                    <label for="password">Password</label>
                    <span class="toggle-password" style=color:gray;  onclick="togglePasswordVisibility('password')"><i class="fa-solid fa-eye"></i></span>

                </div>
                <div class="submit">
                    <input type="submit" class="btn1" value="Sign in" name="login_submit">
                </div>
                <div class="login-register">
                    <p>Don't have an account? <a href="signup.html" class="register-link">Sign up</a></p>
                </div>
            </form>
        </div>
    </div>

            <!-- Sign in box. -->
            <script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var eyeIcon = document.querySelector(".eye-icon i");

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

<?php include( 'common/footer.php') ?>