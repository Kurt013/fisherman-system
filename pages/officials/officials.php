<!DOCTYPE html>
<html>

    <?php
    session_start();
    if(!isset($_SESSION['role']))
    {
        header("Location: ../../index.php"); 
    }
    else
    {
    ob_start();
    include('../head_css.php'); ?>

    <head>
    <title>BFARMC - Sinalhan</title>
    <link rel="icon" href="img\bfarmc-sinalhan-logo.png">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <?php 
        
        include "../connection.php";
        ?>
        <?php include('../header.php'); ?>

        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <?php include('../sidebar-left.php'); ?>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                <h1>
                <a href="#" style="color: #0605a6;  border-bottom: 2px solid yellow; /* Change color as needed */
    padding-bottom: 5px; 
    display: inline-block; margin-right: 30px;" >
                <i class="fa fa-user"></i> <span>Officer</span>
                </a>                           
                 <?php 
                            // Check if the user role is not 'Staff' before displaying the delete button
                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                            ?>
                            <a href="../archive/archive_official.php" class="redirect-button" style="color:#0605a6;">                           
                            <span class="icon"><i class="fa-solid fa-box-archive"></i></span> <span> Archive List</span>
                        </a>
                        <?php
                            }
                            ?>
            </h1>
                    
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                            <div class="box">
                                <div class="box-header">
                                    <div style="padding:10px;">
                                        
                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addCourseModal"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Officers</button>  

                                        <?php 
                                            // Check if the user role is not 'Staff' before displaying the delete button
                                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                                            ?>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#archiveModal"><i class="fa-solid fa-box-archive" aria-hidden="false"></i> Archive</button> 
                                            <?php
                                            }
                                            ?>
                                
                                    </div>                                
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                <form method="post">
                                    <table id="table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <?php 
                                                    if(!isset($_SESSION['staff']))
                                                    {
                                                ?>
                                                <th style="width: 20px !important;"><input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)"/></th>
                                                <?php
                                                    }
                                                ?>
                                                <th>Position</th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Address</th>
                                                <th>Start of Term</th>
                                                <th>End of Term</th>
                                                <th style="width: 130px !important;">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(!isset($_SESSION['staff']))
                                                {

                                                    $squery = mysqli_query($con, "SELECT * FROM tblofficial WHERE archive = 0 GROUP BY termend");
                                                    while($row = mysqli_fetch_array($squery))
                                                    {
                                                        echo '
                                                        <tr>
                                                            <td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="'.$row['id'].'" /></td>
                                                            <td>'.$row['sPosition'].'</td>
                                                            <td>'.$row['completeName'].'</td>
                                                            <td>'.$row['pcontact'].'</td>
                                                            <td>'.$row['paddress'].'</td>
                                                            <td>'.$row['termStart'].'</td>
                                                            <td>'.$row['termEnd'].'</td>
                                                            <td>
                                                                <button class="btn btn-primary btn-sm" data-target="#editModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>';
                                                                if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                                                                    if($row['status'] == 'Ongoing Term') {
                                                                        echo '<button class="btn btn-danger btn-sm" data-target="#endModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-minus-circle" aria-hidden="true"></i> End</button>';
                                                                    } else {
                                                                        echo '<button class="btn btn-success btn-sm" data-target="#startModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-minus-circle" aria-hidden="true"></i> Continue</button>';
                                                                    }
                                                                } else {
                                                                    // If the user is 'Staff', show only the Edit button and the Start button if applicable
                                                                    if ($row['status'] !== 'Ongoing Term') {
                                                                        echo '<button class="btn btn-success btn-sm" data-target="#startModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-minus-circle" aria-hidden="true"></i> Continue</button>';
                                                                    }
                                                                }
                                                                
                                                            echo '</td>
                                                        
                                                        </tr>
                                                        ';

                                                        include "edit_modal.php";
                                                        include "endterm_modal.php";
                                                        include "startterm_modal.php";
                                                    }

                                                }
                                                else{
                                                    $squery = mysqli_query($con, "SELECT * FROM tblofficial WHERE status = 'Ongoing Term' AND archive = 0 GROUP BY termend");
                                                    while($row = mysqli_fetch_array($squery))
                                                    {
                                                        echo '
                                                        <tr>
                                                            <td>'.$row['sPosition'].'</td>
                                                            <td>'.$row['completeName'].'</td>
                                                            <td>'.$row['pcontact'].'</td>
                                                            <td>'.$row['paddress'].'</td>
                                                            <td>'.$row['termStart'].'</td>
                                                            <td>'.$row['termEnd'].'</td>
                                                            <td>
                                                            <button class="btn btn-primary btn-sm" data-target="#editModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                            </td>
                                                        </tr>
                                                        ';

                                                        include "edit_modal.php";
                                                    }
                                                }
                                            ?>
                                        </tbody>
                                    </table>

                                    <?php include "../archiveModal.php"; ?>

                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <?php include "../duplicate_error.php"; ?>
                            <?php include "../edit_notif.php"; ?>

                            <?php include "../added_notif.php"; ?>

                            <?php include "../archive_notif.php"; ?>

            <?php include "add_modal.php"; ?>

            <?php include "function.php"; ?>


                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <?php }
        include "../footer.php"; ?>
       
        
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

        $(document).ready(function() {
    // Replace the "Previous" text with the backward icon
    $('div.dataTables_paginate ul.pagination li:first-child a').html('<i class="fa-solid fa-backward"></i>');

    // Replace the "Next" text with the forward icon
    $('div.dataTables_paginate ul.pagination li:last-child a').html('<i class="fa-solid fa-forward"></i>');
});
        </script>
    </body>
</html>