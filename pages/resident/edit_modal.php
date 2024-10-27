<?php 
echo '<div id="editModal'.$row['id'].'" class="modal fade">
<form class="form-horizontal" method="post" enctype="multipart/form-data">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit Member Information</h4>
        </div>
        <div class="modal-body">';

        $edit_query = mysqli_query($con,"SELECT * from tblresident where id = '".$row['id']."' ");
        
        $erow = mysqli_fetch_array($edit_query);

        echo '
            <div class="row">
                <div class="container-fluid">
                    <div class="col-md-6 col-sm-12">
                        <input type="hidden" value="'.$erow['id'].'" name="hidden_id" id="hidden_id"/>
                        <div class="form-group">
                            <label class="control-label">Last Name:</label>
                            <input name="txt_edit_lname" class="form-control input-sm" type="text" value="'.$erow['lname'].'"/>
                        </div> 
                        <div class="form-group">
                            <label class="control-label">First Name:</label>
                            <input name="txt_edit_fname" class="form-control input-sm" type="text" value="'.$erow['fname'].'"/>
                        </div> 
                        <div class="form-group">
                            <label class="control-label">Middle Name:</label>
                            <input name="txt_edit_mname" class="form-control input-sm" type="text" value="'.$erow['mname'].'"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Purok #:</label>
                            <input name="txt_edit_zone" class="form-control input-sm" type="text" value="'.$erow['zone'].'"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Cellphone Number:</label>
                            <input name="txt_edit_cpnumber" class="form-control input-sm" type="text" value="'.$erow['cpnumber'].'"/>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Birthdate:</label>
                            <input name="txt_edit_bdate" class="form-control input-sm" type="date" value="'.$erow['bdate'].'"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Gender:</label>
                            <select name="ddl_edit_gender" class="form-control input-sm">
                                <option value="'.$erow['gender'].'" selected="">'.$erow['gender'].'</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">House Number:</label>
                            <input name="txt_edit_hnumber" class="form-control input-sm" type="text" value="'.$erow['hnumber'].'"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Barangay:</label>
                            <input name="txt_edit_brgy" class="form-control input-sm" type="text" value="'.$erow['barangay'].'"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Image:</label>
                            <input name="txt_edit_image" class="form-control input-sm" type="file" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
            <input type="submit" class="btn btn-primary btn-sm" name="btn_save" value="Save"/>
        </div>
    </div>
  </div>
</form>
</div>';

?>

