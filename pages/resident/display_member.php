<?php
session_start();
include "../connection.php"; // Include your database connection

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $memberId = intval($_GET['id']); // Sanitize the input
    $query = mysqli_query($con, "SELECT id, CONCAT(lname, ', ', fname, ' ', mname) AS cname, gender, age, bdate, hnumber, zone, barangay, type, cpnumber, image FROM tblresident WHERE id = '$memberId'");
    $member = mysqli_fetch_assoc($query);

    if ($member) {
        // Display the member's information in a two-column table
        ?>
        <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Member Details</title>
        <link rel="icon" href="../../img/bfarmc-sinalhan-logo.png"> <!-- Adjusted path -->
        <link href="../../css/display_member.css" rel="stylesheet" type="text/css" />
        <style>
            /* Insert the CSS code here */
        </style>
    </head>
    <body>
    <div class="container">
    <div class="header">
    <h1 class="left">Member Details</h1>
    <img src="../../img/bfarmc-sinalhan-logo.png" alt="Logo" class="logo">
    <h1 class="right">BFARMC - Sinalhan</h1>
</div>

        <div class="member-info">
                <img src="image/<?php echo htmlspecialchars($member['image']); ?>" alt="Member Image">
                <div class="info-details">
                    <h1><?php echo htmlspecialchars($member['cname']); ?></h1>
                    <h2><?php echo htmlspecialchars($member['type']); ?></h2>
                    <p><span class="label">ID:</span> <span class="value"><?php echo htmlspecialchars($member['id']); ?></span></p>
                    <p><span class="label">Gender:</span> <span class="value"><?php echo htmlspecialchars($member['gender']); ?></span></p>
                    <p><span class="label">Age:</span> <span class="value"><?php echo htmlspecialchars($member['age']) . " years old"; ?></span></p>
                    <p><span class="label">Birthday:</span> <span class="value"><?php echo htmlspecialchars($member['bdate']); ?></span></p>
                    <p><span class="label">Address:</span> <span class="value"><?php echo htmlspecialchars($member['hnumber'] . ", Purok " . $member['zone'] . ", " . $member['barangay']); ?></span></p>
                    <p><span class="label">Contact No:</span> <span class="value"><?php echo htmlspecialchars($member['cpnumber']); ?></span></p>

                </div>
            </div>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "Member not found.";
    }
} else {
    echo "No member ID provided.";
}
?>