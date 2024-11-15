<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Validate passwords match
    if ($password !== $cpassword) {
        echo "Passwords do not match.";
        exit;
    }

    // File upload handling
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logoName = uniqid() . '_' . $_FILES['logo']['name'];
        $logoTmpName = $_FILES['logo']['tmp_name'];
        $logoError = $_FILES['logo']['error'];

        // Check for file upload errors
        switch ($_FILES['logo']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "The uploaded file exceeds the maximum file size.";
                exit;
            case UPLOAD_ERR_PARTIAL:
                echo "The uploaded file was only partially uploaded.";
                exit;
            case UPLOAD_ERR_NO_FILE:
                echo "No file was uploaded.";
                exit;
            case UPLOAD_ERR_NO_TMP_DIR:
                echo "Missing a temporary folder.";
                exit;
            case UPLOAD_ERR_CANT_WRITE:
                echo "Failed to write file to disk.";
                exit;
            case UPLOAD_ERR_EXTENSION:
                echo "A PHP extension stopped the file upload.";
                exit;
        }

        // Database connection
        $con = new mysqli("localhost", "root", "", "login");
        if ($con->connect_error) {
            die("Failed to connect: " . $con->connect_error);
        } else {
            // Move uploaded file to desired directory
            
$logoDestination = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $logoName;


            move_uploaded_file($logoTmpName, $logoDestination);

            // Prepared statement
            $stmt = $con->prepare("INSERT INTO users (u_name, email, password, u_image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $username, $email, $password, $logoName);

            // Execute the statement and handle errors
            if ($stmt->execute()) {
                $_SESSION['status']="User signed up successfully";
                $_SESSION['status_code']="success";

                header("Location: signinusr.php");

                exit;;
            } else {
                $_SESSION['status']="User not signed up successfully";
                $_SESSION['status_code']="error";

                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $con->close();
        }
    } else {
        echo "Error uploading the logo file.";
    }
}
?>

