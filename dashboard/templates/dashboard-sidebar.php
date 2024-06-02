<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?=$websiteURL.'/dashboard/index.php';?>" class="brand-link logo-switch">
        <img src="<?=$websiteURL.'/assets/img/key.png'?>" alt="MasterKey Key Logo" class="brand-image">
        <span class="brand-text font-weight-light">MasterKey</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php echo get_profile_pic_html_code($user, "img-circle img-fluid elevation-3", 64, "$websiteURL/assets/img/avatars/user.png"); ?>
            </div>
            <div class="info fsize-120">
                <a href="#" class="d-block"><?=$user["username"]?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu">
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item">
                    <a href="<?=$websiteURL?>/dashboard/index.php" class="nav-link">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>Main Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteURL?>/dashboard/account.php" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>Accounts</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteURL?>/dashboard/profile.php" class="nav-link">
                        <i class="nav-icon fas fa-portrait"></i>
                        <p>Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteURL?>/dashbaord/settings.php" class="nav-link">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li class="nav-header">DETAILS</li>
                <li class="nav-item">
                    <a href="<?=$websiteURL?>/about.php" class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>About</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteURL?>/contact.php" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>Contact</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?=$websiteURL?>/privacy.php" class="nav-link">
                        <i class="nav-icon fas fa-shield-alt"></i>
                        <p>Privacy</p>
                    </a>
                </li>
                <li class="nav-header">EXIT</li>
                <li class="nav-item">
                    <a href="<?=$websiteURL?>/dashboard/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>