<?php
// Assuming the database connection is already set up
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get search parameters from the AJAX request
$keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
$category = mysqli_real_escape_string($conn, $_GET['category']);
$location = mysqli_real_escape_string($conn, $_GET['location']);

// Construct the query based on the search parameters
$query = "SELECT * FROM jobs WHERE 1";

if (!empty($keyword)) {
    $query .= " AND j_title LIKE '%$keyword%'";
}
if (!empty($category)) {
    $query .= " AND j_category = '$category'";
}
if (!empty($location)) {
    $query .= " AND j_address = '$location'";
}

// Execute the query
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    // Return search results (this could be more complex HTML)
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Job Title: " . $row['j_title'] . "<br>";
        echo "Category: " . $row['j_category'] . "<br>";
        echo "Location: " . $row['j_address'] . "<br><br>";
    }
} else {
    echo "No jobs found.";
}

// Close the database connection
mysqli_close($conn);
?>
