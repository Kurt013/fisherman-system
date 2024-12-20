<?php
// Start output buffering to prevent "headers already sent" errors
ob_start();
session_start();

// Include necessary libraries and files
require 'C:\xampp\htdocs\fisherman-system\vendor\autoload.php'; // Adjust the path based on your structure
require 'C:\xampp\htdocs\fisherman-system\fpdf\fpdf.php'; // Include the FPDF library
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

// Check if user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: ../../index.php"); 
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database connection
    include "../connection.php"; // Ensure this file sets $con properly

    if (isset($_POST['btn_archive'])) {
        if (!empty($_POST['chk_delete'])) {
            // Sanitize and prepare the list of IDs for the query
            $idsToArchive = array_map('intval', $_POST['chk_delete']);
            $idsToArchive = implode(',', $idsToArchive);  // Join them into a comma-separated string
            
            // Make sure the $idsToArchive list is not empty
            if (!empty($idsToArchive)) {
                $archiveQuery = "UPDATE tblresident SET archive = 1 WHERE id IN ($idsToArchive)";
                if (mysqli_query($con, $archiveQuery)) {
                    $_SESSION['archive'] = "Members archived successfully."; // Set the notification
                } else {
                    $_SESSION['archive_error'] = "Error archiving members."; // Handle the error
                }
            } else {
                $_SESSION['archive_error'] = "No valid IDs selected."; // Handle the case where no valid IDs are selected
            }
            // Redirect to the same page
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }
    

    if (isset($_POST['qr_data']) && isset($_POST['image_data'])) {
        // Handle the PDF generation action
        $qrData = htmlspecialchars($_POST['qr_data']); // Sanitize input
        $qrImageData = $_POST['image_data'];
    
        // Decode the QR code image data and save it as a temporary file
        $tempImageFile = tempnam(sys_get_temp_dir(), 'qr_') . '.png'; // Create a temp file
        file_put_contents($tempImageFile, base64_decode($qrImageData)); // Save the QR code image
    
        // Fetch member details
// Fetch member details
$memberId = explode('=', $qrData);

// Check if the expected ID is present
if (count($memberId) > 1) {
    $memberId = trim($memberId[1]); // Safely extract the member ID
} else {
    echo "Invalid QR data format.";
    exit; // Stop execution if the format is invalid
}
        $query = mysqli_query($con, "SELECT id, CONCAT(lname, ', ', fname, ' ', mname) AS cname, image FROM tblresident WHERE id = '$memberId'");
    
        // Check if a row was returned
        if ($row = mysqli_fetch_assoc($query)) {
            // Create a new PDF document
            $pdf = new FPDF('L', 'mm', [180, 180]); // Landscape orientation with short bond paper size (8.5 x 11 inches)
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false);
    
            // Set colors for header and footer
            // (Add any header/footer styling here if needed)
    
            // Logo and Title
            $pdf->SetXY(10, 3);
            $pdf->Image('C:\xampp\htdocs\fisherman-system\img\bg-id.png', 0, 0, 186, 185); // Adjust the logo path and size
            $pdf->SetFont('Arial', 'B', 12);
            
            // Member Image
            $pdf->SetDrawColor(6, 5, 166); // Set border color
            $pdf->SetLineWidth(1.1); // Adjust this value for thickness
    
            // Draw a border rectangle around the image
            $pdf->Rect(57, 50, 61, 60); // Draw border
            if ($row['image']) {
                $pdf->Image('image/' . basename($row['image']), 58, 52, 59, 58); // Adjust the member image path
            } else {
                $pdf->SetXY(10, 30);
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->SetTextColor(128, 128, 128); // Gray text color
                $pdf->Cell(30, 10, 'IMAGE', 0, 2, 'C');
                $pdf->Cell(30, 10, 'UNAVAILABLE', 0, 2, 'C');
            }
    
            // Member Details
            $pdf->SetFont('Helvetica', 'B', 20);
            $pdf->SetXY(70, 135);
            $pdf->Cell(0, 10, $row['cname'], 0, 1); // Use 10 for height to fit the text better
            $pdf->SetFont('Helvetica', 'B', 20);
    
            // QR Code
            $pdf->SetDrawColor(6, 5, 166); // Set border color
            $pdf->SetLineWidth(1.1); // Adjust this value for thickness
            // Draw a border rectangle around the image
            $pdf->Rect(20, 115, 47, 47); // Draw border
            $pdf->Image($tempImageFile, 21, 116, 45, 45); // QR Code
    
            // Clean output buffer before sending PDF
            ob_end_clean();
            // Output the PDF as a file download
            $pdf->Output('I', 'qr_code.pdf'); // Inline display
            unlink($tempImageFile); // Clean up temporary image file
            exit; // Stop further execution
        } else {
            // Handle case where no member was found
            echo "Member not found.";
            exit;
        }
    }
}
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>BFARMC - Sinalhan</title>
    <link rel="icon" href="img\bfarmc-sinalhan-logo.png">
    <?php include('../head_css.php'); ?>
    <style>
        .input-size {
            width: 418px;
        }
    </style>
</head>
<body class="skin-blue">
<?php 
include "../connection.php"; 
include('../header.php'); 
?>

<div class="wrapper row-offcanvas row-offcanvas-left">
    <?php include('../sidebar-left.php'); ?>

    <aside class="right-side">
        <section class="content-header">
        <h1>                          
                 <?php 
                            // Check if the user role is not 'Staff' before displaying the delete button
                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                            ?>
                            <a href="#" class="redirect-button">                           
                            <span class="icon"><i class="fa-solid fa-box-archive"></i></span> <span> Archive List</span>
                        </a>
                        <?php
                            }
                            
                            ?>          
                            <a href="../resident/resident.php" class="redirect-button" style="color: #0605a6; float:right;" >
                <i class="fa fa-users"></i>
                <span class="tooltip-text">Members List</span>

                </a> 
                        </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-header">
                        <div style="padding:10px;">

                            <?php 
                            // Check if the user role is not 'Staff' before displaying the delete button
                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                            ?>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#unarchiveModal"><i class="fa fa-trash-o" aria-hidden="false"></i> Unarchive</button> 
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <form method="post">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <?php if (!isset($_SESSION['staff'])) { ?>
                                            <th style="width: 20px !important;">
                                                <input type="checkbox" name="chk_unarchive[]" class="cbxMain" onchange="checkMain(this)"/>
                                            </th>
                                        <?php } ?>
                                        <th>Purok</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Type</th>
                                        <th>Cellphone Number</th>

                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $squery = mysqli_query($con, "SELECT zone, id, CONCAT(lname, ', ', fname, ' ', mname) AS cname, age, type, cpnumber 
                                FROM tblresident 
                                WHERE archive = 1 
                                ORDER BY zone");
                                while ($row = mysqli_fetch_array($squery)) {
                                // Generate QR Code for each resident
                                $ngrokUrl = 'https://daring-hen-mainly.ngrok-free.app';
                                $qrData = $ngrokUrl . '/fisherman-system/pages/resident/display_member.php?id=' . $row['id'];
                                $qrCode = new QrCode($qrData);
                                $writer = new PngWriter();
                                $qrCodeImage = $writer->write($qrCode);
                                $qrCodeBase64 = base64_encode($qrCodeImage->getString());

                                echo '
                                <tr>
                                    <td><input type="checkbox" name="chk_unarchive[]" class="chk_delete" value="' . $row['id'] . '" /></td>
                                    <td>' . $row['zone'] . '</td>
                                    <td>' . $row['cname'] . '</td>
                                    <td>' . $row['age'] . '</td>
                                    <td>' . $row['type'] . '</td>
                                    <td>' . $row['cpnumber'] . '</td>
                                </tr>';
                                include "../resident/edit_modal.php";

                            }
                            ?>
</tbody>

                            </table>

                            
                            <?php include "../archiveModal.php"; ?>
                            
                        </form>

                    </div>
                </div>
                <?php include "../edit_notif.php"; ?>
                <?php include "../added_notif.php"; ?>
                <?php include "../archive_notif.php"; ?>
                <?php include "../duplicate_error.php"; ?>
                <?php include "../resident/add_modal.php"; ?>

<?php include "../resident/function.php"; ?>
            </div>
        </section>
    </aside>
</div>
<?php include "../footer.php"; ?>
<script type="text/javascript">
        <?php if(!isset($_SESSION['staff'])) { ?>
            $(function() {
                $("#table").DataTable({
                    "responsive": true,
                    "aoColumnDefs": [ 
                        { "bSortable": false, "aTargets": [ 0, 5 ] }
                    ],
                    "aaSorting": [],
                    "autoWidth": false 
                });
            });
        <?php } else { ?>
            $(function() {
                $("#table").DataTable({
                    "responsive": true,
                    "aoColumnDefs": [ 
                        { "bSortable": false, "aTargets": [ 6 ] }
                    ],
                    "aaSorting": [],
                    "autoWidth": false
                });
            });
        <?php } ?>
        </script>

    <script type="text/javascript">
    // Function to prevent checkbox state change when clicking on other elements
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.toggle-button-class'); // Use your actual class for toggle buttons
        toggleButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation(); // Prevent click event from bubbling up
            });
        });
    });

</script>
        <script type="text/javascript">
    function generatePdf(qrData, imageData) {
        var form = document.createElement('form');
        form.method = 'POST';
        form.target = '_blank'; // This makes the form submission open in a new tab
        form.action = ''; // This will be the current page

        var qrDataInput = document.createElement('input');
        qrDataInput.type = 'hidden';
        qrDataInput.name = 'qr_data';
        qrDataInput.value = qrData;

        var imageDataInput = document.createElement('input');
        imageDataInput.type = 'hidden';
        imageDataInput.name = 'image_data';
        imageDataInput.value = imageData;

        form.appendChild(qrDataInput);
        form.appendChild(imageDataInput);
        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form); // Clean up the form after submission
    }

    $(document).ready(function() {
    // Replace the "Previous" text with the backward icon
    $('div.dataTables_paginate ul.pagination li:first-child a').html('<i class="fa-solid fa-backward"></i>');

    // Replace the "Next" text with the forward icon
    $('div.dataTables_paginate ul.pagination li:last-child a').html('<i class="fa-solid fa-forward"></i>');
});
</script>

</body>
</html>
