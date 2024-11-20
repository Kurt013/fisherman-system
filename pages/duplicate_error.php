<?php if(isset($_SESSION['duplicate'])){
    echo '<script>$(document).ready(function (){duplicate();});</script>';
    unset($_SESSION['duplicate']);
    } 
echo '<div class="alert alert-duplicate alert-autocloseable-duplicate" style="color: #fff; background: #d9534f; position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
     Member/Officer Already Exist!
</div>';
?>

<?php if(isset($_SESSION['duplicateuser'])){
    echo '<script>$(document).ready(function (){duplicateuser();});</script>';
    unset($_SESSION['duplicateuser']);
    } 
echo '<div class="alert alert-duplicateuser alert-autocloseable-duplicateuser" style="color: #fff; background: #d9534f; position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
     Username Already Exists!
</div>';
?>

<?php if(isset($_SESSION['duplicateemail'])){
    echo '<script>$(document).ready(function (){duplicateuser();});</script>';
    unset($_SESSION['duplicateemail']);
    } 
echo '<div class="alert alert-duplicateemail alert-autocloseable-duplicateemail" style=" color: #fff; background: #d9534f; position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
     Email Already Exists!
</div>';
?>

<?php if(isset($_SESSION['end'])){
    echo '<script>$(document).ready(function (){end();});</script>';
    unset($_SESSION['end']);
    } 
echo '<div class="alert alert-end alert-autocloseable-end" style="background: #dff0d8; position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
     End Term Successfully!
</div>';
?>

<?php if(isset($_SESSION['start'])){
    echo '<script>$(document).ready(function (){start();});</script>';
    unset($_SESSION['start']);
    } 
echo '<div class="alert alert-start alert-autocloseable-start" style="background: #dff0d8; position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
     Continue Term Successfully!
</div>';
?>

<?php if(isset($_SESSION['filesize'])){
    echo '<script>$(document).ready(function (){filesize();});</script>';
    unset($_SESSION['filesize']);
    } 
echo '<div class="alert alert-filesize alert-autocloseable-filesize" style="color: #fff; background: #d9534f; position: fixed; top: 1em; right: 1em; z-index: 9999; display: none;">
     File size is greater than 2mb or Invalid Format !
</div>';
?>