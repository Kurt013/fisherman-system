<?php
if(isset($_POST['btn_add'])){
    $ddl_pos = $_POST['ddl_pos'];
    $txt_cname = $_POST['txt_cname'];
    $txt_contact = $_POST['txt_contact'];
    $txt_address = $_POST['txt_address'];
    $txt_sterm = $_POST['txt_sterm'];
    $txt_eterm = $_POST['txt_eterm'];

    if(isset($_SESSION['username'])){
        $action = 'Added Official named '.$txt_cname;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) values ('".$_SESSION['username']."', NOW(), '".$action."')");
    }

    $q = mysqli_query($con,"SELECT * from tblofficial where completeName = '".$txt_cname."'");
    $ct = mysqli_num_rows($q);


    if($ct == 0){
        $query = mysqli_query($con,"INSERT INTO tblofficial (sPosition,completeName,pcontact,paddress,termStart,termEnd,status) 
        values ('$ddl_pos', '$txt_cname', '$txt_contact', '$txt_address', '$txt_sterm', '$txt_eterm', 'Ongoing Term')") or die('Error: ' . mysqli_error($con));
        if($query == true)
        {
            $_SESSION['added'] = 1;
            header ("location: ".$_SERVER['REQUEST_URI']);
        }   
    }
    else{
        $_SESSION['duplicate'] = 1;
        header ("location: ".$_SERVER['REQUEST_URI']);
    }
    
}


if(isset($_POST['btn_save']))
{
    $txt_id = $_POST['hidden_id'];
    $ddl_edit_pos = $_POST['ddl_edit_pos'];
    $txt_edit_cname = $_POST['txt_edit_cname'];
    $txt_edit_contact = $_POST['txt_edit_contact'];
    $txt_edit_address = $_POST['txt_edit_address'];
    $txt_edit_sterm = $_POST['txt_edit_sterm'];
    $txt_edit_eterm = $_POST['txt_edit_eterm'];


    if(isset($_SESSION['username'])){
        $action = 'Update Official named '.$txt_edit_cname;
        $iquery = mysqli_query($con,"INSERT INTO tbllogs (user,logdate,action) values ('".$_SESSION['username']."', NOW(), '".$action."')");
    }

    $update_query = mysqli_query($con,"UPDATE tblofficial set sPosition = '".$ddl_edit_pos."', completeName = '".$txt_edit_cname."', pcontact = '".$txt_edit_contact."', paddress = '".$txt_edit_address."', termStart = '".$txt_edit_sterm."', termEnd = '".$txt_edit_eterm."' where id = '".$txt_id."' ") or die('Error: ' . mysqli_error($con));

    if($update_query == true){
        $_SESSION['edited'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['btn_end']))
{

    $txt_id = $_POST['hidden_id'];

    $end_query = mysqli_query($con,"UPDATE tblofficial set status = 'End Term' where id = '$txt_id' ") or die('Error: ' . mysqli_error($con));

    if($end_query == true){
        $_SESSION['end'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['btn_start']))
{

    $txt_id = $_POST['hidden_id'];

    $start_query = mysqli_query($con,"UPDATE tblofficial set status = 'Ongoing Term' where id = '$txt_id' ") or die('Error: ' . mysqli_error($con));

    if($start_query == true){
        $_SESSION['start'] = 1;
        header("location: ".$_SERVER['REQUEST_URI']);
    }
}

if(isset($_POST['btn_archive'])){
    if(isset($_POST['chk_delete'])){
        foreach($_POST['chk_delete'] as $value){
            $archive_query = mysqli_query($con, "UPDATE tblofficial SET archive = 1 WHERE id = '$value'") or die('Error: ' . mysqli_error($con));
                    
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
            $archive_query = mysqli_query($con, "UPDATE tblofficial SET archive = 0 WHERE id = '$value'") or die('Error: ' . mysqli_error($con));
                    
            if($archive_query == true){
                $_SESSION['unarchive'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
            }
        }
    }
}
?>