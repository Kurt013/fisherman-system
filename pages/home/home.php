<!DOCTYPE html>
<html>

<head>
    <?php
    session_start();
    if (!isset($_SESSION['role'])) {
        header("Location: ../../index.php"); 
        exit(); // Make sure to exit after redirect
    }
    ob_start();
    include('../head_css.php'); ?>
    <!-- Include Instascan Library -->
    <link rel="stylesheet" type="text/css" href="../../css/home.css">
</head>

<body class="skin-blue">
    <?php 
    include "../connection.php";
    include('../header.php'); 
    ?>

    <div class="wrapper row-offcanvas row-offcanvas-left">
        <?php include('../sidebar-left.php'); ?>

        <aside class="right-side">
            <section class="content-header">
            <h1><i class="fa-solid fa-house"></i> <span>Home</span></h1>
            </section>
            <div class="desc-content">
                <div class="content-wrapper">
                    <div class="homepage-images">
                        <img class="resort-image" src="../../img/bfarmc-sinalhan-logo.png" alt="resort-place">
                    </div>

                   
                        
                    <div class="text-wrapper">
                        <h1>Hello, 
                            <?php 
                            echo ($_SESSION['role'] == 'administrator') ? 
                                "<span style='color: #F4D248;'>{$_SESSION['role']}!</span>" : 
                                "<span style='color: #52C8C8;'>{$_SESSION['role']}!</span>"; 
                            ?>
                        </h1>
                        <p>Let's get started! Feel free to explore and stay updated by clicking on the sections below:</p>
                        <div>
                        <div class="redirect-button-container"> <!-- Added container for buttons -->
                        <?php 
                        if ($_SESSION['role'] == 'administrator') {
                            echo '<a href="../dashboard/dashboard.php" class="redirect-button">
                                <span class="icon"><i class="fa fa-dashboard"></i></span> <span>Dashboard</span>
                            </a>';
                        } 
                        ?>
                        <a href="../officials/officials.php" class="redirect-button">                           
                            <span class="icon"><i class="fa fa-user"></i></span> <span>BFARMC Officials</span>
                        </a>
                        <a href="../resident/resident.php" class="redirect-button">
                            <span class="icon"><i class="fa fa-users"></i></span> <span>Members</span>
                        </a>
                        <a href="../activity/activity.php" class="redirect-button">
                            <span class="icon"><i class="fa fa-calendar"></i></span> <span>Activity</span>
                        </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            
            <?php include "../footer.php"; ?>
        </aside>
    </div>
</body>
</html>
