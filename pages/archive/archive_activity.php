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
                    <a href="../activity/activity.php" style="color: #0605a6; margin-right: 30px;" >
                <i class="fa fa-calendar"></i> <span>Activity</span>
                </a>                           
                 <?php 
                            // Check if the user role is not 'Staff' before displaying the delete button
                            if(isset($_SESSION['role']) && $_SESSION['role'] !== "staff") {
                            ?>
                            <a href="#" class="redirect-button" style="color: #0605a6; border-bottom: 2px solid yellow; /* Change color as needed */
    padding-bottom: 5px; 
    display: inline-block; ">                           
                            <span class="icon"><i class="fa-solid fa-box-archive"></i></span> <span> Archive List</span>
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

                                                
                                                <?php 
                                                    if(!isset($_SESSION['staff']))
                                                    {
                                                ?>
                                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#unarchiveModal"><i class="fa-solid fa-box-archive" aria-hidden="true"></i> Unrchive</button> 
                                                <?php
                                                    }
                                            }
                                                ?>
                                
                                    </div>                                
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                <form method="post">
                                    <table id="table" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                
                                                <th style="width: 20px !important;"><input type="checkbox" name="chk_unarchive[]" class="cbxMain" onchange="checkMain(this)"/></th>
                                                <th>Image</th>
                                                <th>Date of Activity</th>
                                                <th>Activity</th>
                                                <th>Description</th>
                                                <th style="width: 140px !important;">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            

                                                $squery = mysqli_query($con, "select * from tblactivity WHERE archive = 1");
                                                while($row = mysqli_fetch_array($squery))
                                                {
                                                    echo '
                                                    <tr>
                                                        <td><input type="checkbox" name="chk_unarchive[]" class="chk_unarchive" value="'.$row['id'].'" /></td>
                                                        <td><img src="photo/' . $row['image'] . '" alt="Activity Image" style="width: 100px; height: auto;"/></td> <!-- Displaying photo -->
                                                        <td>'.$row['dateofactivity'].'</td>
                                                        <td>'.$row['activity'].'</td>
                                                        <td>'.$row['description'].'</td>
                                                        <td>
                                                            <button class="btn btn-secondary btn-sm" data-target="#editModal'.$row['id'].'" data-toggle="modal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                                        </td>
                                                    </tr>
                                                    ';

                                                    include "../activity/edit_modal.php";
                                                    include "../activity/view_modal.php";
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

                            <?php include "../archive_notif.php"; ?>

                            <?php include "../duplicate_error.php"; ?>

            <?php include "../activity/add_modal.php"; ?>

            <?php include "../activity/function.php"; ?>


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
    if($_SESSION['role'] == "Administrator")
    {
    ?>
        $(function() {
            $("#table").dataTable({
               "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 0,4 ] } ],"aaSorting": []
            });
            $(".select2").select2();
        });
    <?php
    }
    elseif(isset($_SESSION['resident']))
    {
    ?>
        $(function() {
            $("#table").dataTable({
               "aoColumnDefs": [ { "bSortable": false } ],"aaSorting": []
            });
            $(".select2").select2();
        });
    <?php
    }
    else{
    ?>
        $(function() {
            $("#table").dataTable({
               "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 4 ] } ],"aaSorting": []
            });
            $(".select2").select2();
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