<?php
echo '<header class="header">
         <a href="../home/home.php" class="logo">
             <img class="icon" src="../../img/bfarmc-sinalhan-logo.png" alt="BFARMC - SINALHAN Logo" style="height: 55px; margin-right: 10px;">
             BFARMC
         </a>
         <nav class="navbar navbar-static-top" role="navigation">
             <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                 <span class="sr-only">Toggle navigation</span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
             </a>
             <div class="navbar-right">
                 <ul class="nav navbar-nav">
                     <li class="dropdown user user-menu">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                             <i class="bx bxs-user-circle"></i><span><i class="caret"></i></span>
                         </a>
                         <ul class="dropdown-menu">
                             <li class="user-header bg-light-blue">
                                 <div class="circle-2"><i class="bx bxs-user"></i></div>
                                 <p>' . $_SESSION['username'] . '<br>
                                     <span class="role">' . $_SESSION['role'] . '</span>
                                 </p>
                             </li>
                             <li class="user-footer">
                                 <div class="user-btn-1">
                                     <a href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#editProfileModal"><i class="fa-solid fa-unlock"></i> <span> Change Password </span> </a>
                                 </div>
                                 <div class="user-btn-2">
                                     <a href="../../logout.php" class="btn btn-default btn-flat"> <i class="fa-solid fa-arrow-right-from-bracket"></i> <span> Sign out <span> </a>
                                 </div>
                             </li>
                         </ul>
                     </li>
                 </ul>
             </div>
         </nav>
     </header>';
?>

<div id="editProfileModal" class="modal fade">
    <form method="post" onsubmit="return validatePasswords()">
        <div class="modal-dialog modal-sm" style="width:300px !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Password</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label style="color: #0605a6;">Old Password:</label>
                        <input name="old_password" id="old_password" class="form-control input-sm" type="password" required />
                    </div>
                    <div class="form-group">
                        <label style="color: #0605a6;">New Password:</label>
                        <input name="new_password" id="new_password" class="form-control input-sm" type="password" required />
                    </div>
                    <div class="form-group">
                        <label style="color: #0605a6;">Confirm New Password:</label>
                        <input name="confirm_password" id="confirm_password" class="form-control input-sm" type="password" required />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="btn_saveeditProfile">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>


<?php

include "../mismatch_notif.php";

if (isset($_POST['btn_saveeditProfile'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the current hashed password from the database
    $userQuery = mysqli_query($con, "SELECT password FROM tbluser WHERE id = '" . $_SESSION['userid'] . "'");
    $userData = mysqli_fetch_assoc($userQuery);

    // Verify that the old password is correct
    if ($userData && password_verify($old_password, $userData['password'])) {
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Update the password in the database
            $updateQuery = "UPDATE tbluser SET password = '$hashed_new_password' WHERE id = '" . $_SESSION['userid'] . "'";
            if (mysqli_query($con, $updateQuery)) {
                $_SESSION['edited'] = 1;
                header("location: ".$_SERVER['REQUEST_URI']);
                exit();
            } else {
                $_SESSION['error'] = 1;
               header("location: ".$_SERVER['REQUEST_URI']);
                exit();
            }
        } else {
            $_SESSION['password_mismatch'] = 1;
            header("location: ".$_SERVER['REQUEST_URI']);
            exit();
        }
    } else {
        $_SESSION['old_mismatch'] = 1;
            header("location: ".$_SERVER['REQUEST_URI']);
            exit();
    }
}
?>