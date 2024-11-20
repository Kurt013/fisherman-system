<?php
if (isset($_POST['export'])) {
    include "../connection.php";

    // Get the export format and month chosen by the user
    $export_format = $_POST['export_format'];
    $export_month = $_POST['export_month'];

    // SQL query to filter by selected month or export all activities
    if ($export_month == 'all') {
        // Export all activities
        $SQL = "SELECT dateofactivity, activity, description FROM tblactivity WHERE archive = 0 ORDER BY dateofactivity"; 
        $filename = 'all-activities'; // Filename for "all" activities
    } else {
        // Filter by selected month (e.g., '01' for January)
        $SQL = "SELECT dateofactivity, activity, description FROM tblactivity WHERE archive = 0 AND MONTH(dateofactivity) = '$export_month' ORDER BY dateofactivity"; 
        
        // Create a filename based on the selected month (e.g., November)
        $monthNames = array(
            "01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June",
            "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December"
        );
        $monthName = isset($monthNames[$export_month]) ? $monthNames[$export_month] : 'Unknown';
        $filename = strtolower($monthName) . '-activity'; // Example: november-activity
    }

    $arrhead = array("Date of Activity", "Activity", "Description");

    // Prepare the data output
    $output = "List of Activities\n";
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
            $line = '"' . $row['dateofactivity'] . '"' . "\t";
            $line .= '"' . $row['activity'] . '"' . "\t";
            $line .= '"' . $row['description'] . '"' . "\t";
            $output .= trim($line) . "\n";
        }

        // Send headers and output Excel with the dynamic filename
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename.xls");
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
        $pdf->Cell(0, 10, 'BFARMC Activity', 0, 1, 'C');

        // Set header
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Date of Activity', 1, 0, 'C');
        $pdf->Cell(90, 10, 'Activity', 1, 0, 'C');
        $pdf->Cell(60, 10, 'Description', 1, 1, 'C');

        // Set content font
        $pdf->SetFont('Arial', '', 10);

        // Loop through the result and add to the table
        while ($row = mysqli_fetch_assoc($result)) {
            $pdf->Cell(40, 10, $row['dateofactivity'], 1);
            $pdf->Cell(90, 10, $row['activity'], 1);
            $pdf->Cell(60, 10, $row['description'], 1, 1);
        }

        // Output the PDF with the dynamic filename
        $pdf->Output("$filename.pdf", 'D');
        exit;
    }
}
?>
