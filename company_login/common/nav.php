<div class="container-xxl bg-white p-0">
    <!-- Spinner Start -->
    <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
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
                <a href="index.php" class="nav-item nav-link <?php echo isPageActive('index.php') ? 'active' : ''; ?>">Home</a>
                <a href="about.php" class="nav-item nav-link <?php echo isPageActive('/about.php') ? 'active' : ''; ?>">About</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?php echo isPageActive('/job-list.php') || isPageActive('/company_login/job-detail.php') ? 'active' : ''; ?>" data-bs-toggle="dropdown">Jobs</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="job-list.php" class="dropdown-item <?php echo isPageActive('/company_login/job-list.php') ? 'active' : ''; ?>">Job List</a>
                    </div>
                </div>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?php echo isPageActive('/company_login/category.php') || isPageActive('/company_login/add.php') ? 'active' : ''; ?>" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="category.php" class="dropdown-item <?php echo isPageActive('/company_login/category.php') ? 'active' : ''; ?>">Job Category</a>
                        <a href="add.php" class="dropdown-item <?php echo isPageActive('/company_login/add.php') ? 'active' : ''; ?>">Add Job</a>
                    </div>
                </div>
                <a href="contact.php" class="nav-item nav-link <?php echo isPageActive('/company_login/contact.php') ? 'active' : ''; ?>">Contact</a>
            </div>
            <div id="userIcon" onclick="showContent()" style="margin-right: 20px">
                <?php
                $con = mysqli_connect("localhost", "root", "", "login");
                if (!$con) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                if (isset($_SESSION['c_id'])) {
                    $companyId = $_SESSION['c_id'];
                    $query = "SELECT c_logo FROM company WHERE c_id = $companyId";
                    $result = mysqli_query($con, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $companyLogoFilename = $row['c_logo'];
                        $logoUrl = "../uploads/" . $companyLogoFilename;
                        echo "<img src='$logoUrl' width='45' height='45' style='border-radius: 50%; overflow: hidden; border: 2px solid black;' alt='Company Logo'>";
                    } else {
                        echo "<svg width='45' height='45' viewBox='0 0 45 45' xmlns='http://www.w3.org/2000/svg'>
                            <path d='M22.5 7.5C24.4891 7.5 26.3968 8.29018 27.8033 9.6967C29.2098 11.1032 30 13.0109 30 15C30 16.9891 29.2098 18.8968 27.8033 20.3033C26.3968 21.7098 24.4891 22.5 22.5 22.5C20.5109 22.5 18.6032 21.7098 17.1967 20.3033C15.7902 18.8968 15 16.9891 15 15C15 13.0109 15.7902 11.1032 17.1967 9.6967C18.6032 8.29018 20.5109 7.5 22.5 7.5ZM22.5 26.25C30.7875 26.25 37.5 29.6062 37.5 33.75V37.5H7.5V33.75C7.5 29.6062 14.2125 26.25 22.5 26.25Z' />
                        </svg>";
                    }
                }

                mysqli_close($con);
                ?>
            </div>

            <div id="contentShowing" style="display: none;">
                <p id="name">
                    <?php
                    echo isset($_SESSION['companyname']) ? '<i class="fas fa-building" style="color: #00B074;"></i> ' . $_SESSION['companyname'] : '<i class="fas fa-building" style="color: #00B074;"></i> Company: N/A';
                    ?>
                </p>
                <p>
                    <?php
                    echo isset($_SESSION['email']) ? '<i class="fas fa-envelope" style="color: #00B074;"></i> ' . $_SESSION['email'] : '<i class="fas fa-envelope" style="color: #00B074;"></i> Email: N/A';
                    ?>
                </p>
                <p>
                    <?php
                    echo isset($_SESSION['c_id']) ? '<i class="far fa-id-badge" style="color: #00B074;"></i> ' . $_SESSION['c_id'] : '<i class="far fa-id-badge" style="color: #00B074;"></i> Company ID: N/A';
                    ?>
                </p>
                <p id="jobs">
                    <a href="job-list.php?c_id=<?php echo isset($_SESSION['c_id']) ? $_SESSION['c_id'] : ''; ?>">My Jobs</a>
                    

                </p>
                <p id="jobs">
                    <a href="edit-profile.php?c_id=<?php echo isset($_SESSION['c_id']) ? $_SESSION['c_id'] : ''; ?>">Edit Profile</a>
                    

                </p>
                <p id="jobs">

                <a href="application.php?c_id=<?php echo isset($_SESSION['c_id']) ? $_SESSION['c_id'] : ''; ?>">Job Applications</a>
            </p>
                <p id="head">PINJOB</p>
                <form action="logout.php" method="POST" onsubmit="return confirm('Are you sure you want to log out?');">
                    <button id="logout-btn" name="logOutSubmit" type="submit">Log Out</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
</div>

<?php
function isPageActive($pageUrl) {
    return ($_SERVER['PHP_SELF'] == $pageUrl);
}
?>
