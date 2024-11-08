<!-- ========================= MODAL ======================= -->
            <div id="addCourseModal" class="modal fade">
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
              <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Manage Members</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="row">
                            <div class="container-fluid">
                                <div class="col-md-6 col-sm-12">

                                    
                                        <div class="form-group">
                                            <label class="control-label">Last Name:</label>
                                            <input name="txt_lname" class="form-control input-sm" type="text" placeholder="Lastname"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">First Name:</label>
                                            <input name="txt_fname" class="form-control input-sm col-sm-4" type="text" placeholder="Firstname"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Middle Name:</label>
                                            <input name="txt_mname" class="form-control input-sm col-sm-4" type="text" placeholder="Middlename"/>
                                        </div>
                                    <!--
                                    <div class="form-group">
                                        <label class="control-label">Age:</label>
                                        <input name="txt_age" class="form-control input-sm input-size" type="number" placeholder="Age"/>
                                    </div> -->

                                    <div class="form-group">     
                                        <label class="control-label">Purok:</label>
                                        <select name="txt_zone" class="form-control input-sm">
                                            <option selected="" disabled="">-Select Purok-</option>
                                            <option value="1">Purok 1</option>
                                            <option value="2">Purok 2</option>
                                            <option value="3">Purok 3</option>
                                            <option value="4">Purok 4</option>
                                            <option value="5">Purok 5</option>
                                            <option value="6">Purok 6</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Cellphone Number:</label>
                                        <input name="txt_cpnumber" class="form-control input-sm" type="number" placeholder="Cellphone Number:"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Image:</label>
                                        <input name="txt_image" class="form-control input-sm" type="file" />
                                    </div>
                                    
                                </div>

                                <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                        <label class="control-label">Birthdate:</label>
                                        <input name="txt_bdate" class="form-control input-sm input-size" type="date" placeholder="Birthdate"/>
                                    </div>
                                    <div class="form-group">     
                                        <label class="control-label">Gender:</label>
                                        <select name="ddl_gender" class="form-control input-sm">
                                            <option selected="" disabled="">-Select Gender-</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">House Number:</label>
                                        <input name="txt_hnumber" class="form-control input-sm input-size" type="text" placeholder="House Number"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Barangay:</label>
                                        <input name="txt_brgy" class="form-control input-sm input-size" type="text" placeholder="Barangay"/>
                                    </div>
                                    <div class="form-group">     
                                        <label class="control-label">Type:</label>
                                        <select name="ddl_type" class="form-control input-sm">
                                            <option selected="" disabled="">-Select Type-</option>
                                            <option value="Fisherman">Fisherman</option>
                                            <option value="Fish Vendor">Fish Vendor</option>
                                        </select>
                                    </div>
                            



                                </div>

                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default btn-sm" data-dismiss="modal" value="Cancel"/>
                        <input type="submit" class="btn btn-primary btn-sm" name="btn_add" id="btn_add" value="Add Member"/>
                    </div>
                </div>
              </div>
              </form>
            </div>

<script type="text/javascript">
    $(document).ready(function() {
 
        var timeOut = null; // this used for hold few seconds to made ajax request
 
        var loading_html = '<img src="../../img/ajax-loader.gif" style="height: 20px; width: 20px;"/>'; // just an loading image or we can put any texts here
 
        //when button is clicked
        $('#username').keyup(function(e){
 
            // when press the following key we need not to make any ajax request, you can customize it with your own way
            switch(e.keyCode)
            {
                //case 8:   //backspace
                case 9:     //tab
                case 13:    //enter
                case 16:    //shift
                case 17:    //ctrl
                case 18:    //alt
                case 19:    //pause/break
                case 20:    //caps lock
                case 27:    //escape
                case 33:    //page up
                case 34:    //page down
                case 35:    //end
                case 36:    //home
                case 37:    //left arrow
                case 38:    //up arrow
                case 39:    //right arrow
                case 40:    //down arrow
                case 45:    //insert
                //case 46:  //delete
                    return;
            }
            if (timeOut != null)
                clearTimeout(timeOut);
            timeOut = setTimeout(is_available, 500);  // delay delay ajax request for 1000 milliseconds
            $('#user_msg').html(loading_html); // adding the loading text or image
        });
  });
function is_available(){
    //get the username
    var username = $('#username').val();
 
    //make the ajax request to check is username available or not
    $.post("check_username.php", { username: username },
    function(result)
    {
        console.log(result);
        if(result != 0)
        {
            $('#user_msg').html('Not Available');
            document.getElementById("btn_add").disabled = true;
        }
        else
        {
            $('#user_msg').html('<span style="color:#006600;">Available</span>');
            document.getElementById("btn_add").disabled = false;
        }
    });
 
}
</script>