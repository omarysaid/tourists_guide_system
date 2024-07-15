<?php
include("../connection/connection.php");
$region_id = $_REQUEST['region_id'];
$query = "DELETE FROM regions  WHERE region_id=$region_id";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));

// Check if deletion was successful
if ($result) {
    // Redirect to view.php with success message
    header("Location: ./view.php?success=1");
} else {
    // Redirect to view.php with failure message
    header("Location: ./view.php?success=0");
}
exit();