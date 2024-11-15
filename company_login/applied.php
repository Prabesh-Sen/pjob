<?php
session_start(); // Start the session

// Check if the company is signed in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // The company is signed in
    $companyname = $_SESSION['companyname'];
    $email = $_SESSION['email'];

    // Continue with the desired code for a signed-in company
    // For example, display the company's dashboard or perform authorized actions
    $message = "Welcome, $companyname! You are signed in.";
    echo "<script>alert('$message');</script>";
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

// After successful user login
$username = "c_name"; // 

$query = "SELECT email, c_id FROM company WHERE c_name = '$username'";

$result = mysqli_query($connection, $query);

// Check if the query was successful and retrieve the email value
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $companyid = $row['c_id'];

    // Set the username and email session variables
    $_SESSION['id'] = $companyid;
    $_SESSION['c_name'] = $username;
    $_SESSION['email'] = $email;

}

$query= "SELECT * FROM `category`";
$res = mysqli_query($connection,$query);

?>
<?php
// Database credentials
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'login';

// Create a connection
$con = mysqli_connect($hostname, $username, $password, $database);

// Check if the connection was successful
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Perform database operations here...
$sql = "SELECT * FROM `jobs`";
$sql = "SELECT j.*, c.c_logo FROM jobs j
                              INNER JOIN company c ON j.c_id = c.c_id";
$result1 = mysqli_query($con, $sql);
$query= "SELECT * FROM `category`";
$res = mysqli_query($con,$query);

// Close the connection

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PINJOB-detail</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/sty.css" rel="stylesheet">
    
<script>
    const urlParams = new URLSearchParams(window.location.search);
    const jobId = urlParams.get('j_id');

    // Now you can use the jobId for further processing or displaying job details
</script>

<script>
        function showContent() {
            let content = document.getElementById("contentShowing");
            if (content.style.display === "none") {
                content.style.display = "block";
            } else {
                content.style.display = "none";
            }
        }
    </script>
    <style>
        #userIcon svg {
            height: 40px;
            width: 40px;
            padding: 5px;
            background-color: #00B074;
            fill: white;
            border-radius: 50%;
            cursor: pointer;
        }

        #contentShowing {
            position: absolute;
            content: "";
            top: 70px;
            right: 23px;
            min-height: 110px;
            width: 200px;
            color: black;
            text-align: left;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            padding: 10px 15px;
            border-radius: 2px;
            box-shadow: 0px 1px 2px 1px rgba(0, 0, 1, 0.8);
            background-color: #EFFDF5;
            line-height: 20px;
            letter-spacing: 1px;
            font-family: Arial;
            font-weight: 400;
        }

        #name {
            font-size: 14px;
            text-transform: capitalize;
        }

        #head {
            font-weight: 400;
            font-size: 13px;
            color: rgba(0, 0, 0, 0.7);
        }

        #logout-btn {
            border: none;
            padding: 5px 8px;
            font-size: 14px;
            font-weight: 600;
            background-color: #00B074;
            width: 100%;
            margin-top: 5px;
            cursor: pointer;
            border-radius: 2px;
            transition: 0.2s;
            letter-spacing: 1px;
        }

        #logout-btn:hover,
        #showContentButton:hover {
            background-color: #00B074;
            color: white;
        }

        #goHomeDiv {
            width: 100%;
            max-height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 5px;
            cursor: pointer;
            transition: 0.2s;
            border-radius: 2px;
            border: 2px solid rgba(144, 132, 214, 1);
            ;
        }

        #goIndex-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            gap: 5px;
            font-family: arial;
            font-size: 14px;
            color: black;
            font-weight: 600;
            transition: 0.2s;
        }

        #goHomeDiv:hover,
        #goIndex-btn:hover {
            color: white;
            background-color: rgba(144, 132, 214, 1);
        }
    </style>
</head>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->


        <!-- Navbar Start -->
        <nav class='navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0'>
            <a href='index.html' class='navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5'>
                <h1 class='m-0 text-primary'>PINJOB</h1>
            </a>
            <button type='button' class='navbar-toggler me-4' data-bs-toggle='collapse'
                data-bs-target='#navbarCollapse'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarCollapse'>
                <div class='navbar-nav ms-auto p-4 p-lg-0'>
                    <a href='index.php' class='nav-item nav-link'>Home</a>
                    <a href='about.php' class='nav-item nav-link'>About</a>
                    <div class='nav-item dropdown'>
                        <a href='#' class='nav-link dropdown-toggle' data-bs-toggle='dropdown'>Jobs</a>
                        <div class='dropdown-menu rounded-0 m-0'>
                            <a href='job-list.php' class='dropdown-item'>Job List</a>
                            <a href='job-detail.php' class='dropdown-item'>Applied job</a>
                        </div>
                    </div>
                    <div class='nav-item dropdown'>
                        <a href='#' class='nav-link dropdown-toggle' data-bs-toggle='dropdown'>Pages</a>
                        <div class='dropdown-menu rounded-0 m-0'>
                            <a href='category.php' class='dropdown-item'>Job Category</a>
                            <a href='add.php' class='dropdown-item'>Add Job</a>
                        </div>
                    </div>
                    <a href='contact.php' class='nav-item nav-link'>Contact</a>
                </div>
                <div id='userIcon' onclick='showContent()' style='margin-right:20px'>
                    <?php

                    $con = mysqli_connect("localhost", "root", "", "login");
                    if (!$con) {
                        die("Connection failed: " . mysqli_connect_error());
                    }

                    // Assuming you have already stored the company ID in $_SESSION['c_id']
                    if (isset($_SESSION['c_id'])) {
                        $companyId = $_SESSION['c_id'];

                        // Retrieve the company logo filename from the "company" table
                        $query = "SELECT c_logo FROM company WHERE c_id = $companyId";
                        $result = mysqli_query($con, $query);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $companyLogoFilename = $row['c_logo'];
                            $logoUrl = "img/" . $companyLogoFilename; // Assuming the logos are stored in the "uploads" folder
                    
                            // Display the company logo using an <img> tag
                            echo "<img src='$logoUrl' width='45' height='45 'border-radius: 50%; overflow: hidden; border: 2px solid black; 
            alt='Company Logo'>";
                        } else {
                            // Company logo not found or error occurred
                            // Display a default logo or an error message
                            echo "<svg width='45' height='45' viewBox='0 0 45 45' xmlns='http://www.w3.org/2000/svg'>
                    <path d='M22.5 7.5C24.4891 7.5 26.3968 8.29018 27.8033 9.6967C29.2098 11.1032 30 13.0109 30 15C30 16.9891 29.2098 18.8968 27.8033 20.3033C26.3968 21.7098 24.4891 22.5 22.5 22.5C20.5109 22.5 18.6032 21.7098 17.1967 20.3033C15.7902 18.8968 15 16.9891 15 15C15 13.0109 15.7902 11.1032 17.1967 9.6967C18.6032 8.29018 20.5109 7.5 22.5 7.5ZM22.5 26.25C30.7875 26.25 37.5 29.6062 37.5 33.75V37.5H7.5V33.75C7.5 29.6062 14.2125 26.25 22.5 26.25Z' />
                </svg>";
                        }
                    }

                    // Close the connection
                    
                    ?>
                </div>





                <div id="contentShowing" style="display:none">
                    <p id="name">
                        <?php echo isset($_SESSION['companyname']) ? "Company: " . $_SESSION['companyname'] : "Company: N/A"; ?>
                    </p>
                    <p>
                        <?php echo isset($_SESSION['email']) ? "Email: " . $_SESSION['email'] : "Email: N/A"; ?>
                    </p>
                    <p>
                        <?php echo isset($_SESSION['c_id']) ? "Company ID: " . $_SESSION['c_id'] : "Company ID: N/A"; ?>
                    </p>
                    <p id="head">PINJOB</p>
                    <form action="logout.php" method="POST"
                        onsubmit="return confirm('Are you sure you want to log out?');">
                        <button id="logout-btn" name="logOutSubmit" type="submit">Log Out</button>
                    </form>

                </div>


            </div>
            </ul>
    </div>
    </div>
    </nav>
        <!-- Navbar End -->


        <!-- Header End -->
        <div class="container-xxl py-5 bg-dark page-header mb-5">
            <div class="container my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Job Applied</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-uppercase">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        
                        <li class="breadcrumb-item text-white active" aria-current="page">Job Applied</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Header End -->
        <?php
// // Database credentials
// $hostname = 'localhost';
// $username = 'root';
// $password = '';
// $database = 'login';

// // Create a connection
// $con = mysqli_connect($hostname, $username, $password, $database);

// // Check if the connection was successful
// if (mysqli_connect_errno()) {
//     die("Failed to connect to MySQL: " . mysqli_connect_error());
// }
$companyid = $_SESSION['c_id'];
// Perform database operations here...

// Fetch data from job_applications where the company_id matches the $companyId
$sql = "SELECT * FROM `job_applications` WHERE company_id = $companyid";
$result2 = mysqli_query($con, $sql);

// Check if the query was successful
if ($result2 && mysqli_num_rows($result2) > 0) {
    // Loop through the result1 to fetch each row
    while ($row = mysqli_fetch_assoc($result2)) {
        // Access the data from each row, for example:
        $applicantName = $row['a_name'];
        $jobid = $row['job_id'];
        // ... and so on for other columns you want to retrieve
        // Perform any other actions you need to do with the data
    }
} else {
    // No job applications found for this company ID
    // You can handle this situation based on your requirements
}

// Close the connection
mysqli_close($con);
?>
        <h2>Job Applications</h2>
    <table>
        <tr>
            <th>Applicant Name</th>
            <th>Job ID</th>
            <!-- Add more table headers for other columns if needed -->
        </tr>
        <?php
        // Your database connection and retrieval code here (already provided in your code)

        // Check if the query was successful
        if ($result2 && mysqli_num_rows($result2) > 0) {
            // Loop through the result to fetch each row
            while ($row = mysqli_fetch_assoc($result2)) {
                // Access the data from each row
                $applicantName = $row['a_name'];
                $jobid = $row['job_id'];

                // Output the data in a table row
                echo "<tr>";
                echo "<td>$applicantName</td>";
                echo "<td>$jobid</td>";
                // Add more table data cells for other columns if needed
                echo "</tr>";
            }
        } else {
            // No job applications found for this company ID
            // You can handle this situation based on your requirements
            echo "<tr><td colspan='2'>No job applications found.</td></tr>";
        }
        ?>
    </table>

        


        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Company</h5>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Quick Links</h5>
                        <a class="btn btn-link text-white-50" href="">About Us</a>
                        <a class="btn btn-link text-white-50" href="">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="">Our Services</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="text-white mb-4">Contact</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Kathmandu, Nepal</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+977 9876543210</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>pinjob123@gmail.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                   
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">PINJOB</a>, All Right Reserved. 
							
							
							Designed By <a class="border-bottom" href="#">Code By Pawan,Indira, Nischal</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="index.html">Home</a>
                                
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>