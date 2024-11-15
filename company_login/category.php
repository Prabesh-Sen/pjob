<?php
session_start(); // Start the session

// Check if the company is signed in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // The company is signed in
    $companyname = $_SESSION['companyname'];
    $email = $_SESSION['email'];
    
    // Continue with the desired code for a signed-in company
    // For example, display the company's dashboard or perform authorized actions
    
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

// Retrieve the user's email from the database based on the username
// Assuming you have a database connection established

// Perform a database query to fetch the user's email
// Replace 'users' with the actual table name and 'u_name' with the actual column name storing the username
$query = "SELECT email, c_id FROM company WHERE c_name = '$username'";

$result = mysqli_query($connection, $query);

// Check if the query was successful and retrieve the email value
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['email'];
    $companyid = $row['c_id'];

    // Set the username and email session variables
    $_SESSION['id']=$companyid;
    $_SESSION['c_name'] = $username;
    $_SESSION['email'] = $email;

}
?>
<!DOCTYPE html>
<html lang="en">

<?php include( 'common/head.php') ?>


<body>
<?php include( 'common/nav.php') ?>



        <!-- Header End -->
        <div class="container-fluid py-5 bg-dark page-header mb-5">
            <div class="container my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Category</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-uppercase">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item text-white active" aria-current="page">Category</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Header End -->


        <?php include( '../common/allcategory.php') ?>


        <?php include( '../common/footer.php') ?>
