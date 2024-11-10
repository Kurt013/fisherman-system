<?php
if (isset($_POST['export'])) {
    include "../connection.php";

    // Updated SQL query to retrieve concatenated names and cellphone numbers of residents, ordered by Purok (zone)
    $SQL = "SELECT CONCAT(lname, ', ', fname, ' ', mname) AS cname, cpnumber, zone FROM tblresident WHERE archive = 0 ORDER BY zone"; 

    $arrhead = array( "Purok", "Name", "Cellphone Number"); 

    $output = '';

    // Prepare the export data
    $output .= "List of Members\n"; 
    $output .= implode("\t", $arrhead) . "\n"; 

    $result = mysqli_query($con, $SQL);
    
    // Check for query error
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    // Check if there are rows in the result
    if (mysqli_num_rows($result) > 0) {
        // Fetching data rows
        while ($row = mysqli_fetch_assoc($result)) {
            $line = '';
            // Use the correct keys based on your SQL query
            $line .= '"' . $row['zone'] . '"' . "\t"; // Accessing the zone (Purok)
            $line .= '"' . $row['cname'] . '"' . "\t"; // Accessing the concatenated name
            $line .= '"' . $row['cpnumber'] . '"' . "\t"; // Accessing the cellphone number
            $output .= trim($line) . "\n"; 
        }
    } else {
        $output .= "\nNo Record(s) Found!\n";                         
    }

    // Prepare the Excel download
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=List_of_Members.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo "$output";
    exit;
}
?>