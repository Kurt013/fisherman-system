<?php
// Fetch data for the edit modal
$edit_query = mysqli_query($con, "SELECT * FROM tbluser WHERE id = '" . $row['id'] . "' ");
$erow = mysqli_fetch_array($edit_query);

echo '
<div id="editModal' . $row['id'] . '" class="modal fade">
  <form method="post">
    <div class="modal-dialog modal-sm" style="width:300px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Edit Staff</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <input type="hidden" value="' . $row['id'] . '" name="hidden_id" id="hidden_id"/>
              <div class="form-group">
                <label>First Name:</label>
                <input name="txt_fname" class="form-control input-sm" type="text" value="' . $erow['first_name'] . '" />
              </div>
              <div class="form-group">
                <label>Last Name:</label>
                <input name="txt_lname" class="form-control input-sm" type="text" value="' . $erow['last_name'] . '" />
              </div>
              <div class="form-group">
                <label>Email:</label>
                <input name="txt_email" class="form-control input-sm" type="text" value="' . $erow['email'] . '" />
              </div>
              <div class="form-group">
                <label>Username:</label>
                <input name="txt_uname" class="form-control input-sm" id="username" type="text" value="' . $erow['username'] . '" />
                <label id="user_msg" style="color:#CC0000;"></label>
              </div>
              <div class="form-group">
                <label>New Password:</label>
                <input name="txt_pass" class="form-control input-sm" type="password" placeholder="*******"/>
              </div>
              <div class="form-group">
                <label>Confirm Password:</label>
                <input name="txt_cpass" class="form-control input-sm" type="password" placeholder="*******"/>
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
