<?php
if (isset($_POST['export'])) {
    include "../connection.php";

    // Get the export format and data type chosen by the user
    $export_format = $_POST['export_format'];
    $data_type = $_POST['data_type'];

    // Prepare SQL query based on the data type chosen
    if ($data_type == 'fisherman') {
        // Query for fishermen only (excluding cpnumber)
        $SQL = "SELECT CONCAT(lname, ', ', fname, ' ', mname) AS cname, zone FROM tblresident WHERE archive = 0 AND type = 'Fisherman' ORDER BY zone";
        $title = 'List of Fisherman Members'; // Set the title for fishermen
    } elseif ($data_type == 'Fish Vendor') {
        // Query for fish vendors only (excluding cpnumber)
        $SQL = "SELECT CONCAT(lname, ', ', fname, ' ', mname) AS cname, zone FROM tblresident WHERE archive = 0 AND type = 'Fish Vendor' ORDER BY zone";
        $title = 'List of Fish Vendor Members'; // Set the title for fish vendors
    } else {
        // Query for both fishermen and fish vendors (excluding cpnumber)
        $SQL = "SELECT CONCAT(lname, ', ', fname, ' ', mname) AS cname, zone FROM tblresident WHERE archive = 0 ORDER BY zone";
        $title = 'List of all BFARMC Members'; // Set the title for both
    }

    $arrhead = array("Purok", "Name"); // Updated header without Cellphone Number

    // Prepare the data output
    $output = $title . "\n"; // Use dynamic title
    $output .= implode("\t", $arrhead) . "\n";

    $result = mysqli_query($con, $SQL);

    // Check for query error
    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    // Handle Export Based on User's Choice
    if ($export_format == 'excel') {
        // Export to Excel
        $output .= "\n";
        while ($row = mysqli_fetch_assoc($result)) {
            $line = '"' . $row['zone'] . '"' . "\t"; // Accessing the zone (Purok)
            $line .= '"' . $row['cname'] . '"' . "\t"; // Accessing the concatenated name
            $output .= trim($line) . "\n";
        }

        // Send headers and output Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=" . $title . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo $output;
        exit;
    } elseif ($export_format == 'pdf') {
        // Export to PDF using FPDF
        require_once '../../fpdf/fpdf.php'; // Include the FPDF library

        // Initialize PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 15);

        // Add title (dynamic title)
        $pdf->Cell(0, 20, $title, 0, 1, 'C');

        // Set header
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(40, 10, 'Purok', 1, 0, 'C');
        $pdf->Cell(150, 10, 'Name', 1, 1, 'C');

        // Set content font
        $pdf->SetFont('Arial', '', 12);

        // Loop through the result and add to the table
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(40, 10, $row['zone'], 1, 0, 'C');
            $pdf->Cell(150, 10, $row['cname'], 1, 1, 'C');
        }

        // Output the PDF
        $pdf->Output($title . '.pdf', 'D');
        exit;
    }
}
?>
