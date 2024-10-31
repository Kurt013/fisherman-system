<?php
if (isset($_POST['export'])) {
    include "../connection.php";

    // Updated SQL query to retrieve concatenated names and cellphone numbers of residents, including Zone
    $SQL = "SELECT CONCAT(lname, ', ', fname, ' ', mname) AS cname, cpnumber, zone FROM tblresident"; 

    $arrhead = array("Name", "Cellphone Number", "Purok"); 

    $output = '';

    // Prepare the export data
    $output .= "Residents Information\n"; 
    $output .= implode("\t", $arrhead) . "\n"; 

    $result = mysqli_query($con, $SQL);
    
    // Check for query error
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    // Debugging: Output number of rows
    $numRows = mysqli_num_rows($result);
    echo "Number of rows: " . $numRows; 

    if ($numRows > 0) {
        // Fetching data rows
        while ($row = mysqli_fetch_assoc($result)) {
            $line = '';
            // Use the correct keys based on your SQL query
            $line .= '"' . $row['cname'] . '"' . "\t"; // Accessing the concatenated name
            $line .= '"' . $row['cpnumber'] . '"' . "\t"; // Accessing the cellphone number
            $line .= '"' . $row['zone'] . '"' . "\t"; // Accessing the zone
            $output .= trim($line) . "\n"; 
        }
    } else {
        $output .= "\nNo Record(s) Found!\n";                        
    }

    // Prepare the Excel download
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=export.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo "$output";
    exit;
}
?>
