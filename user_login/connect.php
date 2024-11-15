<?php
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    //database connection
    $con = new mysqli("localhost","root","","login");
    if($con->connect_error) {
        die("Failed to connect :".$con->connect_error);
    } else {
        $stmt = $con->prepare("insert into users(u_name, email, password) 
        values(?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password );
        $stmt->execute();
       echo "Signed Up Sucessfully";
       $stmt->close();
       $con->close();
    } 


?>