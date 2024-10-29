<?php
if (isset($_POST['export'])) {
    include "../connection.php";

    // Updated SQL queries to match the dashboard data
    $SQL1 = "SELECT COUNT(*) AS NumberofOfficial FROM tblofficial"; // Total Officials
    $SQL2 = "SELECT COUNT(*) AS NumberofMembers FROM tblresident"; // Total Residents per Zone
    $SQL3 = "SELECT COUNT(*) AS NumberofActivities FROM tblactivity"; // Total Activities
    $SQL4 = "SELECT COUNT(*) AS NumberofMembers, Zone FROM tblresident GROUP BY Zone"; // Total Residents per Zone
    $SQL5 = "SELECT COUNT(*) AS NumberofMembers, Age FROM tblresident GROUP BY Age"; // Total Residents by Age
    $SQL6 = "SELECT COUNT(*) AS NumberofMembers, Gender FROM tblresident GROUP BY Gender"; // Total Residents by Age

    $arrsql = array($SQL1, $SQL2, $SQL3, $SQL4, $SQL5, $SQL6);
    $arrhead = array("Total Officials", "Total Members", "Total Activities", "Population per Purok", "Members by Age", "Members by Gender");

    $output = '';

    // Loop through the SQL queries and prepare the export data
    foreach (array_combine($arrsql, $arrhead) as $query => $header) {
        $output .= "$header\n";
        $result = mysqli_query($con, $query);
        
        if ($result) {
            $fields = mysqli_num_fields($result);

            // Fetching the header fields
            $headerRow = '';
            while ($field = mysqli_fetch_field($result)) {
                $headerRow .= '"' . $field->name . '"' . "\t";
            }
            $output .= trim($headerRow) . "\n";

            // Fetching data rows
            while ($row = mysqli_fetch_row($result)) {
                $line = '';
                foreach ($row as $value) {
                    if (!isset($value) || $value == "") {
                        $value = "\t";
                    } else {
                        $value = str_replace('"', '""', $value);
                        $value = '"' . $value . '"' . "\t";
                    }
                    $line .= $value;
                }
                $output .= trim($line) . "\n";
            }
        } else {
            $output .= "\nNo Record(s) Found!\n";                        
        }

        // Separate each query output with a newline
        $output .= "\n";
    }

    // Prepare the Excel download
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=export.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo "$output";
    exit;
}
?>
