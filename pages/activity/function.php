<?php
if(isset($_POST['btn_add'])){
    $txt_doc = $_POST['txt_doc'];
    $txt_act = $_POST['txt_act'];
    $txt_desc = $_POST['txt_desc'];

    if(isset($_SESSION['role'])){
        $action = 'Added Activity '.$txt_act;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user, logdate, action) values ('".$_SESSION['role']."', NOW(), '".$action."')");
    }

    // Handle the file upload
    $image_name = '';
    if(isset($_FILES['files'])) {
        $tmp_name = $_FILES['files']['tmp_name'][0]; // Assuming one file upload
        if ($tmp_name) {
            $target = "photo/";
            $milliseconds = round(microtime(true) * 1000);
            $image_name = $milliseconds . $_FILES['files']['name'][0];
            $target .= $image_name;

            if(!move_uploaded_file($tmp_name, $target)){
                die('Error uploading file');
            }
        }
    }

    // Insert the activity along with the image
    $query = mysqli_query($con,"INSERT INTO tblactivity (dateofactivity, activity, description, image) 
        VALUES ('$txt_doc', '$txt_act', '$txt_desc', '$image_name')") or die('Error: ' . mysqli_error($con));

    if($query == true) {
        $_SESSION['added'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['btn_save'])) {
    $txt_id = $_POST['hidden_id'];
    $txt_edit_doc = $_POST['txt_edit_doc'];
    $txt_edit_act = $_POST['txt_edit_act'];
    $txt_edit_desc = $_POST['txt_edit_desc'];

    // Update the activity details
    $update_query = mysqli_query($con,"UPDATE tblactivity 
        SET dateofactivity = '".$txt_edit_doc."', 
            activity = '".$txt_edit_act."', 
            description = '".$txt_edit_desc."' 
        WHERE id = '".$txt_id."'") or die('Error: ' . mysqli_error($con));

    if(isset($_SESSION['role'])) {
        $action = 'Updated Activity '.$txt_edit_act;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user, logdate, action) 
            VALUES ('".$_SESSION['role']."', NOW(), '".$action."')");
    }

    // Handle file uploads for editing
    $image_name = '';
    if(isset($_FILES['txt_edit_files'])) {
        $tmp_name = $_FILES['txt_edit_files']['tmp_name'][0]; // Assuming one file upload
        if ($tmp_name) {
            $target = "photo/";
            $milliseconds = round(microtime(true) * 1000);
            $image_name = $milliseconds . $_FILES['txt_edit_files']['name'][0];
            $target .= $image_name;

            if(!move_uploaded_file($tmp_name, $target)){
                die('Error uploading file');
            }

            // Update the activity with the new image
            $update_image_query = mysqli_query($con,"UPDATE tblactivity SET image = '$image_name' WHERE id = '".$txt_id."'") or die('Error: ' . mysqli_error($con));
        }
    }

    if($update_query) {
        $_SESSION['edited'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_delete'])) {
    if(isset($_POST['chk_delete'])) {
        foreach($_POST['chk_delete'] as $value) {
            $delete_query = mysqli_query($con,"DELETE from tblactivity where id = '$value' ") or die('Error: ' . mysqli_error($con));
                    
            if($delete_query == true) {
                $_SESSION['delete'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
            }
        }
    }
}

// Remaining code for managing photos follows...
?>
