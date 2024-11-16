<?php
if (isset($_POST['export'])) {
    include "../connection.php";

    // Get the export format chosen by the user
    $export_format = $_POST['export_format'];

    // Updated SQL query to retrieve concatenated names and cellphone numbers of residents, ordered by Purok (zone)
    $SQL = "SELECT CONCAT(lname, ', ', fname, ' ', mname) AS cname, cpnumber, zone FROM tblresident WHERE archive = 0 ORDER BY zone"; 

    $arrhead = array("Purok", "Name", "Cellphone Number");

    // Prepare the data output
    $output = "List of Members\n";
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
            $line .= '"' . $row['cpnumber'] . '"' . "\t"; // Accessing the cellphone number
            $output .= trim($line) . "\n";
        }

        // Send headers and output Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=List_of_Members.xls");
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
        $pdf->SetFont('Arial', 'B', 12);

        // Add title
        $pdf->Cell(0, 10, 'List of Members', 0, 1, 'C');

        // Set header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Purok', 1, 0, 'C');
        $pdf->Cell(90, 10, 'Name', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Cellphone Number', 1, 1, 'C');

        // Set content font
        $pdf->SetFont('Arial', '', 10);

        // Loop through the result and add to the table
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(40, 10, $row['zone'], 1);
            $pdf->Cell(90, 10, $row['cname'], 1);
            $pdf->Cell(60, 10, $row['cpnumber'], 1, 1);
        }

        // Output the PDF
        $pdf->Output('List_of_Members.pdf', 'D');
        exit;
    }
}
?>
