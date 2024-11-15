<form action="searchedjob.php" method="get">
    <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Single Search Bar -->
                <div class="col-md-8 d-flex">
                    <input type="text" class="form-control border-0 rounded-start" placeholder="Search for jobs, category, or location" name="keyword" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>" />
                    <button class="btn btn-dark border-0 rounded-end" type="submit" style="padding: 5px 15px;">Search</button>
                </div>
            </div>
        </div>
    </div>
</form>