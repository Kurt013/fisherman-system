<!DOCTYPE html>
<html>

<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: ../../login.php"); 
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
                <h1>Dashboard</h1>
            </section>
            <div class="box">
                                <div class="box-header">
                                    <div style="padding:10px;">
                                    <form action="export.php" method="post">
                                        <button class="btn btn-primary btn-sm" type="submit" name="export"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button>  
                                    </form>
                                    </div>                            
                                </div>
            <section class="content">
                <div class="row">
                    <div class="box">
                        <div class="col-md-3 col-sm-6 col-xs-12"><br>
                            <div class="info-box">
                                <a href="../household/household.php">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                                </a>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Officials</span>
                                    <span class="info-box-number">
                                        <?php
                                            $q = mysqli_query($con, "SELECT * from tblofficial");
                                            echo mysqli_num_rows($q);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12"><br>
                            <div class="info-box">
                                <a href="../resident/resident.php">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
                                </a>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Members</span>
                                    <span class="info-box-number">
                                        <?php
                                            $q = mysqli_query($con, "SELECT * from tblresident");
                                            echo mysqli_num_rows($q);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12"><br>
                            <div class="info-box">
                                <a href="../clearance/clearance.php">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-calendar"></i></span>
                                </a>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Activities</span>
                                    <span class="info-box-number">
                                        <?php
                                            $q = mysqli_query($con, "SELECT * from tblactivity");
                                            echo mysqli_num_rows($q);
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box -->
                </div> <!-- /.row -->

                <!-- Bar charts and Donut chart -->
                <div class="row">
                    <!-- Age Distribution Bar Chart -->
                    <div class="col-md-6 col-sm-12 col-xs-12">                     
                    <h4>Age Distribution of Members</h4>
                        <div id="morris-bar-chart2" style="height: 250px;"></div>
                    </div>

                    <!-- Members per Purok Bar Chart -->
                    <div class="col-md-6 col-sm-12 col-xs-12">                     
                    <h4>Members per Purok</h4>
                        <div id="morris-bar-chart3" style="height: 250px;"></div>
                    </div>
                </div>

                <!-- Gender Distribution Donut Chart -->
                <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">                     
                <h4>Gender Distribution of Members</h4>
                        <div id="morris-donut-chart" style="height: 250px;"></div>
                    </div>
                </div>
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
                        // Split the range into min and max
                        list($min_age, $max_age) = explode('-', $range);
                        // Query to count residents in the given age range
                        $qry = mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblresident WHERE age BETWEEN $min_age AND $max_age");
                        $row = mysqli_fetch_array($qry);
                        $count = $row['cnt'] ?? 0;
                        echo "{ y: '$range', a: $count },";
                    }
                ?>
            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Number of Residents'],
            hideHover: 'auto'
        });


        // Members per Purok Bar Chart
        Morris.Bar({
            element: 'morris-bar-chart3',
            data: [
                <?php
                    for ($purok = 1; $purok <= 6; $purok++) {
                        $qry = mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblresident WHERE zone = '$purok'");
                        $row = mysqli_fetch_array($qry);
                        $count = $row['cnt'] ?? 0;
                        echo "{ y: 'Purok $purok', a: $count },";
                    }
                ?>
            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Residents per Purok'],
            hideHover: 'auto',
            resize: true
        });

        // Gender Distribution Donut Chart
        Morris.Donut({
            element: 'morris-donut-chart',
            data: [
                <?php
                    $male_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblresident WHERE gender = 'Male'"))['cnt'];
                    $female_count = mysqli_fetch_array(mysqli_query($con, "SELECT COUNT(*) as cnt FROM tblresident WHERE gender = 'Female'"))['cnt'];
                    echo "{ label: 'Male', value: $male_count },";
                    echo "{ label: 'Female', value: $female_count }";
                ?>
            ],
            colors: ['#007bff', '#ff6384'],
            resize: true
        });
    </script>

    <?php include "../footer.php"; ?>
    <script type="text/javascript">
        $(function() {
            $("#table").dataTable({
               "aoColumnDefs": [{ "bSortable": false, "aTargets": [0, 5] }], "aaSorting": []
            });
        });
    </script>
</body>
</html>
<?php } ?>
