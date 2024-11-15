<?php
// start the session
session_start();
//check if user is logged in
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
    header('location:user_login/index.php');
} else{
    //if not logged in, display a login form
    $username = $_POST['username'];
  $password = $_POST['password'];
}
  
    
  //database connection
    $con = new mysqli("localhost","root","","login");
    if($con->connect_error) {
        die("Failed to connect :".$con->connect_error);
    } else {
        $stmt = $con->prepare("select * from users where u_name = ? ");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt_result = $stmt->get_result();
        if($stmt_result->num_rows > 0){
            $data = $stmt_result->fetch_assoc();
            if($data['password'] === $password) {
                $_SESSION['logged_in'] === true;
                
                $_SESSION['u_name'] = $username;
                header('location:user_login/index.php');
            } 
            else{
                echo " <h2> Invalid username or password</h2> ";
            }

        }else{
            echo " <h2> Invalid username or password</h2> ";
        }
    } 


?>