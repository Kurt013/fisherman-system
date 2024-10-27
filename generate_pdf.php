<?php
ob_start(); // Start output buffering

require 'C:\xampp\htdocs\fisherman-system\vendor\autoload.php'; // Adjust the path based on your structure
require 'C:\xampp\htdocs\fisherman-system\fpdf\fpdf.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
echo "Reached generate_pdf.php"; // This will show if the script is executed
exit; // Stop further execution for now

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the QR code data and image data from the form
    $qrData = htmlspecialchars($_POST['qr_data']); // Sanitize input
    $qrImageData = $_POST['image_data'];

    // Create a new PDF document
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Resident QR Code', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->MultiCell(0, 10, $qrData, 0, 'C');
    $pdf->Ln(10);

    // Decode the base64 image data
    $qrImageData = str_replace('data:image/png;base64,', '', $qrImageData);
    $qrImage = base64_decode($qrImageData);

    // Validate if decoding was successful
    if ($qrImage === false) {
        die('Failed to decode QR image.');
    }

    // Save the QR code image to a temporary file
    $tempImageFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
    file_put_contents($tempImageFile, $qrImage);

    // Add the QR code image to the PDF
    $pdf->Image($tempImageFile, 10, 60, 60, 60); // Adjust positioning and size as needed

    // Output the PDF as a file download
    $pdf->Output('I', 'qr_code.pdf'); // Changed to 'I' for inline display (change to 'D' for download)

    // Clean up temporary image file
    unlink($tempImageFile);
} else {
    // Handle case where the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo 'Method Not Allowed';
}

ob_end_flush(); // Flush the output buffer
?>
