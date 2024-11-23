<?php echo '<div id="editModal'.$row['id'].'" class="modal fade">
<form method="post">
  <div class="modal-dialog modal-sm" style="width:300px !important;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit Official</h4>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" value="'.$row['id'].'" name="hidden_id" id="hidden_id"/>
                <div class="form-group">
                    <label class="control-label">Positions:</label>
                    <select name="ddl_edit_pos" class="form-control input-sm" required>
                        <option selected="" disabled="">-- Select Positions -- </option>
                        <option value="President" '.($row['sPosition'] == 'President' ? 'selected' : '').'>President</option>
                        <option value="Vice President" '.($row['sPosition'] == 'Vice President' ? 'selected' : '').'>Vice President</option>
                        <option value="Secretary" '.($row['sPosition'] == 'Secretary' ? 'selected' : '').'>Secretary</option>
                        <option value="Treasurer" '.($row['sPosition'] == 'Treasurer' ? 'selected' : '').'>Treasurer</option>
                        <option value="Public Relations Officer" '.($row['sPosition'] == 'Public Relations Officer' ? 'selected' : '').'>Public Relations Officer</option>
                        <option value="Sergeant at Arms" '.($row['sPosition'] == 'Sergeant at Arms' ? 'selected' : '').'>Sergeant at Arms</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Name: <span style="color:gray; font-size: 10px;">(Lastname, Firstname, Middlename)</span></label>
                    <input name="txt_edit_cname" class="form-control input-sm" type="text" value="'.$row['completeName'].'"/>
                </div>
                <div class="form-group">
                    <label>Contact #: </label>
                    <input name="txt_edit_contact" class="form-control input-sm" type="text" value="'.$row['pcontact'].'" />
                </div>
                <div class="form-group">
                    <label>Address: </label>
                    <input name="txt_edit_address" class="form-control input-sm" type="text" value="'.$row['paddress'].'" />
                </div>
                <div class="form-group">
                    <label>Start Term: </label>
                    <input name="txt_edit_sterm" class="form-control input-sm" type="date" value="'.$row['termStart'].'" />
                </div>
                <div class="form-group">
                    <label>End Term: </label>
                    <input name="txt_edit_eterm" class="form-control input-sm" type="date" value="'.$row['termEnd'].'" />
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
</div>';?>