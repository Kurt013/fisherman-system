<?php
// Start output buffering to prevent "headers already sent" errors
ob_start();
session_start();

// Include necessary libraries and files
require '../../vendor/autoload.php'; // Adjust the path based on your structure
require '../../fpdf/fpdf.php'; // Include the FPDF library
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
        $query = mysqli_query($con, "SELECT id, lname, fname, mname, image FROM tblresident WHERE archive = 0 and id = '$memberId'");
    
        // Check if a row was returned
        if ($row = mysqli_fetch_assoc($query)) {
            // Create a new PDF document
            $pdf = new FPDF('P', 'mm', [43.18, 53.34]); // Landscape orientation with custom size (1.7 x 2.1 inches)
            $pdf->AddPage();
            $pdf->SetAutoPageBreak(false);
    
            // Set colors for header and footer
            // (Add any header/footer styling here if needed)
    
            // Logo and Title
            $pdf->SetXY(10, 3);
            $pdf->Image('C:\xampp\htdocs\fisherman-system\img\bg-id.png', 0, 0, 43.18, 53.34); // Adjust the logo path and size
            $pdf->SetFont('Arial', 'B', 12);
            
            // Member Image
            $pdf->SetDrawColor(6, 15, 166); // Set border color
            $pdf->SetLineWidth(0.3); // Adjust this value for thickness
    
            // Draw a border rectangle around the image
            $pdf->Rect(14, 16, 16, 16); // Draw border
            if ($row['image']) {
                $pdf->Image('image/' . basename($row['image']), 14, 16, 16, 16); // Adjust the member image path
            } else {
                $pdf->SetXY(10, 26);
                $pdf->SetFont('Arial', 'I', 8);
                $pdf->SetTextColor(128, 128, 128); // Gray text color
                $pdf->Cell(30, 10, 'IMAGE', 0, 2, 'C');
                $pdf->Cell(30, 10, 'UNAVAILABLE', 0, 2, 'C');
            }
    
            // Member Details
            $pdf->SetFont('Helvetica', 'B', 5);
            $pdf->SetXY(16, 35);
            
            // Combine the last name and first name properly and print them together in one cell
            $pdf->Cell(0, 10, $row['lname'] . ', ' . $row['fname'], 0, 1);
            
            // Now print the middle name
            $pdf->SetXY(16, 37);
            $pdf->Cell(0, 10, $row['mname'], 0, 1);
            

            // QR Code
            $pdf->SetDrawColor(6, 5, 166); // Set border color
            $pdf->SetLineWidth(0.3); // Adjust this value for thickness
            // Draw a border rectangle around the image
            $pdf->Rect(4, 34, 12, 12); // Draw border
            $pdf->Image($tempImageFile, 4, 34, 12, 12); // QR Code
    
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
            <a href="#" >
                <i class="fa fa-users"></i> <span>Members</span>
                </a>                           
                 <?php 
                            // Check if the user role is not 'Staff' before displaying the delete button
                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                            ?>
                            <a href="../archive/archive_resident.php" class="redirect-button" style="color: #0605a6; float:right;">                           
                            <span class="icon"><i class="fa-solid fa-box-archive"></i></span> 
                            <span class="tooltip-text">Archive List</span>

                        </a>
                        <?php
                            }
                            ?>
            </h1>
        </section>

        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-header">
                        <div style="padding:10px;">
                            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCourseModal">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> Add Members
                            </button>

                            <?php 
                            // Check if the user role is not 'Staff' before displaying the delete button
                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                            ?>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#archiveModal"><i class="fa-solid fa-box-archive" aria-hidden="false"></i> Archive</button> 
                            <?php
                            }
                            ?>
                            <div style="text-align: right;">
    <button type="button" class="btn btn-third btn-sm" data-toggle="modal" data-target="#exportModal">
        <i class="fa fa-file-export" aria-hidden="true"></i> Export
    </button>
</div>

                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <form method="post">
                            <table id="table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') { ?>
                                    <th style="width: 20px !important;">
                                        <input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)"/>
                                    </th>
                                <?php } ?>
                                        <th>Purok</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Type</th>
                                        <th>Registered Boat Number</th>
                                        <th>ID Card</th>
                                        <th style="width: 40px !important;">Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $squery = mysqli_query($con, "SELECT zone, id, CONCAT(lname, ', ', fname, ' ', mname) AS cname, age, type, boat_number, image 
                                FROM tblresident 
                                WHERE archive = 0 
                                ORDER BY zone");
                                while ($row = mysqli_fetch_array($squery)) {
                                // Generate QR Code for each resident
                                $ngrokUrl = 'https://daring-hen-mainly.ngrok-free.app';
                                $qrData = $ngrokUrl . '/fisherman-system/pages/resident/display_member.php?id=' . $row['id'];
                                $qrCode = new QrCode($qrData);
                                $writer = new PngWriter();
                                $qrCodeImage = $writer->write($qrCode);
                                $qrCodeBase64 = base64_encode($qrCodeImage->getString());

                                echo '<tr>';
        
                                    // Check if the user is not staff before showing the checkbox
                                    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
                                        echo '<td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['id'] . '" /></td>';
                                    }
                                    
                                    echo '
                                    <td>' . $row['zone'] . '</td>
                                    <td style="width:70px;"><img src="image/' . basename($row['image']) . '" style="width:60px;height:60px;"/></td>
                                    <td>' . $row['cname'] . '</td>
                                    <td>' . $row['age'] . '</td>
                                    <td>' . $row['type'] . '</td>
                                    <td>' . (empty($row['boat_number']) ? 'N/A' : $row['boat_number']) . '</td>
                                    <td>
                                        <button type="button" onclick="generatePdf(\'' . htmlspecialchars($qrData) . '\', \'' . $qrCodeBase64 . '\')" class="btn btn-pdf btn-sm">
    <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF
</button>

                                    </td>
                                    <td><button class="btn btn-secondary btn-sm" data-target="#editModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                                </tr>';
                                include "edit_modal.php";
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
                <?php include "../export_format.php"; ?>
                <?php include "../archive_notif.php"; ?>
                <?php include "../duplicate_error.php"; ?>
                <?php include "add_modal.php"; ?>

<?php include "function.php"; ?>
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
                        { "bSortable": false, "aTargets": [ 0, 7 ] }
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
