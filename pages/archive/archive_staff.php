<!DOCTYPE html>
<html>

    <?php
    session_start();
    if(!isset($_SESSION['role']))
    {
        header("Location: ../../login.php"); 
    }
    else
    {
    ob_start();
    include('../head_css.php'); ?>
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
                            <a href="../staff/staff.php" class="redirect-button" style="color: #0605a6; float:right;" >
                <i class="fa fa-user"></i>
                <span class="tooltip-text">Staff List</span>

                </a> 
                        </h1>
                    
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                            <div class="box">
                                <div class="box-header">
                                    <div style="padding:10px;">
                                        
                                        <?php 
                                            if(!isset($_SESSION['staff']))
                                            {
                                        ?>
                                        <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#unarchiveModal"><i class="fa fa-trash-o" aria-hidden="true"></i> Unarchive</button> 
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
                                                <th style="width: 20px !important;"><input type="checkbox" name="chk_unarchive[]" class="cbxMain" onchange="checkMain(this)"/></th>
                                                <?php
                                                    }
                                                ?>
                                                <th>Name</th>
                                                <th>Userame</th>
                                                <th style="width: 40px !important;">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(!isset($_SESSION['staff'])){
                                                $squery = mysqli_query($con, "select * from tbluser WHERE role = 'staff' AND archive = 1 ");
                                                while($row = mysqli_fetch_array($squery))
                                                {
                                                    echo '
                                                    <tr>
                                                        <td><input type="checkbox" name="chk_unarchive[]" class="chk_unarchive" value="'.$row['id'].'" /></td>
                                                        <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                                                        <td>'.$row['username'].'</td>
                                                        <td><button class="btn btn-secondary btn-sm" data-target="#editModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                                                    </tr>
                                                    ';

                                                    include "../staff/edit_modal.php";
                                                }
                                            }
                                            else{
                                                $squery = mysqli_query($con, "select * from tbluser WHERE role = 'staff' AND archive = 1");
                                                while($row = mysqli_fetch_array($squery))
                                                {
                                                    echo '
                                                    <tr>
                                                        <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                                                        <td>'.$row['username'].'</td>
                                                        <td><button class="btn btn-secondary btn-sm" data-target="#editModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></td>
                                                    </tr>
                                                    ';

                                                    include "../staff/edit_modal.php";
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>

                                    <?php include "../archiveModal.php"; ?>

                                    </form>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->

                            <?php include "../edit_notif.php"; ?>

                            <?php include "../added_notif.php"; ?>
                            <?php include "../mismatch_notif.php"; ?>
                            <?php include "../archive_notif.php"; ?>
                            <?php include "../duplicate_error.php"; ?>

            <?php include "../staff/add_modal.php"; ?>

            <?php include "../staff/function.php"; ?>


                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <!-- jQuery 2.0.2 -->
        <?php }
        include "../footer.php"; ?>
<script type="text/javascript">
    $(function() {
        $("#table").dataTable({
           "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0,3 ] } ],"aaSorting": []
        });
    });

    $(document).ready(function() {
    // Replace the "Previous" text with the backward icon
    $('div.dataTables_paginate ul.pagination li:first-child a').html('<i class="fa-solid fa-backward"></i>');

    // Replace the "Next" text with the forward icon
    $('div.dataTables_paginate ul.pagination li:last-child a').html('<i class="fa-solid fa-forward"></i>');
});
</script>
    </body>
</html>