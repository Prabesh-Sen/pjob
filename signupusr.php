<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $companyname = $_POST['username'];
    $email = $_POST['email'];
    $userPassword = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $address = $_POST['address'];
    $detail = $_POST['description'];

    // Check if the password and confirm password match
    if ($userPassword !== $cpassword) {
        echo "Error: Password and confirm password do not match.";
        exit;
    }

    // Get the current date and time
    $currentDate = date('Y-m-d H:i:s');

    // Database connection
    $servername = "localhost";
    $username = "root";
    $dbPassword = "";
    $dbname = "login";

    // Create a database connection
    $conn = new mysqli($servername, $username, $dbPassword, $dbname);

    // Check the database connection
    if ($conn->connect_error) {
        die("Failed to connect: " . $conn->connect_error);
    }
     // File upload handling
     $logoName = $_FILES['logo']['name'];
     $logoTmpName = $_FILES['logo']['tmp_name'];
     $logoError = $_FILES['logo']['error'];
 
     // Move uploaded file to desired directory
     $logoDestination = 'uploads/' . $logoName;
     move_uploaded_file($logoTmpName, $logoDestination);
 

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO company (c_name, email, password, c_add, c_logo, added_date, c_detail) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $companyname, $email, $userPassword, $address, $logoName, $currentDate, $detail);
    $stmt->execute();
    if ($stmt->affected_rows > 0) {
        $_SESSION['status']="Company signed up successfully";
        $_SESSION['status_code']="success";
        header("Location: signincomp.php");
        exit;
    } else {
        $_SESSION['status']="Company not signed up successfully";
        $_SESSION['status_code']="error";

    }

    $stmt->close();
    $conn->close();
}
?>


        <?php include( 'common/head.php') ?>

<body>
    <?php include('common/navbar.php') ?>


        <!-- sign in box. -->
        <br>
        <div class="reg-box">
            <div class="form-box register">
                <form method="POST" action="signupusr.php" enctype="multipart/form-data" onsubmit="return checkPasswords()" >
                    <h2 style="color: #00B074;">Sign Up</h2>


                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" class="input" name="username" required>
                        <label for="username">Company name</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class="fa-regular fa-envelope"></i></span>
                        <input type="email" class="input" name="email" required>
                        <label for="email">Email</label>
                    </div>
                    <div class="input-box"> 
    <span class="icon"> <i class="fa-solid fa-lock"></i></span>            
    <input type="password" class="input" id="password" name="password" required>
    <label for="password">Password</label> 
    <span class="toggle-password" style="color: gray;" onclick="togglePasswordVisibility('password', 'eye-icon1')"><i class="fa-solid fa-eye eye-icon1"></i></span>
</div>

<div class="input-box"> 
    <span class="icon"> <i class="fa-solid fa-lock"></i></span>            
    <input type="password" class="input" id="cpassword" name="cpassword" required>
    <label for="contact no.">Confirm Password</label> 
    <span class="toggle-password" style="color: gray;" onclick="togglePasswordVisibility('cpassword', 'eye-icon2')"><i class="fa-solid fa-eye eye-icon2"></i></span>
</div>

                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-map-marker"></i></span>
                        <input type="text" class="input" name="address" required>
                        <label for="address">Company Address</label>
                    </div>
                    <div class="logo-box">
                        <label for="logo" class="logo-label">Company Logo</label>   
                        <span class="icon"><i class="fa-solid fa-upload"></i></span>
                        <input type="file" class="input" name="logo" accept="image/*" required>
                        
                    </div>
                    <div class="description-box">
                        <label for="description" class="description-label">Company Description</label>
                        <span class="icon"><i class="fa-solid fa-align-left"></i></span>
                        <textarea class="input" name="description" required></textarea>
                        
                    </div>
                    <div class="submit">
                        <button type="submit" name="save" class="btn1">Signup</button>
                    </div>
                    <div class="login-register">
                        <p>Already have an account? <a href="signincomp.php" class="login-link">Sign in</a></p>
                    </div>
                    </form>

                </div>            
        </div> 
           

            <!-- Sign in box. -->
            <script>
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
        
        
      

    <script>
  function togglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.querySelector(".toggle-password i");

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

<script>
    function checkPasswords() {
        var password = document.getElementById("password").value;
        var cpassword = document.getElementById("cpassword").value;

        if (password !== cpassword) {
            alert("Password and confirm password do not match.");
            return false;
        }

        return true;
    }
</script>

    
<?php include( 'common/footer.php') ?>