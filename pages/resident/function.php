<?php
if(isset($_POST['btn_add'])){
    $txt_lname = mysqli_real_escape_string($con, $_POST['txt_lname']);
    $txt_fname = mysqli_real_escape_string($con, $_POST['txt_fname']);
    $txt_mname = mysqli_real_escape_string($con, $_POST['txt_mname']);
    $ddl_gender = mysqli_real_escape_string($con, $_POST['ddl_gender']);
    $ddl_type = mysqli_real_escape_string($con, $_POST['ddl_type']);
    $txt_bdate = mysqli_real_escape_string($con, $_POST['txt_bdate']);
    $has_boat = mysqli_real_escape_string($con, $_POST['has_boat']);
    $boat_number = mysqli_real_escape_string($con, $_POST['boat_number']);

    // Age calculation
    $dateOfBirth = $txt_bdate;
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $txt_age = $diff->format('%y');

    $txt_brgy = mysqli_real_escape_string($con, $_POST['txt_brgy']);
    $txt_zone = mysqli_real_escape_string($con, $_POST['txt_zone']);
    $txt_cpnumber = mysqli_real_escape_string($con, $_POST['txt_cpnumber']);
    $txt_hnumber = mysqli_real_escape_string($con, $_POST['txt_hnumber']);

    $name = basename($_FILES['txt_image']['name']);
    $temp = $_FILES['txt_image']['tmp_name'];
    $imagetype = $_FILES['txt_image']['type'];
    $size = $_FILES['txt_image']['size'];

    $milliseconds = round(microtime(true) * 1000);
    $image = $milliseconds.'_'.$name;

    if(isset($_SESSION['username'])){
        $action = 'Added Member named '.$txt_lname.', '.$txt_fname.' '.$txt_mname;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) VALUES ('".$_SESSION['username']."', NOW(), '".$action."')");
    }

    $su = mysqli_query($con, "SELECT * from tblresident WHERE lname = '$txt_lname' AND fname = '$txt_fname' AND mname = '$txt_mname' ");
    $ct = mysqli_num_rows($su);
    
    if($ct == 0){

        if($name != ""){
            if(($imagetype=="image/jpeg" || $imagetype=="image/png" || $imagetype=="image/bmp") && $size<=2048000){
                if(move_uploaded_file($temp, 'image/'.$image)) {
                    $txt_image = $image;
                    $query = mysqli_query($con, "INSERT INTO tblresident (
                                        lname,
                                        fname,
                                        mname,
                                        bdate,
                                        age,
                                        barangay,
                                        zone,
                                        hnumber,
                                        gender,
                                        cpnumber,
                                        type,
                                        has_boat,
                                        boat_number,
                                        image
                                    ) 
                                    VALUES (
                                        '$txt_lname', 
                                        '$txt_fname', 
                                        '$txt_mname',  
                                        '$txt_bdate', 
                                        '$txt_age',
                                        '$txt_brgy',
                                        '$txt_zone',
                                        '$txt_hnumber',
                                        '$ddl_gender', 
                                        '$txt_cpnumber',
                                        '$ddl_type', 
                                        '$has_boat',
                                        '$boat_number',
                                        '$txt_image'
                                    )") 
                            or die('Error: ' . mysqli_error($con));
                }
            } else {
                $_SESSION['filesize'] = 1; 
                header("location: ".$_SERVER['REQUEST_URI']);
            }
        } else {
            $txt_image = 'default.png';
            $query = mysqli_query($con, "INSERT INTO tblresident (
                                        lname,
                                        fname,
                                        mname,
                                        bdate,
                                        age,
                                        barangay,
                                        zone,
                                        hnumber,
                                        gender,
                                        cpnumber,
                                        type,
                                        has_boat,
                                        boat_number,
                                        image
                                    ) 
                                    VALUES (
                                        '$txt_lname', 
                                        '$txt_fname', 
                                        '$txt_mname',  
                                        '$txt_bdate', 
                                        '$txt_age',
                                        '$txt_brgy',
                                        '$txt_zone',
                                        '$txt_hnumber',
                                        '$ddl_gender', 
                                        '$txt_cpnumber',
                                        '$ddl_type', 
                                        '$has_boat',
                                        '$boat_number',
                                        '$txt_image'
                                    )") 
                            or die('Error: ' . mysqli_error($con));
        }
        
        if($query == true) {
            $_SESSION['added'] = 1;
            header("location: ".$_SERVER['REQUEST_URI']);
        }
    } else {
        $_SESSION['duplicate'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
    }    
}

if(isset($_POST['btn_save'])){
    $txt_id = mysqli_real_escape_string($con, $_POST['hidden_id']);
    $txt_edit_lname = mysqli_real_escape_string($con, $_POST['txt_edit_lname']);
    $txt_edit_fname = mysqli_real_escape_string($con, $_POST['txt_edit_fname']);
    $txt_edit_mname = mysqli_real_escape_string($con, $_POST['txt_edit_mname']);
    $txt_edit_bdate = mysqli_real_escape_string($con, $_POST['txt_edit_bdate']);
    $dateOfBirth = $txt_edit_bdate;
    $today = date("Y-m-d");
    $diff = date_diff(date_create($dateOfBirth), date_create($today));
    $txt_edit_age = $diff->format('%y');
    $txt_edit_brgy = mysqli_real_escape_string($con, $_POST['txt_edit_brgy']);
    $txt_edit_zone = mysqli_real_escape_string($con, $_POST['txt_edit_zone']);
    $txt_edit_hnumber = mysqli_real_escape_string($con, $_POST['txt_edit_hnumber']);
    $txt_edit_cpnumber = mysqli_real_escape_string($con, $_POST['txt_edit_cpnumber']);
    $ddl_edit_gender = mysqli_real_escape_string($con, $_POST['ddl_edit_gender']);
    $ddl_edit_type = mysqli_real_escape_string($con, $_POST['ddl_edit_type']);
    $edit_has_boat = mysqli_real_escape_string($con, $_POST['edit_has_boat']);
    $edit_boat_number = mysqli_real_escape_string($con, $_POST['edit_boat_number']);


    // File upload logic
    $name = basename($_FILES['txt_edit_image']['name']);
    $temp = $_FILES['txt_edit_image']['tmp_name'];
    $imagetype = $_FILES['txt_edit_image']['type'];
    $size = $_FILES['txt_edit_image']['size'];
    $milliseconds = round(microtime(true) * 1000);
    $image = $milliseconds.'_'.$name;

    if(isset($_SESSION['username'])){
        $action = 'Updated Member named '.$txt_edit_lname.', '.$txt_edit_fname.' '.$txt_edit_mname;
        $iquery = mysqli_query($con, "INSERT INTO tbllogs (user,logdate,action) VALUES ('".$_SESSION['username']."', NOW(), '".$action."')");
    }

    if($name != "") {
        if(($imagetype == "image/jpeg" || $imagetype == "image/png" || $imagetype == "image/bmp") && $size <= 2048000) {
            if(move_uploaded_file($temp, 'image/'.$image)) {
                $txt_edit_image = $image;
            }
        } else {
            $_SESSION['filesize'] = 1; 
            header("location: ".$_SERVER['REQUEST_URI']);
        }
    } else {
        // Fetch existing image if not updating
        $chk_image = mysqli_query($con,"SELECT image FROM tblresident WHERE id = '$txt_id'");
        $rowimg = mysqli_fetch_array($chk_image);
        $txt_edit_image = $rowimg['image'];
    }

    // Update only relevant fields
    $update_query = mysqli_query($con, "UPDATE tblresident SET 
        lname = '".$txt_edit_lname."',
        fname = '".$txt_edit_fname."',
        mname = '".$txt_edit_mname."',
        bdate = '".$txt_edit_bdate."',
        age = '".$txt_edit_age."',
        barangay = '".$txt_edit_brgy."',
        zone = '".$txt_edit_zone."',
        hnumber = '".$txt_edit_hnumber."',
        cpnumber = '".$txt_edit_cpnumber."',
        gender = '".$ddl_edit_gender."',
        type = '".$ddl_edit_type."',
        image = '".$txt_edit_image."',
        has_boat = '$edit_has_boat',
        boat_number = '$edit_boat_number'
        WHERE id = '".$txt_id."'
    ") or die('Error: ' . mysqli_error($con));

    if($update_query == true){
        $_SESSION['edited'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['btn_archive'])){
    if(isset($_POST['chk_delete'])){
        foreach($_POST['chk_delete'] as $value){
            $archive_query = mysqli_query($con, "UPDATE tblresident SET archive = 1 WHERE id = '$value'") or die('Error: ' . mysqli_error($con));
                    
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
            $archive_query = mysqli_query($con, "UPDATE tblresident SET archive = 0 WHERE id = '$value'") or die('Error: ' . mysqli_error($con));
                    
            if($archive_query == true){
                $_SESSION['unarchive'] = 0;
                header("location: ".$_SERVER['REQUEST_URI']);
            }
        }
    }
}
?>