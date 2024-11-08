<?php
if(isset($_POST['btn_add'])){
    $txt_fname = $_POST['txt_fname'];
    $txt_lname = $_POST['txt_lname'];
    $txt_email = $_POST['txt_email'];
    $txt_uname = $_POST['txt_uname'];
    $txt_pass = $_POST['txt_pass'];
    $txt_cpass = $_POST['txt_cpass'];
    $role = 'staff';

    // Check if username already exists
    $stmt = $con->prepare("SELECT * FROM tbluser WHERE username = ?");
    $stmt->bind_param("s", $txt_uname);
    $stmt->execute();
    $result = $stmt->get_result();
    $ct = $result->num_rows;

    if($ct == 0){
        // Check if passwords match
        if($txt_pass === $txt_cpass){
            // Hash the password
            $hashed_password = password_hash($txt_pass, PASSWORD_DEFAULT);

            // Insert new user
            $insert_stmt = $con->prepare("INSERT INTO tbluser (first_name, last_name, email, username, password, role) VALUES (?, ?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("ssssss", $txt_fname, $txt_lname, $txt_email, $txt_uname, $hashed_password, $role);
            $insert_query = $insert_stmt->execute();

            if($insert_query){
                $_SESSION['added'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
                exit();
            }
        } else {
            $_SESSION['password_mismatch'] = 1;
            header("location: ".$_SERVER['REQUEST_URI']);
            exit();
        }
    } else {
        $_SESSION['duplicateuser'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}


if(isset($_POST['btn_save']))
{
    $txt_id = $_POST['hidden_id'];
    $txt_edit_fname = $_POST['txt_edit_fname'];
    $txt_edit_lname = $_POST['txt_edit_lname'];
    $txt_edit_email = $_POST['txt_edit_email'];
    $txt_edit_uname = $_POST['txt_edit_uname'];
    $txt_edit_pass = $_POST['txt_edit_pass'];
    $txt_edit_cpass = $_POST['txt_edit_cpass'];
    $role = 'staff';

    // Check if username already exists (for other users, not the current one)
    $stmt = $con->prepare("SELECT * FROM tbluser WHERE username = ? AND id != ?");
    $stmt->bind_param("si", $txt_edit_uname, $txt_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $ct = $result->num_rows;
    
    if($ct == 0){
        // Check if passwords match
        if($txt_edit_pass === $txt_edit_cpass){
            $hashed_password = password_hash($txt_edit_pass, PASSWORD_DEFAULT);

            // Update user information
            $update_stmt = $con->prepare("UPDATE tbluser SET first_name = ?, last_name = ?, email = ?, username = ?, password = ? WHERE id = ?");
            $update_stmt->bind_param("sssssi", $txt_edit_fname, $txt_edit_lname, $txt_edit_email, $txt_edit_uname, $hashed_password, $txt_id);
            $update_query = $update_stmt->execute();

            if($update_query){
                $_SESSION['edited'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
                exit();
            }
        } else {
            $_SESSION['password_mismatch'] = 1;
            header("location: ".$_SERVER['REQUEST_URI']);
            exit();
        }
    } else {
        $_SESSION['duplicateuser'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
        exit();
    }
}

if(isset($_POST['btn_archive'])){
    if(isset($_POST['chk_delete'])){
        foreach($_POST['chk_delete'] as $value){
            $archive_query = mysqli_query($con, "UPDATE tbluser SET archive = 1 WHERE id = '$value'") or die('Error: ' . mysqli_error($con));
                    
            if($archive_query == true){
                $_SESSION['archive'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
            }
        }
    }
}

if(isset($_POST['btn_unarchive'])){
    if(isset($_POST['chk_unarchive'])){
        foreach($_POST['chk_unarchive'] as $value){
            $archive_query = mysqli_query($con, "UPDATE tbluser SET archive = 0 WHERE id = '$value'") or die('Error: ' . mysqli_error($con));
                    
            if($archive_query == true){
                $_SESSION['unarchive'] = 0;
                header("location: ".$_SERVER['REQUEST_URI']);
            }
        }
    }
}
?>