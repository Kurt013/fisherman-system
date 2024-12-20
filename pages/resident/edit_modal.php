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
                            <label class="control-label">Purok:</label>
                            <select name="txt_edit_zone" class="form-control input-sm">
                                <option disabled="">-Select Purok-</option>';
                                for ($i = 1; $i <= 6; $i++) {
                                    $selected = ($erow['zone'] == $i) ? 'selected' : '';
                                    echo '<option value="'.$i.'" '.$selected.'>Purok '.$i.'</option>';
                                }
                        echo '</select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Cellphone Number:</label>
                            <input name="txt_edit_cpnumber" class="form-control input-sm" type="text" value="'.$erow['cpnumber'].'"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Image:</label>
                            <input name="txt_edit_image" class="form-control input-sm" type="file" />
                        </div>
                         <div id="edit_boat_number'.$row['id'].'" style="display: none;">
                            <div class="form-group">
                                <label class="control-label">Registered Boat Number:</label>
                                <input name="edit_boat_number" class="form-control input-sm" type="text" value="'.$erow['boat_number'].'" placeholder="Boat Number" />
                            </div>
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
                                <option value="Male" '.($erow['gender'] == 'Male' ? 'selected' : '').'>Male</option>
                                <option value="Female" '.($erow['gender'] == 'Female' ? 'selected' : '').'>Female</option>
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
                            <label class="control-label">Type:</label>
                            <select id="ddl-edit-type'.$row['id'].'" name="ddl_edit_type" class="form-control input-sm">
                                <option disabled="">-Select Type-</option>
                                <option value="Fisherman" '.($erow['type'] == 'Fisherman' ? 'selected' : '').'>Fisherman</option>
                                <option value="Fish Vendor" '.($erow['type'] == 'Fish Vendor' ? 'selected' : '').'>Fish Vendor</option>
                            </select>
                        </div>
                        <div id="edit_has_boat_field'.$row['id'].'" class="form-group" style="display: none;">
                            <label class="control-label">Has Registered Boat?</label>
                            <select id="edit_has_boat'.$row['id'].'" name="edit_has_boat" class="form-control input-sm">
                                <option selected="" disabled="">-Select Option-</option>
                                <option value="Yes" '.($erow['has_boat'] == 'Yes' ? 'selected' : '').'>Yes</option>
                                <option value="No" '.($erow['has_boat'] == 'No' ? 'selected' : '').'>No</option>
                            </select>
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

echo '<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function () {
    const typeField = document.getElementById("ddl-edit-type'.$row['id'].'");
    const hasBoatField = document.getElementById("edit_has_boat_field'.$row['id'].'");
    const hasBoat = document.getElementById("edit_has_boat'.$row['id'].'");
    const boatNumberField = document.getElementById("edit_boat_number'.$row['id'].'");

    // Initialize fields based on current values
    if (typeField.value === "Fisherman") {
        hasBoatField.style.display = "block";
    }

    if (hasBoat.value === "Yes") {
        boatNumberField.style.display = "block";
    }

    // Add event listeners for changes
    typeField.addEventListener("change", function () {
        if (typeField.value === "Fisherman") {
            hasBoatField.style.display = "block";
        } else {
            hasBoatField.style.display = "none";
            boatNumberField.style.display = "none";
            hasBoat.value = ""; // Reset selection
        }
    });

    hasBoat.addEventListener("change", function () {
        if (hasBoat.value === "Yes") {
            boatNumberField.style.display = "block";
        } else {
            boatNumberField.style.display = "none";
        }
    });
});
</script>';
?>
