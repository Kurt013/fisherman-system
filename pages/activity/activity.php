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
                    <a href="#" >
                <i class="fa fa-calendar"></i> <span>Activity</span>
                </a>                           
                 <?php 
                            // Check if the user role is not 'Staff' before displaying the delete button
                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                            ?>
                            <a href="../archive/archive_activity.php" class="redirect-button" style="color: #0605a6; float: right;">                           
                            <span class="icon"><i class="fa-solid fa-box-archive"></i></span>
                            <span class="tooltip-text">Archive List</span>
                        </a>
                        <?php
                            }
                            ?>                    </h1>
                    
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                            <div class="box">
                                <div class="box-header">
                                    <div style="padding:10px;">
                                        <?php 
                                            if(!isset($_SESSION['resident']))
                                            {
                                        ?>

                                                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal"><i class="fa fa-user-plus" aria-hidden="true"></i> Add Activity</button>  
                                                
                                                <?php 
                                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                                                ?>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#archiveModal"><i class="fa-solid fa-box-archive" aria-hidden="true"></i> Archive</button> 
                                                <?php
                                                    }
                                            }
                                                ?>

                                    <div style="text-align: right;">
                                        <button type="button" class="btn btn-third btn-sm" data-toggle="modal" data-target="#exportModal">
                                            <i class="fa fa-file-export" aria-hidden="true"></i> Export
                                        </button>
                                    </div>
                                
                                    </div>                                
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                <form method="post">
                                    <table id="table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                
                                            <?php 
                                                if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                                            ?>
                                            <th style="width: 20px !important;">
                                                <input type="checkbox" name="chk_delete[]" class="cbxMain" onchange="checkMain(this)"/>
                                            </th>
                                            <?php
                                                }
                                            ?>                                                <th>Image</th>
                                                <th>Date of Activity</th>
                                                <th>Activity</th>
                                                <th>Description</th>
                                                <th style="width: 140px !important;">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            

                                                $squery = mysqli_query($con, "select * from tblactivity WHERE archive = 0");
                                                if (mysqli_num_rows($squery) > 0) {
                                                while($row = mysqli_fetch_array($squery))
                                                {
                                                    echo '<tr>';
        
                                                    // Check if the user is not staff before showing the checkbox
                                                    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'staff') {
                                                        echo '<td><input type="checkbox" name="chk_delete[]" class="chk_delete" value="' . $row['id'] . '" /></td>';
                                                    }
                                                    
                                                    echo '
                                                        <td><img src="photo/' . $row['image'] . '" alt="Activity Image" style="width: 100px; height: auto;"/></td> <!-- Displaying photo -->
                                                        <td>'.$row['dateofactivity'].'</td>
                                                        <td>'.$row['activity'].'</td>
                                                        <td>'.$row['description'].'</td>
                                                        <td>
                                                            <button class="btn btn-secondary btn-sm" data-target="#editModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                                    ';

                                                    include "edit_modal.php";
                                                    include "view_modal.php";
                                                }
                                            } else {
                                                echo '<tr><td colspan="6" style="text-align: center; color: #999;">No activities found. Click "Add Activity" to create a new one.</td></tr>';
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
                            <?php include "../exportlist.php"; ?>


                            <?php include "../archive_notif.php"; ?>

                            <?php include "../duplicate_error.php"; ?>

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

var select_all = document.getElementById("cbxMainphoto"); //select all checkbox
var checkboxes = document.getElementsByClassName("chk_deletephoto"); //checkbox items

//select all checkboxes
select_all.addEventListener("change", function(e){
    for (i = 0; i < checkboxes.length; i++) { 
        checkboxes[i].checked = select_all.checked;
    }
});


for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function(e){ //".checkbox" change 
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(this.checked == false){
            select_all.checked = false;
        }
        //check "select all" if all checkbox items are checked
        if(document.querySelectorAll('.checkbox:checked').length == checkboxes.length){
            select_all.checked = true;
        }
    });
}

<?php 
    if ($_SESSION['role'] == "Administrator") { 
?>
        $(function() {
            $("#table").DataTable({
                "responsive": true,   // Enable responsiveness
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [ 0, 4 ] }  // Disable sorting for specific columns
                ],
                "aaSorting": [],
                "autoWidth": false      // Disable automatic column width calculation
            });
        });
<?php 
    } elseif (isset($_SESSION['resident'])) { 
?>
        $(function() {
            $("#table").DataTable({
                "responsive": true,   // Enable responsiveness
                "aoColumnDefs": [
                    { "bSortable": false }  // Disable sorting for all columns
                ],
                "aaSorting": [],
                "autoWidth": false      // Disable automatic column width calculation
            });
        });
<?php 
    } else { 
?>
        $(function() {
            $("#table").DataTable({
                "responsive": true,   // Enable responsiveness
                "aoColumnDefs": [
                    { "bSortable": false, "aTargets": [ 4 ] }  // Disable sorting for specific column
                ],
                "aaSorting": [],
                "autoWidth": false      // Disable automatic column width calculation
            });
        });
<?php 
    } 
?>


$(document).ready(function() {
    // Replace the "Previous" text with the backward icon
    $('div.dataTables_paginate ul.pagination li:first-child a').html('<i class="fa-solid fa-backward"></i>');

    // Replace the "Next" text with the forward icon
    $('div.dataTables_paginate ul.pagination li:last-child a').html('<i class="fa-solid fa-forward"></i>');
});

</script>
    </body>
</html>