<!DOCTYPE html>
<html>

<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: ../../index.php"); 
} else {
    ob_start();
    include('../head_css.php'); 
?>
<body class="skin-blue">
    <?php include "../connection.php"; ?>
    <?php include('../header.php'); ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php include('../sidebar-left.php'); ?>

        <aside class="right-side">
            <section class="content-header">
                <h1><i class="fa fa-dashboard"></i> <span>Dashboard</span></h1>
            </section>
            <div class="main-content">
            <div class="box">
                                <div class="box-header">
                                    <div style="padding:10px; text-align:right;">
                                    <button type="button" class="btn btn-third btn-sm" data-toggle="modal" data-target="#reportModal">
                                    <i class="fa-solid fa-file-export" aria-hidden="true"></i> Export
    </button>
                                    </div>                            
                                </div>
            <section class="content">
                <div class="row">
                    <div class="box">
                        <div class="col-md-4 col-sm-6 col-xs-12"><br>
                            <div class="info-box">
                            <a href="../resident/resident.php">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                                </a>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Members</span>
                                    <span class="info-box-number">
                                        <?php
                                            $q = mysqli_query($con, "SELECT * from tblresident  WHERE archive = 0");
                                            echo mysqli_num_rows($q);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12"><br>
                            <div class="info-box">
                                <a href="../resident/resident.php">
                                    <span class="info-box-icon bg-aqua"><i class="fa-solid fa-sailboat"></i></span>
                                </a>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Registered Boat</span>
                                    <span class="info-box-number">
                                        <?php
                                            // Correct the query to use proper quotes for 'Yes'
                                            $q = mysqli_query($con, "SELECT * FROM tblresident WHERE has_boat = 'Yes' AND archive = 0");
                                            echo mysqli_num_rows($q); // Count the rows returned by the query
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-12"><br>
                            <div class="info-box">
                                <a href="../activity/activity.php">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
                                </a>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Activities</span>
                                    <span class="info-box-number">
                                        <?php
                                            $q = mysqli_query($con, "SELECT * from tblactivity WHERE archive = 0");
                                            echo mysqli_num_rows($q);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div> <!-- /.row -->

                <!-- Bar charts and Donut chart -->
                <div class="row justify-content-center">
    <!-- Age Distribution Bar Chart -->
    <div class="col-md-4 col-sm-6 col-xs-12 d-flex justify-content-center">
        <div class="info-box" style="padding: 10px; height:400px;">
            <h4 class="info-box-text" style= "text-align: center;">Age Distribution of Members</h4>
            <div id="morris-bar-chart2" style="height: 340px; display: flex; justify-content: center; align-items: center;"></div>
        </div>
    </div>
    <!-- Types of Members Donut Chart -->
    <div class="col-md-4 col-sm-6 col-xs-12 d-flex justify-content-center">
        <div class="info-box" style="padding: 10px; height:400px;">
            <h4 class="info-box-text" style= "text-align: center;">Types of Members</h4>
            <div id="morris-donut-chart" style="height: 340px; display: flex; justify-content: center; align-items: center;"></div>
        </div>
    </div>
    <!-- Members per Purok Bar Chart -->
    <div class="col-md-4 col-sm-6 col-xs-12 d-flex justify-content-center">
        <div class="info-box" style="padding: 10px; height:400px;">
            <h4 class="info-box-text" style= "text-align: center;">Members per Purok</h4>
            <div id="morris-bar-chart3" style="height: 340px; display: flex; justify-content: center; align-items: center;"></div>
        </div>
    </div>
</div>
<?php include "../report_format.php"; ?>




            </section>
        </aside>
    </div>

    <!-- jQuery and Morris.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.3.0/raphael.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    // Age Distribution Bar Chart
    Morris.Bar({
        element: 'morris-bar-chart2',
        data: [
            <?php
                $age_ranges = [
                    "0-9", "10-19", "20-29", "30-39", "40-49", 
                    "50-59", "60-69", "70-79", "80-89", "90-99"
                ];

                foreach ($age_ranges as $range) {
                    list($min_age, $max_age) = explode('-', $range);
                    $qry = mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblresident WHERE archive = 0 AND age BETWEEN $min_age AND $max_age");
                    $row = mysqli_fetch_array($qry);
                    $count = $row['cnt'] ?? 0;
                    echo "{ y: '$range', a: $count },"; 
                }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Number of Members'],
        barColors: ['#FFDE59'], // Set bar color
        lineColors: ['#000'], // Set line color to black
        hideHover: 'auto',
        labelColor: '#0605a6', // Set label color to black
        gridTextColor: '#000', // Set grid text color to black
        hoverCallback: function (index, options, content, row) {
        return content.replace(row.a, '<span style="color: #0605a6;">' + row.a + '</span>')
                      .replace('Number of Members', '<span style="color: #0605a6;">Number of Members</span>');
    }
    });

    $(document).ready(function() {
    // jQuery to apply hover effect on labels and grid text in the bar chart
    $('#morris-bar-chart2').hover(
        function() {
            // On hover, change the label color to #FFDE59
            $('#morris-bar-chart2 text').css('fill', '#FFDE59'); // Change both labels and grid text to hover color
        },
        function() {
            // On mouse leave, revert to original color
            $('#morris-bar-chart2 text').css('fill', '#0605a6'); // Revert back to original color for labels
            $('.morris-grid-labels text').css('fill', '#000'); // Revert grid text to original color
        }
    );
});


    // Members per Purok Bar Chart
    Morris.Bar({
        element: 'morris-bar-chart3',
        data: [
            <?php
                for ($purok = 1; $purok <= 6; $purok++) {
                    $qry = mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblresident WHERE archive = 0 AND zone = '$purok'");
                    $row = mysqli_fetch_array($qry);
                    $count = $row['cnt'] ?? 0;
                    echo "{ y: 'Purok $purok', a: $count },"; 
                }
            ?>
        ],
        xkey: 'y',
        ykeys: ['a'],
        labels: ['Members per Purok'],
        barColors: ['#FFDE59'], // Set bar color
        lineColors: ['#000'], // Set line color to black
        hideHover: 'auto',
        labelColor: '#0605a6', // Set label color to black
        gridTextColor: '#000', // Set grid text color to black
        resize: true,
        hoverCallback: function (index, options, content, row) {
        // Change the hover content to have the number in blue, while label stays black
        content = content.replace(row.a, '<span style="color: #0605a6;">' + row.a + '</span>'); 
        content = content.replace('Members per Purok', '<span style="color: #0605a6;">Members per Purok</span>'); 
        return content;
    }
    });

    $(document).ready(function() {
    // jQuery to apply hover effect on labels and grid text in the bar chart
    $('#morris-bar-chart3').hover(
        function() {
            // On hover, change the label color to #FFDE59
            $('#morris-bar-chart3 text').css('fill', '#FFDE59'); // Change both labels and grid text to hover color
        },
        function() {
            // On mouse leave, revert to original color
            $('#morris-bar-chart3 text').css('fill', '#0605a6'); // Revert back to original color for labels
            $('.morris-grid-labels text').css('fill', '#000'); // Revert grid text to original color
        }
    );
});



    // Gender Distribution Donut Chart
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
            <?php
                $f_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblresident WHERE archive = 0 AND type = 'Fisherman'"))['cnt'];
                $fv_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblresident WHERE archive = 0 AND type = 'Fish Vendor'"))['cnt'];
                echo "{ label: 'Fisherman', value: $f_count },"; 
                echo "{ label: 'Fish Vendor', value: $fv_count }"; 
            ?>
        ],
        colors: ['#FFDE59', '#0605a6'],
        labelColor: '#0605a6', // Set label color to black for visibility
        resize: true
    });

    // jQuery to apply hover effect on labels
$('#morris-donut-chart').hover(
    function() {
        // On hover, change the label color
        $('#morris-donut-chart text').css('fill', '#FFDE59'); // Hover color
    }, 
    function() {
        // On mouse leave, revert to original color
        $('#morris-donut-chart text').css('fill', '#0605a6'); // Original color
    }
);
</script>



    <?php include "../footer.php"; ?>
    <script type="text/javascript">
        $(function() {
            $("#table").dataTable({
               "aoColumnDefs": [{ "bSortable": false, "aTargets": [0, 5] }], "aaSorting": []
            });
        });
    </script>
    </div>
</body>
</html>
<?php } ?>
