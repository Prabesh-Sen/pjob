<!DOCTYPE html>
<html lang="en">

<?php include( 'common/head.php') ?>

<body>
    <?php include( 'common/navbar.php') ?>

        <!-- sign in box. -->
        <br>
        <div class="reg-box">
        <div class="form-box register">
        <form method="post" action="connect.php" enctype="multipart/form-data">

                
                <h2 style="color: #00B074;">Sign Up </h2>   
                <div class="input-box">
                    <span class="icon"><i class="fa-solid fa-user"></i></span>                
                    <input type="text" class="input" name="username"  required> 
                    <label for="username">Username</label>               
                </div>
                <div class="input-box">
                    <span class="icon"><i class="fa-regular fa-envelope"></i></span>                
                    <input type="email" class="input" name="email" required> 
                    <label for="email">email</label>              
                </div>
                <div class="input-box"> 
    <span class="icon"> <i class="fa-solid fa-lock"></i></span>            
    <input type="password" class="input" id="password" name="password" required>
    <label for="password">Password</label> 
    <span class="toggle-password" style="color: gray;" onclick="togglePasswordVisibility('password', 'eye-icon1')"><i class="fa-solid fa-eye" id="eye-icon1"></i></span>
</div>

<div class="input-box"> 
    <span class="icon"> <i class="fa-solid fa-lock"></i></span>            
    <input type="password" class="input" id="cpassword" name="cpassword" required>
    <label for="contact no.">Confirm Password</label> 
    <span class="toggle-password" style="color: gray;" onclick="togglePasswordVisibility('cpassword', 'eye-icon2')"><i class="fa-solid fa-eye" id="eye-icon2"></i></span>
</div>

                    <div class="logo-box">
                        <label for="logo" class="logo-label">Profile Photo</label>   
                        <span class="icon"><i class="fa-solid fa-upload"></i></span>
                        <input type="file" class="input" name="logo" accept="image/*" required>
                        
                    </div>
           
                <div class="submit">
                    <button type="submit" name="save" class="btn1">Signup</button>
                </div>
                <div class="login-register">
                    <p>Already have an account? <a href="signin.html" class="login-link">Sign in</a></p>
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


        
<?php include( 'common/footer.php') ?>