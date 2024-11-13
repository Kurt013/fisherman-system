<?php
    echo '
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">

                <div class="user-details"> 
                    <div class="circle"><i class="bx bxs-user"></i></div>
                    <div class="user-group">
                        <h1 class="user-role">' . $_SESSION['username'] . ' <br> <span class="role">'. $_SESSION['role'] .'</span> </h1>
                    </div>
                    
                    <div class="down">
                </div>
            </div>
            </div>
            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            ';

            // Check if the role is Administrator
            if ($_SESSION['role'] == "administrator") {
                echo '
                <ul class="sidebar-menu">
                     <li>
                        <a href="../home/home.php">
                           <i class="fa fa-house"></i> <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="../dashboard/dashboard.php">
                            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../officials/officials.php">
                            <i class="fa fa-user"></i> <span>BFARMC Officer</span>
                        </a>
                    </li>
                    <li>
                        <a href="../resident/resident.php">
                            <i class="fa fa-users"></i> <span>Members</span>
                        </a>
                    </li>
                    <li>
                        <a href="../activity/activity.php">
                            <i class="fa fa-calendar"></i> <span>Activity</span>
                        </a>
                    </li>
                    <li>
                        <a href="../staff/staff.php">
                            <i class="fa fa-user"></i> <span>Staff</span>
                        </a>
                    </li>
                    <li>
                        <a href="../logs/logs.php">
                            <i class="fa fa-history"></i> <span>Logs</span>
                        </a>
                    </li>
                    <li>
                        <a href="../qrscanner/qrscanner.php">
                            <i class="fa fa-qrcode"></i> <span>Qr Scanner</span>
                        </a>
                    </li>
                </ul>';
            }
            // Check if the role is Staff
            elseif (isset($_SESSION['role']) && $_SESSION['role'] == "staff") { // Correct the check to 'role'
                echo '
                <ul class="sidebar-menu">
                <li>
                        <a href="../home/home.php">
                            <i class="fa fa-house"></i> <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="../officials/officials.php">
                            <i class="fa fa-user"></i> <span>BFARMC Officer</span>
                        </a>
                    </li>
                    <li>
                        <a href="../resident/resident.php">
                            <i class="fa fa-users"></i> <span>Members</span>
                        </a>
                    </li>
                    <li>
                        <a href="../activity/activity.php">
                            <i class="fa fa-calendar"></i> <span>Activity</span>
                        </a>
                    </li>
                    <li>
                        <a href="../qrscanner/qrscanner.php">
                            <i class="fa fa-qrcode"></i> <span>Qr Scanner</span>
                        </a>
                    </li>
                </ul>';
            }

            echo '
            </section>
            <!-- /.sidebar -->
        </aside>
    ';
?>
