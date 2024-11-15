<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $userPassword = $_POST["password"];

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

    // Prepare and execute the SQL query
    $sql = "SELECT u_id, password, email FROM users WHERE u_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();


    if ($result->num_rows > 0) {
        // User exists in the database

        // Password checking logic
        $row = $result->fetch_assoc();
        $storedPassword = $row["password"];
        $storedEmail = $row["email"];
        $storedId = $row["u_id"];

        if ($userPassword === $storedPassword) {
            // Password matches, login successful

            // Store user information in session variables
            $_SESSION["u_id"] = $storedId;
            $_SESSION["u_name"] = $user;
            $_SESSION["email"] = $storedEmail;
            $_SESSION["loggedin"] = true;

            // Redirect to the user's dashboard or protected area
            header('Location: user_login/index.php');
            exit();
        } else {
            // Password does not match
            $error_message = "Incorrect password";
            
        }
    } else {
        // User does not exist
        $error_message = "User does not exist";
        
    }
    $stmt->close();
    // Close the database connection
    $conn->close();
}
?>

<?php include( 'common/head.php') ?>

<body>
    <?php include( 'common/navbar.php') ?>


        <!-- sign in box. -->
        
           <br> <br>
        <div class="reg-box">
        <div class="form-box login">
            <form action="signinusr.php" method="post">
                <h2 style="color: #00B074;"> User <br>Sign in</h2>
                <?php if (isset($error_message)) { ?>
                    <p class="error" script=color:red; ><?php echo $error_message; ?></p>
                <?php } ?>
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-user"></i></span>
                    <input type="text" class="input" name="username" required>
                    <label for="username">Username</label>
                </div>
                <div class="input-box">
                <span class="icon"><i class="fa-solid fa-lock"></i></span>
                 <input type="password" class="input" name="password" id="password" required>
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