<?
$conn = new mysqli("localhost","root","","login");
if(!$conn)
{
    die("Error detecting record:".mysqli_error($conn));
}

if (isset($_POST['submit']))
{
    $title=$_POST['title'];
    $category=$_POST['category'];
    $address=$_POST['address'];
    $min_salary=$_POST['minsal'];
    $max_salary=$_POST['maxsal'];
    $job_nature=$_POST['jnat'];
    $job_description=$_POST['jdis'];
    $job_responsibility=$_POST['jres'];
    $job_qualification=$_POST['jqual'];    
    $sql="INSERT INTO jobs (`j_title`, `j_category`, `j_address`, `min_salary`, `max_salary`, `j_nature`, `j_description`, `j_qualification`, `j_responsibility`)
                    VALUES('$title', '$category', '$address', '$min_salary', '$max_salary', '$job_nature','$job_description','$job_qualification', '$job_responsibility')";
    if(!mysqli_query($conn,$sql))
    {
        echo "error";
    }
    else
    {
        echo "job posted successfully";
    }
    
}
?>