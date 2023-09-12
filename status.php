<?php
// include ('database.php');
$mysqli = require __DIR__ . "/database.php";

// Check if 'id' and 'status' parameters are set in the URL
if(isset($_GET['id']) && isset($_GET['status'])){
    $id = $_GET['id'];
    $status = $_GET['status'];
    
    // Make sure to escape and validate user input to prevent SQL injection
    // $id = mysqli_real_escape_string($mysqli, $id);
    // $status = mysqli_real_escape_string($mysqli, $status);
    
    // Update the status in the database
    $sql = "UPDATE user SET status='$status' WHERE id='$id'";
    $result = $mysqli->query($sql);
    if($result){
        header("Location: admin_dashboard.php");
    }
    // if (mysqli_query($mysqli, $q)) {
    //     header("Location: admin.php");
    //     exit; // Exit to prevent further execution
    // } else {
    //     echo "Error updating status: " . mysqli_error($mysqli);
    // }
} else {
    echo "Invalid parameters.";
}
?>