<?php
function isPageActive($pageUrl) {
    $currentPagePath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return ($currentPagePath == $pageUrl);
}
?>
<div class="container-fluid bg-white p-0">

  <!-- Spinner Start -->
  <!-- <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->
        <!-- Spinner End -->
<!-- Navbar Start -->
<?php
// Get the current page URLs
$currentPage = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <!-- Navbar Brand -->
    <a href="index.php" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
        <h1 class="m-0 text-primary">JOB PORTAL</h1>
    </a>

    <!-- Navbar Toggler -->
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Collapse -->
    <div class="collapse navbar-collapse" id="navbarCollapse">
    <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link <?php echo isPageActive('/company_login/index.php') ? 'active' : ''; ?>">Home</a>
                <a href="about.php" class="nav-item nav-link <?php echo isPageActive('/company_login/about.php') ? 'active' : ''; ?>">About</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?php echo isPageActive('/company_login/job-list.php') || isPageActive('/company_login/job-detail.php') ? 'active' : ''; ?>" data-bs-toggle="dropdown">Jobs</a>
                    <div class="dropdown-menu rounded-0 m-0">
                        <a href="job-list.php" class="dropdown-item <?php echo isPageActive('/company_login/job-list.php') ? 'active' : ''; ?>">Job List</a>
                    </div>
                </div>
                <a href="category.php" class="nav-item nav-link <?php echo isPageActive('/company_login/category.php') ? 'active' : ''; ?>">Category</a>
                
                <a href="contact.php" class="nav-item nav-link <?php echo isPageActive('/company_login/contact.php') ? 'active' : ''; ?>">Contact</a>
            </div>

        <!-- Sign-in Dropdown -->
        <div class="nav-item dropdown <?php echo (strpos($currentPage, '/signinusr.php') !== false || strpos($currentPage, '/signincomp.php') !== false ? 'active' : ''); ?>">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Sign in</a>
            <div class="dropdown-menu rounded-0 m-0">
                <a href="signinusr.php" class="dropdown-item <?php echo (strpos($currentPage, '/signinusr.php') !== false ? 'active' : ''); ?>">User</a>
                <a href="signincomp.php" class="dropdown-item <?php echo (strpos($currentPage, '/signincomp.php') !== false ? 'active' : ''); ?>">Company</a>
            </div>
        </div>

        <!-- Sign-up Dropdown -->
        <div class="nav-item dropdown <?php echo (strpos($currentPage, '/signupjs.php') !== false || strpos($currentPage, '/signupusr.php') !== false ? 'active' : ''); ?>">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Sign up</a>
            <div class="dropdown-menu rounded-0 m-0">
                <a href="signupjs.php" class="dropdown-item <?php echo (strpos($currentPage, '/signupjs.php') !== false ? 'active' : ''); ?>">User</a>
                <a href="signupusr.php" class="dropdown-item <?php echo (strpos($currentPage, '/signupusr.php') !== false ? 'active' : ''); ?>">Company</a>
            </div>
        </div>
    </div>
</nav>


        <!-- Navbar End -->