<?php

include "../common/backendConnector.php";
// db connection in login db
$con = mysqli_connect($host, $dbUserName, $dbPassword, $database);
if (!$con) {
    die("DB connection failed");
}

// for get category content from db
$sqlFetchCat = "SELECT DISTINCT cname FROM `category`";
$resFetchsub = mysqli_query($con, $sqlFetchCat);


if (isset($_GET['search'])) {
    $search = isset($_GET['search']) ? $_GET['search'] : '';
    // Escape the search value to prevent SQL injection
    $search = mysqli_real_escape_string($con, $search);

    // Check if the search value is set
    if (!empty($search)) {
        // Query with the search value
        $sqlFetch = "SELECT * FROM jobs WHERE j_title LIKE '%$search%'";
        $resFetch = mysqli_query($con, $sqlFetch);
    }
}





// ============= Insertion Start ============

if (isset($_POST['addContent'])) {

    // Define the directory to store uploaded images
    $targetDir = "uploads/";

    // Check if the target directory exists, if not, create it
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Check if a file was uploaded
    if (isset($_FILES["j_image"])) {
        $file = $_FILES["j_image"];

        // Get the file name and extension
        $fileName = basename($file["name"]);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Check if the file extension is allowed
        $allowedExtensions = array("jpg", "jpeg", "png");
        if (in_array($fileExtension, $allowedExtensions)) {
            $targetPath = $targetDir . uniqid() . "." . $fileExtension;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($file["tmp_name"], $targetPath)) {
                // File uploaded successfully

                // Get other form field values
                $title = $_POST['j_title'];
                $category = $_POST['j_category'];
                $address = $_POST['j_address'];
                $min_salary = $_POST['min_sal'];
                $max_salary = $_POST['max_salary'];
                $job_nature = $_POST['j_nature'];
                $job_description = $_POST['j_description'];
                $job_qualification = $_POST['j_qualification'];
                $job_responsibility = $_POST['j_responsibility'];
                $date=$_POST['date_added'];
                $img=$_POST['j_image'];
            


                // Fetch category name from category table
                if (mysqli_num_rows($resFetchsub) > 0) {
                    $res = mysqli_fetch_assoc($resFetchsub);
                    $categoryName = $res['cname'];
                }

                

                $final_image_path = $fileFront . $targetPath;

                // Insert data into the books table
                $sql = "INSERT INTO jobs (j_title, j_category, j_address, min_sal, max_salary, j_nature, j_description, j_qualification, j_responsibility, date_added) VALUES ('$title', '$category', '$address', '$min_salary', '$max_salary', '$job_nature', '$job_description', '$job_qualification', '$job_responsibility', '$date','$img')";

                if (mysqli_query($con, $sql)) {
                    // Data inserted successfully
                    header("Location: " . $_SERVER['PHP_SELF']);
                } else {
                    // Error inserting data
                    echo "Error: " . mysqli_error($con);
                }

                // Close the database connection
                mysqli_close($con);
            } else {
                // Failed to move the uploaded file
                echo "Error uploading image.";
            }
        } else {
            // Invalid file type
            echo "Only JPG, JPEG, and PNG files are allowed.";
        }
    } else {
        // No file uploaded
        echo "No image file provided.";
    }
}



// for delete content
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sqlDel = "DELETE FROM `jobs` WHERE `j_id`='$id'";

    if (mysqli_query($con, $sqlDel)) {
        echo "del success";
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo "Cannot Delete";
    }
}



// // for edit logic

$editId = 0;
$jid = "";
$title = "";
$category = "";
$address = "";
$min_salary = "";
$max_salary = "";
$job_nature = "";
$job_qualification = "";
$job_responsibility = "";
$date="";
$img="";

if (isset($_GET['edit'])) {
    $editId = $_GET['edit'];
    $editsql = "SELECT * FROM `jobs` WHERE `j_id` = ?";
    $stmt = mysqli_prepare($con, $editsql);
    mysqli_stmt_bind_param($stmt, "i", $editId);
    mysqli_stmt_execute($stmt);
    $editres = mysqli_stmt_get_result($stmt);

    if (!$editres) {
        echo "Job not found";
    } else {
        $job = mysqli_fetch_array($editres);
        $jid = $job['j_id'];
         $title = $job['j_title'];
        $category = $job['j_category'];
        $address = $job['j_address'];
        $min_salary = $job['min_salary'];
        $max_salary = $job['maximum_salary'];
        $job_nature = $job['j_nature'];
        $job_description = $job['j_description'];
        $job_qualification = $job['j_qualification'];
        $job_responsibility = $job['j_responsibility'];
        $date=$job['date_added'];
        $img=$job['j_image'];
    }
}

// Update the data in the database
// if (isset($_POST['updateContent'])) {
//     $newtitle = $_POST['j_title'];
//     $newcategory = $_POST['j_category'];
//     $newaddress = $_POST['j_address'];
//     $newmin_salary = $_POST['min_salary'];
//     $newmax_salary = $_POST['maximum_salary'];
//     $newjob_nature = $_POST['j_nature'];
//     $newjob_description = $_POST['j_description'];
//     $newjob_qualification = $_POST['j_qualification'];
//     $newjob_responsibility = $_POST['j_responsibility'];
//     $newdate=$_POST['date_added'];
//     $newimg=$_POST['j_image'];

//     $updatesql = "UPDATE `jobs` SET `j_title`=?, `j_category`=?, `j_address`=?, `min_salary`=?, `maximum_salary`=?, `j_nature`=?, `j_description`=?, `j_qualification`=?, `j_responsibility`=?, `date_added`=? , `j_image`=? WHERE `j_id`=?";
//     $stmt = mysqli_prepare($con, $updatesql);
//     mysqli_stmt_bind_param($stmt, "sssiisi", $newtitle, $newcategory, $newaddress, $newmin_salary, $newmax_salary, $newjob_nature,$newjob_description,$newjob_qualification,$newjob_responsibility,$newdate,$newimg, $editId);

//     if (mysqli_stmt_execute($stmt)) {
//         header("Location: " . $_SERVER['PHP_SELF']);
//         exit;
//     } else {
//         echo "Update failed: " . mysqli_stmt_error($stmt);
//     }

//     mysqli_stmt_close($stmt);
// }
if (isset($_POST['updateContent'])) {
    $newtitle = $_POST['j_title'];
    $newcategory = $_POST['j_category'];
    $newaddress = $_POST['j_address'];
    $newmin_salary = $_POST['min_salary'];
    $newmax_salary = $_POST['maximum_salary'];
    $newjob_nature = $_POST['j_nature'];
    $newjob_description = $_POST['j_description'];
    $newjob_qualification = $_POST['j_qualification'];
    $newjob_responsibility = $_POST['j_responsibility'];
    $newdate = $_POST['date_added'];
    $newimg = isset($_POST['j_image']) ? $_POST['j_image'] : '';


    $updatesql = "UPDATE `jobs` SET `j_title`=?, `j_category`=?, `j_address`=?, `min_salary`=?, `maximum_salary`=?, `j_nature`=?, `j_description`=?, `j_qualification`=?, `j_responsibility`=?, `date_added`=?, `j_image`=? WHERE `j_id`=?";
    $stmt = mysqli_prepare($con, $updatesql);
    mysqli_stmt_bind_param($stmt, "sssssssssssi", $newtitle, $newcategory, $newaddress, $newmin_salary, $newmax_salary, $newjob_nature, $newjob_description, $newjob_qualification, $newjob_responsibility, $newdate, $newimg, $editId);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Update failed: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
}



// $sqlFetchAll = "SELECT * FROM `books`";
// $res = mysqli_query($con, $sqlFetchAll);

// for searching
// Retrieve the search value from the GET request]
if (isset($_GET['search'])) {
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    // Escape the search value to prevent SQL injection
    $search = mysqli_real_escape_string($con, $search);

    // Check if the search value is set
    if (!empty($search)) {
        // Query with the search value
        $sqlNote = "SELECT * FROM jobs WHERE j_title LIKE '%$search%'";
        $res = mysqli_query($con, $sqlNote);
    }
}


// ================================ for pagination (start) ==========================================
$querytotalnumberROw = "SELECT COUNT(*) as total FROM jobs";
$resultRowNum = mysqli_query($con, $querytotalnumberROw);
$rowNumbers = mysqli_fetch_assoc($resultRowNum);
$totalRowNumber = $rowNumbers['total'];

// for total page 
$recordsPerPage = 10;
$totalPages = ceil($totalRowNumber / $recordsPerPage);

// my current page
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($currentPage - 1) * $recordsPerPage;


// for get Book content from db
$sqlFetch = "SELECT * FROM jobs ORDER BY j_id DESC LIMIT $offset, $recordsPerPage";
$resFetch = mysqli_query($con, $sqlFetch);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jobs</title>
    <link rel="stylesheet" href="./sidestyles.css">
    <link rel="stylesheet" href="../CSS/globals.css">
    <link rel="stylesheet" href="./CSS/model.css">
    <link rel="stylesheet" href="./CSS/books.css">
    <style>
        select {
            padding: 10px;
            border: 1px solid #555;
            border-radius: 4px;
            outline: none;
            cursor: pointer !important;
            font-size: 17px !important;
            gap: 10px;
            display: flex;
            flex-direction: column;
        }

        #contentModal {
            min-height: 580px;
        }

        .formContent {
            margin-top: 105px;
        }

        #nameTab {
            width: 20%;
        }

        #pbdate input {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php include "./sideNav.php"; ?>

    <div id="content">
        <div id="semicontent">
            <div id="maincontent">
                <div class="contentTable">
                    <button id="modalOpen">Add Jobs</button>
                    <table>
                        <tr>
                            <th id="snTab">S.N</th>
                            <th id="nameTab">Job title</th>
                            <th>Category</th>
                            <th>Address</th>
                            <th>Min salary</th>
                            <th>Max salary</th>
                            <th>Job Nature</th>
                            <th>Description</th>
                            <th>Qualification</th>
                            <th>Responsibility</th>
                            <th>Posted date</th>
                            <th>Image</th>
                            <th colspan="2">Action</th>
                        </tr>
                        <?php
                        $index = 1;
                        if (mysqli_num_rows($resFetch) > 0) {
                            while ($row = mysqli_fetch_assoc($resFetch)) {
                                echo "
                        <tr style='text-transform:capitalize'>
                            <td>" . $index . "</td>
                            <td>" . $row["j_title"] . "</td>
                            <td>" . $row["j_category"] . "</td>
                            <td>" . $row["j_address"] . "</td>
                            <td>" . $row["min_salary"] . "</td>
                            <td>" . $row["maximum_salary"] . "</td>
                            <td>" . $row["j_nature"] . "</td>
                            <td>" . $row["j_description"] . "</td>
                            <td>" . $row["j_qualification"] . "</td>
                            <td>" . $row["j_responsibility"] . "</td>
                            <td>" . $row["date_added"] . "</td>

                            
                            <td><img src='" . $row["j_image"] . "' height='30' width='30' style='border-radius: 0% 30% 10% 10%'></td>
                            
                            <td>
                                <a href=\"./job.php?edit=" . $row["j_id"] . "\">
                                    <svg width='16' height='16' viewBox='0 0 25 24' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M22.5 8.75V7.5L15 0H2.5C1.1125 0 0 1.1125 0 2.5V20C0 21.3875 1.125 22.5 2.5 22.5H10V20.1625L20.4875 9.675C21.0375 9.125 21.7375 8.825 22.5 8.75ZM13.75 1.875L20.625 8.75H13.75V1.875ZM24.8125 13.9875L23.5875 15.2125L21.0375 12.6625L22.2625 11.4375C22.5 11.1875 22.9125 11.1875 23.1625 11.4375L24.8125 13.0875C25.0625 13.3375 25.0625 13.75 24.8125 13.9875ZM20.1625 13.5375L22.7125 16.0875L15.05 23.75H12.5V21.2L20.1625 13.5375Z' />
                                    </svg>
                                </a>
                            </td>
                            <td>
                                <a href=\"./job.php?delete=" . $row["j_id"] . "\">
                                    <svg width='16' height='16' viewBox='0 0 20 23' xmlns='http://www.w3.org/2000/svg'>
                                        <path d='M6.25 0V1.25H0V3.75H1.25V20C1.25 20.663 1.51339 21.2989 1.98223 21.7678C2.45107 22.2366 3.08696 22.5 3.75 22.5H16.25C16.913 22.5 17.5489 22.2366 18.0178 21.7678C18.4866 21.2989 18.75 20.663 18.75 20V3.75H20V1.25H13.75V0H6.25ZM6.25 6.25H8.75V17.5H6.25V6.25ZM11.25 6.25H13.75V17.5H11.25V6.25Z' />
                                    </svg>
                                </a>
                            </td>
                        </tr> ";
                                $index++;
                            }
                        }
                        ?>
                    </table>
                </div>
                <div class="pagination">
                    <?php
                    if ($currentPage > 1) {
                        echo '<a href="?page=' . ($currentPage - 1) . '" class="leftArrow">&laquo;</a>';
                    } else {
                        echo '<a class="leftArrow">&laquo;</a>';
                    }

                    for ($i = 1; $i <= $totalPages; $i++) {
                        $activeClass = ($currentPage == $i) ? 'activePage' : '';
                        echo '<a href="?page=' . $i . '" class="' . $activeClass . '">' . $i . '</a>';
                    }

                    if ($currentPage < $totalPages) {
                        echo '<a href="?page=' . ($currentPage + 1) . '" class="rightArrow">&raquo;</a>';
                    } else {
                        echo '<a class="rightArrow">&raquo;</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <!-- for modal  -->
    <div id="modal">
        <div id="background">
            <div id="contentModal">
                <!-- For close button -->
                <br><br><br><br><br><br> <br><br><br><button id="crossModal">X</button>
                <div class="formContent">
                    <form action="./job.php" method="POST" enctype="multipart/form-data">
                        <select name="j_category" id="category">
                            <?php
                            if (mysqli_num_rows($resFetchsub) > 0) {
                                while ($rowcat = mysqli_fetch_assoc($resFetchsub)) {
                                    echo "<option value=" . $rowcat['id'] . ">" . $rowcat['cname'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        
                        <input type="hidden" name="editId" value="<?php echo $editId ?>" j_id="">
                        <input type="text" name="j_title" value="<?php echo $title ?>" id=" j_title" placeholder="Job Title" required>
                        <input type="text" name="j_address" value="<?php echo $address ?>" id="j_address" placeholder="Address" required>
                        <input type="number" name="min_salary" value="<?php echo $min_salary ?>" id="min_salary" placeholder="Minimum Salary" required>
                        <input type="number" name="maximum_salary" value="<?php echo $max_salary ?>" id=" maximum_salary" placeholder="Maximum Salary" required>
                        <input type="text" name="j_nature" value="<?php echo $job_nature ?>" id="j_nature" placeholder="Job Nature" required>
                        <input type="text" name="j_description" value="<?php echo $job_description ?>" id="j_description" placeholder="Description" required>
                        <input type="text" name="j_qualification" value="<?php echo $job_qualification ?>" id="j_qualification" placeholder="Qualification" required>
                        <input type="text" name="j_responsibility" value="<?php echo $job_responsibility ?>" id="j_responsibility" placeholder="Responsibility" required>
                        <input type="date" name="date_added" value="<?php echo $date ?>" id="pbdate" placeholder="Date added" required>

                        <input id="image" type="file" name="j_image" accept=".jpg, .png, .jpeg" value="<?php echo $img ?>" required>
                        
                        <div class="formButtons">
                            <?php
                            if (intval($editId) > 0) {
                                echo "<button type='submit' name='updateContent'>Update</button>";
                            } else {
                                echo "<button type='submit' name='addContent'>Add</button>";
                            }
                            ?>
                            <button type="reset">Reset</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


    <script>
        const modal = document.getElementById("modal");
        const modalOpen = document.getElementById("modalOpen");
        const crossModal = document.getElementById("crossModal");
        const params = new URLSearchParams(window.location.search);
        let editParameter = Number(params.get('edit'));
        if (editParameter > 0) {
            modal.style.display = "block";
        }
        const urlWithoutParams = window.location.origin + window.location.pathname;

        modalOpen.addEventListener('click', () => {
            modal.style.display = "block";
        })
        crossModal.addEventListener('click', () => {
            modal.style.display = "none";
            window.location.href = urlWithoutParams;
        })
    </script>
</body>

</html>