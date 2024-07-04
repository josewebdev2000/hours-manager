<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?=$websiteUrl.'/dashboard/index.php';?>" class="brand-link logo-switch">
        <img src="<?=$websiteUrl.'/assets/img/chronometer-128px.png'?>" alt="MasterKey Key Logo" class="brand-image">
        <span class="brand-text font-weight-light">HoursManager</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php echo get_profile_pic_html_code($user, "img-circle img-fluid elevation-3", 64, "$websiteUrl/assets/img/avatars/user.png"); ?>
            </div>
            <div class="info fsize-120">
                <a href="#" class="d-block"><?=$user["name"]?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu">
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>dashboard/index.php" class="nav-link">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>dashboard/jobs.php" class="nav-link">
                        <i class="nav-icon fas fa-suitcase"></i>
                        <p>Jobs</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>dashboard/work-shifts.php" class="nav-link">
                        <i class="nav-icon fas fa-business-time"></i>
                        <p>Work Shifts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>dashboard/profile.php" class="nav-link">
                        <i class="nav-icon fas fa-portrait"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>dashboard/calculation.php" class="nav-link">
                        <i class="nav-icon fas fa-calculator"></i>
                        <p>Calculations</p>
                    </a>
                </li>
                <li class="nav-header">DETAILS</li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>about.php" class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>About</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>contact.php" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Contact</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>privacy.php" class="nav-link">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>Privacy</p>
                    </a>
                </li>
                <li class="nav-header">EXIT</li>
                <li class="nav-item">
                    <a href="<?=$websiteUrl?>dashboard/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<style>
    .main-sidebar {
        left: 0;
        height: 100%;
        width: 250px; /* Adjust the width as needed */
        background-color: #343a40; /* Ensure the background color matches your theme */
    }
</style>
