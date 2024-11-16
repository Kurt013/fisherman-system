<?php
if (isset($_POST['export'])) {
    include "../connection.php";

    // SQL queries to fetch data
    $SQL1 = "SELECT COUNT(*) AS NumberofOfficial FROM tblofficial WHERE archive = 0"; // Total Officials
    $SQL2 = "SELECT COUNT(*) AS NumberofMembers FROM tblresident WHERE archive = 0"; // Total Residents per Zone
    $SQL3 = "SELECT COUNT(*) AS NumberofActivities FROM tblactivity WHERE archive = 0"; // Total Activities
    $SQL4 = "SELECT COUNT(*) AS NumberofMembers, Zone FROM tblresident WHERE archive = 0 GROUP BY Zone"; // Total Residents per Purok
    $SQL5 = "SELECT COUNT(*) AS NumberofMembers, Age FROM tblresident WHERE archive = 0 GROUP BY Age"; // Total Residents by Age
    $SQL6 = "SELECT COUNT(*) AS NumberofMembers, type FROM tblresident WHERE archive = 0 GROUP BY type"; // Total Residents by Type

    $arrsql = array($SQL1, $SQL2, $SQL3, $SQL4, $SQL5, $SQL6);
    $arrhead = array("Total Officials", "Total Members", "Total Activities", "Population per Purok", "Members by Age", "Members by Type");

    $output = '';

    // Loop through the SQL queries and prepare the export data
    foreach (array_combine($arrsql, $arrhead) as $query => $header) {
        $output .= "$header\n";
        $result = mysqli_query($con, $query);
        
        if ($result) {
            // For the last 3 queries, we need to display two columns: Category (Purok, Age, Type) and Number of Members
            if ($header == "Population per Purok") {
                // Column header for Purok (Zone)
                $output .= "Purok\tNumber of Members\n";

                // Fetching the data rows
                while ($row = mysqli_fetch_assoc($result)) {
                    $output .= '"' . $row['Zone'] . '"' . "\t" . '"' . $row['NumberofMembers'] . '"' . "\n"; 
                }
            } elseif ($header == "Members by Age") {
                // Column header for Age
                $output .= "Age\tNumber of Members\n";

                // Fetching the data rows
                while ($row = mysqli_fetch_assoc($result)) {
                    $output .= '"' . $row['Age'] . '"' . "\t" . '"' . $row['NumberofMembers'] . '"' . "\n"; 
                }
            } elseif ($header == "Members by Type") {
                // Column header for Type
                $output .= "Type\tNumber of Members\n";

                // Fetching the data rows
                while ($row = mysqli_fetch_assoc($result)) {
                    $output .= '"' . $row['type'] . '"' . "\t" . '"' . $row['NumberofMembers'] . '"' . "\n"; 
                }
            } else {
                // For the first 3 queries, display just the count
                while ($row = mysqli_fetch_row($result)) {
                    $output .= '"' . $row[0] . '"' . "\n"; 
                }
            }
        } else {
            $output .= "\nNo Record(s) Found!\n";                         
        }

        // Separate each query output with a newline
        $output .= "\n";
    }

    // Check the export format chosen by the user
    $export_format = $_POST['export_format'];

    if ($export_format == 'excel') {
        // Prepare the Excel download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Report.xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        echo "$output";
        exit;
    } elseif ($export_format == 'pdf') {
        // Prepare the PDF download
        require_once '../../fpdf/fpdf.php'; // Include the FPDF library

        // Initialize PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);

        // Add title and center it
        $pdf->Cell(0, 10, 'Report: Population and Member Statistics', 0, 1, 'C');
        $pdf->Ln(10); // Add some space

        // Set content font
        $pdf->SetFont('Arial', '', 10);

        // Loop through the SQL queries to generate the PDF content
        foreach (array_combine($arrsql, $arrhead) as $query => $header) {
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(0, 10, $header, 0, 1, 'C');  // Center the header

            $pdf->SetFont('Arial', '', 10);

            $result = mysqli_query($con, $query);
            
            if ($result) {
                // For the last 3 queries, display data in table format
                if ($header == "Population per Purok") {
                    $pdf->SetX(55);
                    $pdf->Cell(50, 10, 'Purok', 1, 0, 'C');
                    $pdf->Cell(50, 10, 'Number of Members', 1, 1, 'C');
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pdf->SetX(55);
                        $pdf->Cell(50, 10, $row['Zone'], 1, 0, 'C');
                        $pdf->Cell(50, 10, $row['NumberofMembers'], 1, 1, 'C');
                    }
                } elseif ($header == "Members by Age") {
                    $pdf->SetX(55);
                    $pdf->Cell(50, 10, 'Age', 1, 0, 'C');
                    $pdf->Cell(50, 10, 'Number of Members', 1, 1, 'C');
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pdf->SetX(55);
                        $pdf->Cell(50, 10, $row['Age'], 1, 0, 'C');
                        $pdf->Cell(50, 10, $row['NumberofMembers'], 1, 1, 'C');
                    }
                } elseif ($header == "Members by Type") {
                    $pdf->SetX(55);
                    $pdf->Cell(50, 10, 'Type', 1, 0, 'C');
                    $pdf->Cell(50, 10, 'Number of Members', 1, 1, 'C');
                    while ($row = mysqli_fetch_assoc($result)) {
                        $pdf->SetX(55);
                        $pdf->Cell(50, 10, $row['type'], 1, 0, 'C');
                        $pdf->Cell(50, 10, $row['NumberofMembers'], 1, 1, 'C');
                    }
                } else {
                    // For the first 3 queries, display the count
                    while ($row = mysqli_fetch_row($result)) {
                        $pdf->SetX(55);
                        $pdf->Cell(100, 10, $row[0], 1, 1, 'C');
                    }
                }
            } else {
                $pdf->Cell(0, 10, 'No Records Found', 0, 1, 'C');
            }
        }

        // Output the PDF
        $pdf->Output('Report.pdf', 'D');
        exit;
    }
}
?>
