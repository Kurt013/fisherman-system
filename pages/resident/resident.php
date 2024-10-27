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
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Include the database connection
    include "../connection.php"; // Ensure this file sets $con properly

    if (isset($_POST['btn_delete'])) {
        // Handle the delete action
        if (!empty($_POST['chk_delete'])) {
            $idsToDelete = implode(',', $_POST['chk_delete']);
            $deleteQuery = "DELETE FROM tblresident WHERE id IN ($idsToDelete)";
            mysqli_query($con, $deleteQuery);
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
        $memberId = explode(': ', $qrData)[1]; // Extract the ID from qrData
        $query = mysqli_query($con, "SELECT id, CONCAT(lname, ', ', fname, ' ', mname) AS cname, age, CONCAT(zone, ', ', barangay) as address, cpnumber, image FROM tblresident WHERE id = '$memberId'");
        $row = mysqli_fetch_assoc($query);

        // Create a new PDF document
        $pdf = new FPDF('L', 'mm', [266, 179]); // Landscape orientation with short bond paper size (8.5 x 11 inches)
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(false);

        // Set colors for header and footer
        

        // Logo and Title
        $pdf->SetXY(10, 3);
        $pdf->Image('C:\xampp\htdocs\fisherman-system\img\bg-id.png', 0, 0, 270, 180); // Adjust the logo path and size
        $pdf->SetFont('Arial', 'B', 12);
        
        // Member Image
        $pdf->SetDrawColor(6, 5, 166); // Set border color
        $pdf->SetLineWidth(1.1); // Adjust this value for thickness

        // Draw a border rectangle around the image
        $pdf->Rect(10, 60, 80, 80); // Draw border
        if ($row['image']) {
            $pdf->Image('image/' . basename($row['image']), 11, 63, 78, 77); // Adjust the member image path
        } else {
            $pdf->SetXY(10, 30);
            $pdf->SetFont('Arial', 'I', 8);
            $pdf->SetTextColor(128, 128, 128); // Gray text color
            $pdf->Cell(30, 10, 'IMAGE', 0, 2, 'C');
            $pdf->Cell(30, 10, 'UNAVAILABLE', 0, 2, 'C');
        }

        // Member Details
        $pdf->SetFont('Helvetica', 'B', 25);
        $pdf->SetXY(100, 40);
        $pdf->Cell(0, 100, '' . $row['cname'], 0, 1);
        $pdf->SetFont('Helvetica', 'B', 20);
        $pdf->SetXY(107, 47);
        $pdf->Cell(0, 120, 'Age                          : ' . $row['age'], 0, 1);
        $pdf->SetXY(107, 58);
        $pdf->Cell(0, 120, 'Purok                       : ' . $row['address'], 0, 1);
        $pdf->SetXY(107, 68);
        $pdf->Cell(0, 120, 'Contact No              : ' . $row['cpnumber'], 0, 1);

        // QR Code
        $pdf->Image($tempImageFile, 212, 72, 40, 40); // QR Code

        // Clean output buffer before sending PDF
        ob_end_clean();
        // Output the PDF as a file download
        $pdf->Output('I', 'qr_code.pdf'); // Inline display
        unlink($tempImageFile); // Clean up temporary image file
        exit; // Stop further execution
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
            <h1>Members</h1>
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
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash-o" aria-hidden="false"></i> Delete</button> 
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
                                                <input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)"/>
                                            </th>
                                        <?php } ?>
                                        <th>Purok</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Cellphone Number</th>
                                        <th>ID Card</th>
                                        <th style="width: 40px !important;">Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                            <?php
                            $squery = mysqli_query($con, "SELECT zone, id, CONCAT(lname, ', ', fname, ' ', mname) AS cname, age, gender, cpnumber, image FROM tblresident ORDER BY zone");
                            while ($row = mysqli_fetch_array($squery)) {
                                // Generate QR Code for each resident
                                $qrData = 'Member ID: ' . $row['id'] . ', Name: ' . $row['cname'];
                                $qrCode = new QrCode($qrData);
                                $writer = new PngWriter();
                                $qrCodeImage = $writer->write($qrCode);
                                $qrCodeBase64 = base64_encode($qrCodeImage->getString());

                                echo '
                                <tr>
                                    <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['id'] . '" /></td>
                                    <td>' . $row['zone'] . '</td>
                                    <td style="width:70px;"><img src="image/' . basename($row['image']) . '" style="width:60px;height:60px;"/></td>
                                    <td>' . $row['cname'] . '</td>
                                    <td>' . $row['age'] . '</td>
                                    <td>' . $row['gender'] . '</td>
                                    <td>' . $row['cpnumber'] . '</td>
                                    <td>
                                        <form method="post" enctype="multipart/form-data" style="display:inline;">
                                            <input type="hidden" name="qr_data" value="' . htmlspecialchars($qrData) . '"/>
                                            <input type="hidden" name="image_data" value="' . $qrCodeBase64 . '"/>
                                            <button type="submit" name="generate_pdf" class="btn btn-info btn-sm">
                                                <i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF
                                            </button>
                                        </form>
                                    </td>
                                    <td><button class="btn btn-primary btn-sm" data-target="#editModal' . $row['id'] . '" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></td>
                                </tr>';
                                include "edit_modal.php";
                            }
                            ?>
</tbody>

                            </table>
                            <?php include "../deleteModal.php"; ?>
                            
                        </form>

                    </div>
                </div>
                <?php include "../edit_notif.php"; ?>
                <?php include "../added_notif.php"; ?>
                <?php include "../delete_notif.php"; ?>
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
</body>
</html>
