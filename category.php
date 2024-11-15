<?php include( 'common/head.php') ?>


<body>
    <div class="container-xxl bg-white p-0">
    <?php include( 'common/navbar.php') ?>



        <!-- Header End -->
        <div class="container-xxl py-5 bg-dark page-header mb-5">
            <div class="container my-5 pt-5 pb-4">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Category</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-uppercase">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        
                        <li class="breadcrumb-item text-white active" aria-current="page">Category</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Header End -->


        <?php include( 'common/allcategory.php') ?>
       
        <?php include( 'common/footer.php') ?>