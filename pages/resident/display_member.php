<?php
session_start();
include "../connection.php"; // Include your database connection

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $memberId = intval($_GET['id']); // Sanitize the input
    $query = mysqli_query($con, "SELECT id, CONCAT(lname, ', ', fname, ' ', mname) AS cname, gender, age, bdate, hnumber, zone, barangay, cpnumber, image FROM tblresident WHERE id = '$memberId'");
    $member = mysqli_fetch_assoc($query);

    if ($member) {
        // Display the member's information in a two-column table
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Member Details</title>
            <link rel="icon" href="../../img/bfarmc-sinalhan-logo.png"> <!-- Adjusted path -->
            <link rel="stylesheet" href="path/to/your/bootstrap.css"> <!-- Adjust path as necessary -->
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                    max-width: 800px; /* Limit the max width for better readability */
                    margin: auto;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 20px; /* Add some space above the table */
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                img {
                    width: 60px;
                    height: 60px;
                    object-fit: cover; /* Maintain aspect ratio of the image */
                }
                @media print {
                    @page {
                        size: A4 portrait; /* Set the page size to A4 portrait */
                        margin: 0; /* Remove margins for printing */
                    }
                    body {
                        margin: 20mm; /* Add a margin for printed content */
                    }
                }
            </style>
        </head>
        <body>
            <h1>Member Details</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <td><?php echo $member['id']; ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?php echo $member['cname']; ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php echo $member['gender']; ?></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><?php echo $member['age'], " years old"; ?></td>
                </tr>
                <tr>
                    <th>Birthday</th>
                    <td><?php echo $member['bdate']; ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>
                        <?php 
                        // Concatenate address components
                        echo $member['hnumber'] . ", Purok " . $member['zone'] . ", " . $member['barangay']; 
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Contact No</th>
                    <td><?php echo $member['cpnumber']; ?></td>
                </tr>
                <tr>
                    <th>Image</th>
                    <td><img src="image/<?php echo basename($member['image']); ?>" alt="Member Image"></td>
                </tr>
            </table>
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
