<div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
            <a href="index.html" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
                <h1 class="m-0 text-primary">JOB PORTAL</h1>
            </a>
            <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <div class="navbar-nav ms-auto p-4 p-lg-0">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="job-list.php" class="nav-item nav-link">Job List</a>
                    
                    <a href="category.php" class="nav-item nav-link">Category</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
                <div id="userIcon" onclick="showContent()" style="margin-right:20px">
                    <?php

                            $con = mysqli_connect("localhost", "root", "", "login");
                            if (!$con) {
                                die("Connection failed: " . mysqli_connect_error());
                            }

                            if (isset($_SESSION['u_id'])) {
                                $userid = $_SESSION['u_id'];


                                // Retrieve the company logo filename from the "users" table
                                $query = "SELECT u_image FROM users WHERE u_id = '$userid' " ;
                                $result = mysqli_query($con, $query);

                                if ($result && mysqli_num_rows($result) > 0) {
                                    $rows = mysqli_fetch_assoc($result);
                                    $Filename = $rows['u_image'];
                                    $logoUrl = "../uploads/" . $Filename; //  logos are stored in the "uploads" folder

                                    // Display the company logo using an <img> tag
                                    echo "<img src='$logoUrl' width='45' height='45' style='border-radius: 50%; overflow: hidden; border: 2px solid black;' alt='Company Logo'>";

                                } else {
                                    // Company logo not found or error occurred
                                    // Display a default logo or an error message
                            //         echo "<svg width='45' height='45' viewBox='0 0 45 45' xmlns='http://www.w3.org/2000/svg'>
                            // <path d='M22.5 7.5C24.4891 7.5 26.3968 8.29018 27.8033 9.6967C29.2098 11.1032 30 13.0109 30 15C30 16.9891 29.2098 18.8968 27.8033 20.3033C26.3968 21.7098 24.4891 22.5 22.5 22.5C20.5109 22.5 18.6032 21.7098 17.1967 20.3033C15.7902 18.8968 15 16.9891 15 15C15 13.0109 15.7902 11.1032 17.1967 9.6967C18.6032 8.29018 20.5109 7.5 22.5 7.5ZM22.5 26.25C30.7875 26.25 37.5 29.6062 37.5 33.75V37.5H7.5V33.75C7.5 29.6062 14.2125 26.25 22.5 26.25Z' />
                            // </svg>";
                                }

                            }
                            // Close the connection
                            mysqli_close($con);
                    ?>
                </div>
                        <div id="contentShowing" style="display:none">
                            <p id="name">
                                <?php echo isset($_SESSION["u_name"]) ? '<i class="far fa-user" style="color: #00B074;"></i>   ' . $_SESSION['u_name'] : '<i class="far fa-user" style="color: #00B074;"></i> User: N/A'; ?>
                            </p>
                            <p>
                                <?php echo isset($_SESSION['email']) ? '<i class="far fa-envelope" style="color: #00B074;"></i>   ' . $_SESSION['email'] : '<i class="far fa-envelope" style="color: #00B074;"></i> Email: N/A'; ?>
                            </p>
                            <p>
                                <?php echo isset($_SESSION['u_id']) ? '<i class="far fa-id-card" style="color: #00B074;"></i>   ' . $_SESSION['u_id'] : '<i class="far fa-id-card" style="color: #00B074;"></i> User ID: N/A'; ?>
                            </p>
                            <p id="jobs">
                            <a href="appliedjobs.php?u_id=<?php echo isset($_SESSION['u_id']) ? $_SESSION['u_id'] : ''; ?>">Applied Jobs</a>
                            </p>
                             <!-- Update Profile Button -->
                             <p id="update-profile">
        <a href="update-profile.php?u_id=<?php echo isset($_SESSION['u_id']) ? $_SESSION['u_id'] : ''; ?>" >Update Profile</a>
    </p>


                            
                            <form action="logout.php" method="POST"onsubmit="return confirm('Are you sure you want to log out?');">
                                <button id="logout-btn" name="logOutSubmit" type="submit">Log Out</button>
                            </form>
                        </div>


            </div>
                    
                
            
        </nav>
    </div>
        <!-- Navbar End -->
