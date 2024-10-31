<?php
session_start();
include "../connection.php";

if (isset($_GET['id'])) {
    $memberId = mysqli_real_escape_string($con, $_GET['id']);
    
    $query = mysqli_query($con, "SELECT id, CONCAT(lname, ', ', fname, ' ', mname) AS cname, age, CONCAT(zone, ', ', barangay) AS address, cpnumber, image FROM tblresident WHERE id = '$memberId'");
    
    if ($row = mysqli_fetch_assoc($query)) {
        echo json_encode(['success' => true, 'member' => $row]);
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
?>
